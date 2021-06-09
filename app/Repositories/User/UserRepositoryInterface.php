<?php
namespace App\Repositories\User;

use App\Repositories\RepositoryInterface;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function listUser();

    public function checkEmail($email);

    public function addToken($token,$email);

    public function findToken($token);
    
    public function deleteToken($token);

    public function passwordReset($email,$password);
}