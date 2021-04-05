<?php

namespace App\Models;

use App\Traits\ApiResource;
use App\Traits\UUID;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;
    use ApiResource;
    use UUID;

    protected $fillable = [
        'name',
        'rfid',
        'telephone',
        'birthdate'
    ];

    public function teams(){
        return $this->belongsToMany(Team::class);
    }
}
