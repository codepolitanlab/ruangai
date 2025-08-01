<?php

namespace App\Libraries;

use App\Models\UserModel;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthSSR
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
        $builder->select('users.id as id, role_slug, pwd');
        $builder->join('roles', 'users.role_id = roles.id');
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
        session()->set([
            'logged_in' => true,
            'user_id'   => $user['id'],
            'role_slug' => $user['role_slug'],
        ]);

        return ['success', '', $user];
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
