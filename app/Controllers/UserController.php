<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
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
        $data['data'] = $userModel->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }
}