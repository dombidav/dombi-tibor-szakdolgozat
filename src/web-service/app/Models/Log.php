<?php

namespace App\Models;

use App\Traits\ApiResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;
    use ApiResource;

    protected $fillable = [
        'event',
        'action'
    ];

    public function worker(){
        return $this->belongsTo(Worker::class);
    }

    public function lock(){
        return $this->belongsTo(Lock::class);
    }

    public function rule(){
        return $this->belongsTo(AccessRule::class);
    }

    public static function entry(string $action, Worker $worker, Lock $lock, AccessRule|null $accessRule = null): Log{
        /** @var Log $log */
        $log = Log::create([
            'event' => 'entry',
            'action' => $action
        ]);
        $log->worker()->associate($worker);
        $log->lock()->associate($lock);
        if($accessRule) {
            $log->rule()->associate($accessRule);
        }
        $log->save();
        return $log;
    }
}
