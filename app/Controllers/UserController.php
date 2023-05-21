<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\UserModel;

class UserController extends BaseController
{
    use ResponseTrait;

    public function index()
    {
        $userModel = new UserModel();        
        $data['success'] = True;
        $data['data'] = $userModel->orderBy('id', 'DESC')->findAll();
        return $this->respond($data);
    }
}