<?php

namespace App\Services\CloseContactService;

use App\Http\Requests\CloseContactRequest;

interface CloseContactService
{
    function storeCloseContact(CloseContactRequest $request);
}
