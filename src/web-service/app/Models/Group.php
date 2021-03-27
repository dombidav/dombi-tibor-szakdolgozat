<?php

namespace App\Models;

use App\Traits\ApiResource;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Group
 * @package App\Models
 * @property Collection workers
 */
class Group extends Model
{
    use HasFactory;
    use ApiResource;

    protected $fillable = [
        'name'
    ];

    public function workers(){
        return $this->belongsToMany(Worker::class);
    }
}
