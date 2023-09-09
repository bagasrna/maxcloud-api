<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;
    }

    public function login()
    {
        
    }

    public function logout()
    {
        
    }

    public function create(array $data)
    {
        $user = new $this->userModel;
        $user->fullname = $data['fullname'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->address = $data['address'];
        $user->phone = $data['phone'];
        $user->save();

        return $user;
    }

    public function register(array $data)
    {
        $user = new $this->userModel;
        $user->fullname = $data['fullname'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->address = $data['address'];
        $user->phone = $data['phone'];
        $user->save();

        return $user;
    }
}
