<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\PatientRepository;

use function Laravel\Prompts\alert;

class HomeController extends Controller
{
    private $header = array(
        'Content-Type' => 'application/json; charset=UTF-8',
        'charset' => 'utf-8'
      );
    private $options = JSON_UNESCAPED_UNICODE;
    private PatientRepository $patientRepository;

    public function __construct(patientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }

    public function index(){
        return view('home', [
            'patients' => []
        ]);
    }
    public function readingCSV(Request $request){
        $request->validate([
            'fileUpload' => 'required|mimes:csv,txt|max:2048',
        ],[
            'fileUpload.required' => 'O campo arquivo é obrigatório.',
            'fileUpload.mimes' => 'Arquivo inválido, necessário enviar arquivo CSV.',
            'fileUpload.max' => 'Tamanho do arquivo execede :max Mb.'
        ]);

        $dataFile = array_map('str_getcsv', file($request->file('fileUpload')));

        $length = count($dataFile);
        $arrayValues = array();
        for ($i = 1; $i < $length; $i++) {
            $arrayValues[] = array_combine($dataFile[0], $dataFile[$i]);
         }
         
         $arrayValues = $this->validCSV($arrayValues);

        return view('home')->with([
            'patients' => $arrayValues
        ]);
    }

    public function validCSV($csv){
        foreach ($csv as $index => &$pessoa) {
            $nameBirth = $this->validNameBirth($pessoa['nome'], $pessoa['nascimento'], $pessoa['codigo']);
            $guide = $this->validGuide($pessoa['guia']);
            $admiBirth = $this->validAdmissionBirth( $pessoa['nascimento'] );
            $deparAdmi = $this->validDepartureAdmission( $pessoa['entrada'] );
            
            if($nameBirth || $guide){
                $pessoa['status'] = 'INVALIDO';
            }else{
                $pessoa['status'] = 'VALIDO';
            }
        }
        return $csv;
    }

    public function get(Request $request){
        if($patient = $this->patientRepository->findAll()){
            return response()->json(
                [$patient],
                Response::HTTP_OK,
                $this->header,
                $this->options
            );
        }else{
            return response()->json(
                [
                'message' => 'NENHUM PACIENTE ENCONTRADO.'
                ],
                Response::HTTP_NOT_FOUND,
                $this->header,
                $this->options
            );
        }
    }

    public function store(Request $request){        
        $patients = $request->patients;
        //dd($patients);
        $cont = 0;
        foreach ($patients as $patientData) {
            if($patientData['status'] === 'VALIDO'){
                $patient = new Patient();
                $patient->codigo = $patientData['codigo'];
                $patient->nome = $patientData['nome'];

                $patient->nascimento = \DateTime::createFromFormat('d/m/Y', $patientData['nascimento'])->format('Y-m-d');
                $patient->entrada = \DateTime::createFromFormat('d/m/Y', $patientData['entrada'])->format('Y-m-d');
                $patient->saida = \DateTime::createFromFormat('d/m/Y', $patientData['saida'])->format('Y-m-d');
                
                $patient->guia = $patientData['guia'];
                $patient->status = $patientData['status'];

                if (!$this->patientRepository->create($patient)) {
                    return view('home')->with('error', 'Falha ao salvar um ou mais pacientes.');
                }
                $cont++;
            }
        }

        return redirect()->route('home.index')->with('success', 'Pacientes salvos com sucesso! - Total de '.$cont);
    }

    public function validNameBirth($name, $birth_at, $code){
        return $this->patientRepository->findByNameBirth($name, $birth_at, $code);
    }

    public function validGuide($guide){
        return $this->patientRepository->findByGuide($guide);
    }

    public function validAdmissionBirth( $birth_at){
        $birth_at = \DateTime::createFromFormat('d/m/Y', $birth_at)->format('Y-m-d');
        return $this->patientRepository->findByAdmissionSmallerBirth( $birth_at);
    }

    public function validDepartureAdmission($admission_at){
        $admission_at = \DateTime::createFromFormat('d/m/Y', $admission_at)->format('Y-m-d');
        return $this->patientRepository->findByDepartureSmallerAdmission( $admission_at);
    }
}
