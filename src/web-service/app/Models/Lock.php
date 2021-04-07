<?php

namespace App\Models;

use App\Traits\ApiResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lock extends Model
{
    use HasFactory;
    use ApiResource;

    protected $fillable = ['name', 'status', 'device_key'];
    protected $appends = ['statusText'];

    public function getStatusTextAttribute(){
        return (match ($this->status) {
            0 => 'closed',
            1 => 'operational',
            2 => 'open',
            default => 'unknown'
        });
    }

    public function groups()
    {
        return $this->belongsToMany(LockGroup::class);
    }
}
