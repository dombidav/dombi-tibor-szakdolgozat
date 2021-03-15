<?php

namespace App\Models;

use App\Traits\ApiResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;
    use ApiResource;

    protected $fillable = [
        'name',
        'rfid',
        'telephone',
        'birthdate'
    ];
}
