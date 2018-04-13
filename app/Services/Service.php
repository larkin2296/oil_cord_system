<?php

namespace App\Services;


use App\Repositories\Interfaces\UserRepository;



class Service
{
    public $userRepo;


    public function __construct()
    {
        $this->userRepo = app(UserRepository::class);


    }
}