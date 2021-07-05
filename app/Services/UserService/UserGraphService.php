<?php

namespace App\Services\UserService;


interface UserGraphService
{
    function getPerMonth();
    function getGender();
    function getAge();
}
