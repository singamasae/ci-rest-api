<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class AuthController extends BaseController {
    use ResponseTrait;

    public function auth() {
        $rules = [
            'username' => 'required|min_length[6]|max_length[50]',            
            'password' => 'required|min_length[8]|max_length[255]',
        ];

        if (!$this->validate($rules)) {
            $response = [
                'success' => false,                
                'message' => $this->validator->getErrors()
            ];
            return $this->respond($response, ResponseInterface::HTTP_BAD_REQUEST);
        }

        $userName = $this->request->getVar('username');
        $password = $this->request->getVar('password');

        $userModel = new UserModel();
        $user = $userModel->findUserByUserName($userName);
        if (!$user) {
            $response = [
                'success' => false,                
                'message' => 'User not found'
            ];
            return $this->respond($response, ResponseInterface::HTTP_OK);
        }

        $verified = password_verify($password, $user['password']);
        if(!$verified) {
            $response = [
                'success' => false,                
                'message' => 'Invalid username or password'
            ];
            return $this->respond($response, ResponseInterface::HTTP_UNAUTHORIZED);
        }

        unset($user['password']);
        helper('jwt');
        $response = [
            'success' => true,                
            'data' => $user,
            'access_token' => getSignedJWTForUser($userName)
        ];
        return $this->respond($response , ResponseInterface::HTTP_OK); 

    }
}