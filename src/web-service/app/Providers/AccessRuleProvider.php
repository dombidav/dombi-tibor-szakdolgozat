<?php

namespace App\Providers;

use App\Models\AccessRule;
use http\Exception\RuntimeException;
use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AccessRuleProvider extends ServiceProvider
{

    public static function DoesRuleAllows(null|object|array $definition, AccessRule $rule): bool
    {
        if(is_array($definition)){
            throw new RuntimeException('Definition was empty');
        }
        if(isset($definition->on) && Carbon::createFromFormat('Y-m-d', $definition->on)->isToday()){
            return $definition->action === 'allow';
        }

        return false;
    }

    public function register()
    {
        //
    }

    public function boot()
    {
        //
    }
}
