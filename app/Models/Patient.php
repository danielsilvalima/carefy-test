<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

  protected $fillable = ['id', 'code', 'name', 'birth_at', 'guide', 'admission_at', 'departure_at', 'status', 'created_at', 'updated_at'];
}
