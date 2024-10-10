<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PatientRepository;

class PatientController extends Controller
{
    private PatientRepository $patientRepository;

    public function __construct(patientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function index(){
        $patients = $this->patientRepository->findAll();

        return view('patient')->with([
            'patients' => $patients
        ]);
    }
}
