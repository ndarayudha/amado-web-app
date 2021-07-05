<?php

namespace App\Repositories\AuthApi;


interface AuthRepository{
    public function saveUser(array $request): Object;
    public function deleteAccessToken($request): bool;
    public function saveAccessToken($user);
    public function getTokenId($user_id);
}
