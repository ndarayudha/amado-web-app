<?php

namespace App\Services\UserService;


interface UserService
{
    function updateUser($request);
    function updateUserPhoto($request);
    function getUserPhoto($request);
    function getBiodata($request);
}
