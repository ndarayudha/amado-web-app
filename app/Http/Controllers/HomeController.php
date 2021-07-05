<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\CloseContact\CloseContact;
use App\Models\Member;
use App\Models\Loan;
use App\Models\Patient\Patient;
use App\Models\User;
use App\Repositories\LoanRepository;
use App\Services\LoanService;
use App\Services\UserService\Implement\PatientServiceWeb;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{

	public function index(LoanRepository $loanRepo, PatientServiceWeb $patientService): View
	{

		$totalAdmin = User::count();
		$totalPasien = Patient::count();
		$totalKontakErat = CloseContact::count();
		$pasienPerMonth = $patientService->getPerMonth();
		$pasienGender = $patientService->getGender();
		$pasienAge = $patientService->getAge();

		// $totalBook = Book::count();
		// $totalMember = Member::count();
		// $totalLoan = Loan::count();
		// $activeLoan = $loanRepo->countActive();
		// $loanPerMonth = $loanService->gerPerMonth();
		// $topBook = $loanService->getTopBook();

		return view('home', compact('totalAdmin', 'totalPasien', 'pasienPerMonth', 'pasienGender', 'pasienAge', 'totalKontakErat'));
	}
}
