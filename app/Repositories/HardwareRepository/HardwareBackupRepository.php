<?php

namespace App\Repositories\HardwareRepository;


interface HardwareBackupRepository
{
    function storeTxt(string $serial_number, $file): bool;
}
