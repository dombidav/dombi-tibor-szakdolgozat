<?php

namespace Http\Controllers;

use App\Http\Resources\LogResource;
use App\Models\Log;
use Tests\TestCase;

class LogControllerTest extends TestCase
{
    public function testLogIndex(): void
    {
        $this->assertModel('log.index', LogResource::make(Log::first()), [], Log::count());
    }

    public function testLogShow(): void
    {
        $this->assertModel('log.show', LogResource::make(Log::first()), ['log' => Log::first()->id]);
    }
}
