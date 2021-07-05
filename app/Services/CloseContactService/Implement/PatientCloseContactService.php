<?php


namespace App\Services\CloseContactService\Implement;

use App\Http\Requests\CloseContactRequest;
use App\Repositories\CloseContactRepository\Implement\PatientCloseContactRepository;
use App\Services\CloseContactService\CloseContactService;
use Illuminate\Support\Facades\Auth;

const CLOSE_CONTACT_HAS_BEEN_SAVED_SUCCESSFULLY = true;
const CLOSE_CONTACT_HAS_BEEN_SAVED_FAILED = false;

class PatientCloseContactService implements CloseContactService
{

    protected PatientCloseContactRepository $closeContactRepo;


    public function __construct(PatientCloseContactRepository $repo)
    {
        $this->closeContactRepo = $repo;
    }


    public function storeCloseContact(CloseContactRequest $request)
    {
        $patientHasBeenAuthenticated = $this->getCurrentPatientAuthenticated();
        $validator = $request->validated();

        if ($validator) {
            $this->closeContactRepo->store($patientHasBeenAuthenticated->id, $request->all());
            return CLOSE_CONTACT_HAS_BEEN_SAVED_SUCCESSFULLY;
        }

        return CLOSE_CONTACT_HAS_BEEN_SAVED_FAILED;
    }

    /**
     * * Get patient has been authenticated
     */
    public function getCurrentPatientAuthenticated()
    {
        return Auth::guard('patientapi')->user();
    }
}
