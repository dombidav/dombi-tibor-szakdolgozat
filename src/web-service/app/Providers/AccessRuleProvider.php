<?php

namespace App\Providers;

use Illuminate\Support\Carbon;
use Illuminate\Support\ServiceProvider;

class AccessRuleProvider extends ServiceProvider
{

    public static function DoesRuleAllows(?object $definition): bool
    {
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
