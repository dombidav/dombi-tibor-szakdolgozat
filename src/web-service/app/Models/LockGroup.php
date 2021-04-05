<?php

namespace App\Models;

use App\Traits\ApiResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LockGroup extends Model
{
    use HasFactory;
    use ApiResource;

    protected $fillable = [
        'name',
        //TODO: Complete definition
    ];
}
