<?php

namespace App\Repositories;

use App\Models\Patient;
use Illuminate\Http\Client\Request;

class PatientRepository
{
  private $model;

  public function __construct(Patient $model)
  {
    $this->model = $model;
  }

  public function findAll()
	{
    return $this->model->all();
	}

  public function create(Patient $model){
    
    return Patient::create([
      "code" => $model->codigo,
      "status" => $model->status,
      "name" => $model->nome,
      "birth_at" => $model->nascimento,
      "guide" => $model->guia,
      "admission_at" => $model->entrada,
      "departure_at" => $model->saida

    ])->id;
    
  }

  public function findByNameBirth(string $name, string $birth_at, string $code)
  {
    return $this->model->where('name', '=', $name)->where('birth_at', '=', $birth_at)->where('code', '!=', $code)->first();
  }

  public function findByGuide(string $guide)
  {
    return $this->model->where('guide', '=', $guide)->first();
  }

  public function findByAdmissionSmallerBirth(string $birth_at)
  {
    return $this->model->where('admission_at', '<', $birth_at)->first();
  }

  public function findByDepartureSmallerAdmission( string $admission_at)
  {
    return $this->model->where('departure_at', '<=', $admission_at)->first();
  }

}
