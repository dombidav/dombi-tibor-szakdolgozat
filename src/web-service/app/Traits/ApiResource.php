<?php


namespace App\Traits;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Model|null first()
 * @method static int count()
 * @method static Builder latest()
 * @method static Builder inRandomOrder()
 * @method static Model create(array $validated)
 * @method static Builder where(string $field, mixed $operatorOrEqualsValue, mixed $value = null)
 */

trait ApiResource
{

    public static function latestOne(): Model
    {
        return self::latest()->first();
    }

    public static function random(): Model
    {
        return self::inRandomOrder()->first();
    }
}
