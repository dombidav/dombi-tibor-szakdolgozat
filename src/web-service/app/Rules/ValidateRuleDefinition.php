<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use JsonException;

class ValidateRuleDefinition implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        try{
            if(is_array($value)){
                $deserialized = (object)$value;
            }else {
                $deserialized = json_decode($value, false, 512, JSON_THROW_ON_ERROR);
            }
            if(empty($deserialized?->on) && empty($deserialized?->onDays)){
                $this->errorMessage = 'Rule definition does not have a valid date nor a recurring day.';
                return false;
            }
        }catch (JsonException $e){
            $this->errorMessage = 'Rule definition is not a valid JSON.';
            if(env('APP_DEBUG')){
                $msg = $e->getMessage();
                $this->errorMessage .= "Json error: $msg";
            }
            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute was not a valid rule definition';
    }
}
