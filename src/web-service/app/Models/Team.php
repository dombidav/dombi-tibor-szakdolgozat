<?php

namespace App\Models;

use App\Traits\ApiResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Team
 * @package App\Models
 * @property Collection workers
 */
class Team extends Model
{
    use HasFactory;
    use ApiResource;

    protected $fillable = [
        'name'
    ];

    public function workers(){
        return $this->belongsToMany(Worker::class);
    }

    public function rules(){
        return $this->belongsToMany(AccessRule::class);
    }
}
