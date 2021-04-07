<?php

namespace App\Models;

use App\Providers\AccessRuleProvider;
use App\Traits\ApiResource;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \JsonException;

class AccessRule extends Model
{
    use HasFactory;
    use ApiResource;

    protected $fillable = [
        'name',
        'description',
        'definition'
    ];

    protected $appends = [
        'isAllowing'
    ];

    public function getIsAllowingAttribute(){
      return AccessRuleProvider::DoesRuleAllows($this->definition, $this);
    }

    public function getDefinitionAttribute($value)
    {
        try {
            return empty($value) ? [] : json_decode($value, false, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            abort($e->getCode() ?? 500, $e->getMessage() ?? 'Json parse error');
        }

        return [];
    }

    public function setDefinitionAttribute($value) {
        try {
            $this->attributes['definition'] = json_encode($value, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            abort($e->getCode() ?? 500, $e->getMessage() ?? 'Json parse error');
        }
    }

    public function lockGroups(){
        return $this->belongsToMany(LockGroup::class);
    }

    public function workerGroups(){
        return $this->belongsToMany(Team::class);
    }
}
