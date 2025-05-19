<?php

namespace App\Libraries;

use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth
{
    /**
     * Login user
     * 
     * @param string $identity
     * @param string $password
     * @param array $identity_type default ['email']
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
                $builder->where($field, $identity);
            } else {
                $builder->orWhere($field, $identity);
            }
        }
        $builder->groupEnd(); // Tutup grup OR

        $query = $builder->get();
        $user = $query->getRowArray();

        if (!$user) {
            return ['failed', 'Email atau password salah.', []];
        }

        $Phpass = new \App\Libraries\Phpass();
        if (!$Phpass->CheckPassword($password, $user['pwd'])) {
            return ['failed', 'Email atau password salah.', []];
        }

        $userModel->update($user['id'], ['last_active' => date('Y-m-d H:i:s')]);

        // Buat token
        $user['jwt'] = JWT::encode([
            'email'           => $user['email'],
            'whatsapp_number' => $user['phone'],
            'user_id'         => $user['id'],
            'isValidEmail'    => $user['email_valid'],
            'exp'             => time() + 7 * 24 * 60 * 60
        ], config('Heroic')->jwtKey['secret'], 'HS256');

        return ['success', '', $user];
    }

    public function instantLogin($token)
    {
        try {
            $decodedToken = $this->checkToken("Bearer " . $token);   
        } catch (\Exception $e) {
            return ['failed', $e->getMessage(), []];
        }

        $userModel = new UserModel();
        $user = $userModel->find($decodedToken['user_id']);
        $user['jwt'] = $token;

        return ['success', '', $user];
    }

    public function checkToken($token = null, $getUserData = false)
	{
		$headers = getallheaders();
		$request = service('request');
		$response = service('response');

		$token = $token ?? $headers['Authorization'] ?? $request->getGet('authorization') ?? null;

        try {
            $decodedToken = $this->validateToken($token);
            $decodedToken = (array) $decodedToken;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }

		if($getUserData) {
			// Get user data from database
			$db = \Config\Database::connect();
			$user = $db->table('users')
				->select('role_id, role_slug, name, username, email, avatar, phone')
				->join('roles', 'users.role_id = roles.id')
				->where('users.id', $decodedToken['user_id'])
				->get()
				->getRowArray();

			$decodedToken['user'] = $user;
		}

		return $decodedToken;
	}

    /**
	 * Check User's JWT Token
	 */
	public function validateToken($token = null)
	{
		if(! $token) {
			throw new \Exception('Authorization token not found');
		}
		
        // Separate 'Bearer '
		$jwt = explode(' ', $token)[1] ?? null;
        
		if (! $jwt) {
            throw new \Exception('Authorization token not found', 401);
		}
        
		try {
            $key = config('Heroic')->jwtKey['secret'];
			$decodedToken = JWT::decode($jwt, new Key($key, 'HS256'));
		} catch (\Exception $e){
            throw new \Exception('Invalid token', 401);
		}
		
		if (! $decodedToken) {				
            throw new \Exception('Authorization token not found', 401);
		}

		return $decodedToken;
	}
}
