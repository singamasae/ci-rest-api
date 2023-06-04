<?php

use App\Models\UserModel;
use Config\Services;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


function getJWTFromRequest($authenticationHeader): string
{
    if (is_null($authenticationHeader)) {
        throw new Exception('Unauthorized access');
    }    
    return explode(' ', $authenticationHeader)[1];
}

function validateJWTFromRequest(string $encodedToken)
{
    $key = Services::getSecretKey();
    $decodedToken = JWT::decode($encodedToken, new Key($key, 'HS256'));
    // $userModel = new UserModel();
    // $userModel->findUserByUserName($decodedToken->username);
}

function getSignedJWTForUser(string $userName)
{
    $issuedAtTime = time();
    $tokenTimeToLive = getenv('JWT_TIME_TO_LIVE');
    $tokenExpiration = $issuedAtTime + $tokenTimeToLive;
    $payload = [
        'username' => $userName,
        'iat' => $issuedAtTime,
        'exp' => $tokenExpiration,
    ];

    $key = Services::getSecretKey();
    $jwt = JWT::encode($payload, $key, 'HS256');
    return $jwt;
}