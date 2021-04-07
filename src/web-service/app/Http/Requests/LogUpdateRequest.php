<?php

namespace App\Http\Requests;

use App\Models\Log;

class LogUpdateRequest extends ApiResourceRequest
{
    /** @inheritDoc */
    public function rules(): array
    {
        return
            [
                'name' => ['min:3'],
                //TODO: Complete definition
            ];
    }

    protected function getModel(): string
    {
        return Log::class;
    }
}
