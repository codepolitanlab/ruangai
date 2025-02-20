<?php

namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use PHPMailer\PHPMailer\PHPMailer;

class Heroic {

    /**
     * Get database name of pesantren by kodepesantren
     */
    public function initDBPesantren()
	{
		// Get header kodepesantren
        $headers = getallheaders();
        $kodePesantrenHashed = $headers['Pesantrenku-Id'] ?? $_GET['pesantrenID'] ?? $_GET['pid'] ?? null;

		if(! $kodePesantrenHashed){
			return false;
		}

		$Encrypter = service('encrypter');
		$dbname = $Encrypter->decrypt(hex2bin($kodePesantrenHashed));
		
		// Use database client
		$db = db_connect();
		$db->setDatabase($dbname);

		return $db;
	}
    
	/**
     * Get database name of pesantren by kodepesantren
     */
    public function initDBTarbiyya()
	{
		$db = db_connect();
		$db->setDatabase('tarbiyya');

		return $db;
	}

	/**
	 * Check user token
	 */
	public function checkToken()
	{
		$headers = getallheaders();
		$request = service('request');
		$response = service('response');

		$token = $headers['Authorization'] ?? $request->getGet('authorization') ?? null;

		if(! $token) {
			$response->setStatusCode(401, 'Authorization token not found')->send();
			exit;
		}

		$jwt = explode(' ', $token)[1] ?? null;

		if (! $jwt) {
			$response->setStatusCode(401, 'Authorization token not found')->send();
			exit; 
		}
			
		try {
			$key = config('Heroic')->jwtKey['secret'];
			$decodedToken = JWT::decode($jwt, new Key($key, 'HS256'));
		} catch (\Exception $e){
			$response->setStatusCode(401, 'Invalid token')->send();
			exit;
		}
		
		if (! $decodedToken) {				
			$response->setStatusCode(401, 'Authorization token not found')->send();
			exit;
		}

		return $decodedToken;
	}

	public function getUserToken()
	{
		$headers = getallheaders();
		$request = service('request');
		$response = service('response');

		$token = $headers['Authorization'] ?? $request->getGet('authorization') ?? null;

		if(! $token) {
			return [];
		}

		$jwt = explode(' ', $token)[1] ?? null;
		if (! $jwt) {
			return [];
		}
			
		try {
			$key = config('Heroic')->jwtKey['secret'];
			$decodedToken = JWT::decode($jwt, new Key($key, 'HS256'));
			if (! $decodedToken) {				
				return [];
			}
		} catch (\Exception $e){
			return [];
		}

		return $decodedToken;
	}

	public function normalizePhoneNumber($phone)
	{
		$phone = substr($phone, 0, 1)=='0' 
			? substr_replace($phone, '62', 0, 1) 
			: $phone;
		if(substr($phone, 0, 1)=='8') 
			$phone = '62'.$phone;

		return $phone;
	}

	public function sendWhatsapp($phone, $message) 
    {
		// Make sure the number begin with 62
		$phone = $this->normalizePhoneNumber($phone);
		
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL 			=> 'https://app.saungwa.com/api/create-message',
            CURLOPT_RETURNTRANSFER 	=> true,
            CURLOPT_ENCODING 		=> '',
            CURLOPT_MAXREDIRS 		=> 10,
            CURLOPT_TIMEOUT 		=> 0,
            CURLOPT_FOLLOWLOCATION 	=> true,
            CURLOPT_HTTP_VERSION 	=> CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST 	=> 'POST',
            CURLOPT_POSTFIELDS 		=> [
				'sandbox' 	=> 'false',
            	'appkey'	=> config('Heroic')->saungWA['appKey'],
            	'authkey'	=> config('Heroic')->saungWA['authKey'],
            	'to' 		=> $phone,
            	'message'	=> $message,
			],
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }

	public function sendEmail($to, $subject, $message, $debug = 0)
	{
		$mail = new PHPMailer($debug ? true : false);
		$EmailConfig = new \Config\Email;
		try {
			$mail->SMTPDebug = $debug;
			$mail->isSMTP();
			$mail->Host       = $EmailConfig->SMTPHost;
			$mail->SMTPAuth   = true;
			$mail->Username   = $EmailConfig->SMTPUser;
			$mail->Password   = $EmailConfig->SMTPPass;
			$mail->SMTPSecure = $EmailConfig->SMTPCrypto;
			$mail->Port       = $EmailConfig->SMTPPort;

			$mail->setFrom($EmailConfig->fromEmail, $EmailConfig->fromName);
			$mail->addAddress($to);
			$mail->isHTML(true);

			$mail->Subject = $subject;
			$mail->Body    = $message;
			
			$mail->send();
			return ['success' => true];
		} catch (\PHPMailer\PHPMailer\Exception $e) {
			return ['success' => false, 'message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"];
		}
	}
}
