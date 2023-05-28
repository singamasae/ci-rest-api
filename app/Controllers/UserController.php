<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;

class UserController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
        
        $userModel = new UserModel();        
        $data['success'] = True;
        $data['data'] = $userModel->findAllUsers();
        return $this->respond($data);
    }

    public function post() {
        $rules = [
            'username' => 'required|min_length[6]|max_length[50]|is_unique[users.username]',
            'name' => 'required',            
            'password' => 'required|min_length[8]|max_length[255]',
            'address' => 'required|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            $response = [
                'success' => False,                
                'message' => $this->validator->getErrors()
            ];
            return $this->respond($response, ResponseInterface::HTTP_BAD_REQUEST);
        }
        
        $data = [
            'username' => $this->request->getVar('username'),
            'name' => $this->request->getVar('name'),
            'password' => $this->request->getVar('password'),
            'address' => $this->request->getVar('address'),
        ];

        $userModel = new UserModel();
        $userModel->save($data);

        $response = [
            'success' => True,                
            'message' => 'User created successfully'
        ];
        return $this->respond($response , ResponseInterface::HTTP_CREATED);        
    }

    public function get($id) {
        $userModel = new UserModel();
        $user = $userModel->findUserById($id);
        if (!$user) {
            $response = [
                'success' => False,                
                'message' => 'User not found'
            ];
            return $this->respond($response, ResponseInterface::HTTP_OK);
        }

        $response = [
            'success' => True,                
            'data' => $user
        ];
        return $this->respond($response , ResponseInterface::HTTP_OK); 

    }

    public function put($id) {
        $rules = [            
            'name' => 'required',            
            'password' => 'required|min_length[8]|max_length[255]',
            'address' => 'required|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            $response = [
                'success' => False,                
                'message' => $this->validator->getErrors()
            ];
            return $this->respond($response, ResponseInterface::HTTP_BAD_REQUEST);
        }

        $userModel = new UserModel();
        $user = $userModel->findUserById($id);
        if (!$user) {
            $response = [
                'success' => False,                
                'message' => 'User not found'
            ];
            return $this->respond($response, ResponseInterface::HTTP_OK);
        }

        $data = [
            'id' => $id,            
            'name' => $this->request->getVar('name'),
            'password' => $this->request->getVar('password'),
            'address' => $this->request->getVar('address'),
        ];

        $userModel = new UserModel();
        $userModel->save($data);

        $response = [
            'success' => True,                
            'message' => 'User updated successfully'
        ];
        return $this->respond($response , ResponseInterface::HTTP_OK);
    }

    public function delete($id) {
        $userModel = new UserModel();
        $user = $userModel->findUserById($id);
        if (!$user) {
            $response = [
                'success' => False,                
                'message' => 'User not found'
            ];
            return $this->respond($response, ResponseInterface::HTTP_OK);
        }

        $userModel->deleteById($id);
        $response = [
            'success' => True,                
            'message' => 'User deleted successfully'
        ];
        return $this->respond($response , ResponseInterface::HTTP_OK);
    }
}