<?php

namespace App\Observers;

use App\Repositories\UserRepository;
use Log;

/**
 * User模型观察者.
 *
 * @author overtrue <anzhengchao@gmail.com>
 */
class UserObserver
{

    private $userRepository;

    public function __construct(
        UserRepository $userRepo
        )
    {
        $this->userRepository = $userRepo;
    }

    public function saved()
    {
        
    }

    public function updated()
    {
        
    }

    public function created($user)
    {    
        $this->userRepository->newUserCreated($user);
    }

    public function deleted()
    {
        
    }
}

