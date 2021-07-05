<?php

namespace App\Services\DeviceService;

interface PatientMobileDevice {
    function storeApiToken();
    function deleteApiToken();
    function updateApiToken();
}