<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistente extends Model
{
    use HasFactory;

    protected $table = 'asistentes';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'eventoid'
    ];
}
