<?php

namespace App\Libraries;

use App\Models\UserModel;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
    /**
     * Login user
     *
     * @param string $identity
     * @param string $password
     * @param array  $identity_type default ['email']
     *
     * @return array [$status, $message, $user]
     */
    public function login($identity, $password, array $identity_type = ['email'])
    {
        $userModel = new UserModel();

        // Bangun query untuk OR kondisi
        $builder = $userModel->builder();
        $builder->where('deleted_at', null);

        // Tambahkan kondisi OR untuk setiap identity_type
        $builder->groupStart(); // Mulai grup OR

        foreach ($identity_type as $index => $field) {
            if ($index === 0) {
                $builder->where('LOWER(' . $field . ')', strtolower($identity));
            } else {
                $builder->orWhere('LOWER(' . $field . ')', strtolower($identity));
            }
        }
        $builder->groupEnd(); // Tutup grup OR

        $query = $builder->get();
        $user  = $query->getRowArray();

        if (! $user) {
            return ['failed', 'Email atau password salah.', []];
        }

        $Phpass = new \App\Libraries\Phpass();
        if (! $Phpass->CheckPassword($password, $user['pwd'])) {
            return ['failed', 'Email atau password salah.', []];
        }

        $userModel->update($user['id'], ['last_active' => date('Y-m-d H:i:s')]);

        // Buat token
        $user['jwt'] = JWT::encode([
            'email'           => strtolower($user['email']),
            'whatsapp_number' => $user['phone'],
            'user_id'         => $user['id'],
            'isValidEmail'    => $user['email_valid'],
            'exp'             => time() + 7 * 24 * 60 * 60,
        ], config('Heroic')->jwtKey['secret'], 'HS256');

        return ['success', '', $user];
    }

    public function loginAs($admin_email, $admin_password, $target_email)
    {
        $userModel = new UserModel();

        // 1. Autentikasi Admin yang melakukan "Login As"
        $admin_user = $userModel->where('LOWER(email)', strtolower($admin_email))
            ->where('deleted_at', null)
            ->first();

        if (! $admin_user) {
            return ['failed', 'Kredensial admin tidak valid.', []];
        }

        // Verifikasi password admin
        $Phpass = new \App\Libraries\Phpass();
        if (! $Phpass->CheckPassword($admin_password, $admin_user['pwd'])) {
            return ['failed', 'Kredensial admin tidak valid.', []];
        }

        // 2. Periksa hak akses admin
        if ($admin_user['role_id'] !== 1) {
            return ['failed', 'Anda tidak memiliki hak akses untuk melakukan tindakan ini.', []];
        }

        // 3. Cari Pengguna Target yang akan di-"Login As"
        $target_user = $userModel->where('LOWER(email)', strtolower($target_email))
            ->where('deleted_at', null)
            ->first();

        if (! $target_user) {
            return ['failed', 'Pengguna target dengan email yang dimasukkan tidak ditemukan.', []];
        }

        // Mencegah admin melakukan "login as" ke akunnya sendiri melalui fitur ini
        if ($admin_user['id'] === $target_user['id']) {
            return ['failed', 'Tidak dapat menggunakan fitur "Login As" untuk akun Anda sendiri.', []];
        }

        // 4. Buat Sesi (JWT) untuk Pengguna Target
        $userModel->update($target_user['id'], ['last_active' => date('Y-m-d H:i:s')]);

        // Buat token JWT untuk sesi pengguna yang dituju.
        // Disarankan untuk memberikan waktu kedaluwarsa yang lebih singkat untuk sesi "login as".
        $target_user['jwt'] = JWT::encode([
            'email'           => strtolower($target_user['email']),
            'whatsapp_number' => $target_user['phone'],
            'user_id'         => $target_user['id'],
            'isValidEmail'    => $target_user['email_valid'],
            'is_login_as'     => true, // Penanda bahwa ini adalah sesi "Login As"
            'admin_user_id'   => $admin_user['id'], // Opsional: Menyimpan ID admin yang melakukan login
            'exp'             => time() + 2 * 60 * 60, // Token hanya berlaku 2 jam
        ], config('Heroic')->jwtKey['secret'], 'HS256');

        // Kembalikan status sukses beserta data pengguna target
        return ['success', 'Berhasil login sebagai ' . $target_user['name'], $target_user];
    }

    public function instantLogin($token)
    {
        try {
            $decodedToken = $this->checkToken('Bearer ' . $token);
        } catch (Exception $e) {
            return ['failed', $e->getMessage(), []];
        }

        $userModel   = new UserModel();
        $user        = $userModel->find($decodedToken['user_id']);
        $user['jwt'] = $token;

        return ['success', '', $user];
    }

    public function allowRoles(array $roles)
    {
        $user = $this->checkToken();

        return in_array($user['role_slug'], $roles, true);
    }

    public function checkToken($token = null, $getUserData = false)
    {
        $headers  = getallheaders();
        $request  = service('request');
        $response = service('response');

        $token ??= $headers['Authorization'] ?? $request->getGet('authorization') ?? null;

        try {
            $decodedToken = $this->validateToken($token);
            $decodedToken = (array) $decodedToken;
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }

        if ($getUserData) {
            // Get user data from database
            $db   = \Config\Database::connect();
            $user = $db->table('users')
                ->select('users.id, role_id, role_slug, name, username, LOWER(email), avatar, phone')
                ->join('roles', 'users.role_id = roles.id', 'left')
                ->where('users.id', $decodedToken['user_id'])
                ->get()
                ->getRowArray();

            $decodedToken['user'] = $user;
        }

        return $decodedToken;
    }

    /**
     * Check User's JWT Token
     *
     * @param mixed|null $token
     */
    public function validateToken($token = null)
    {
        if (! $token) {
            throw new Exception('Authorization token not found');
        }

        // Separate 'Bearer '
        $jwt = explode(' ', $token)[1] ?? explode(' ', $token)[0];

        if (! $jwt) {
            throw new Exception('Authorization token not found', 401);
        }

        try {
            $key          = config('Heroic')->jwtKey['secret'];
            $decodedToken = JWT::decode($jwt, new Key($key, 'HS256'));
        } catch (Exception $e) {
            throw new Exception('Invalid token', 401);
        }

        if (! $decodedToken) {
            throw new Exception('Authorization token not found', 401);
        }

        return $decodedToken;
    }
}
