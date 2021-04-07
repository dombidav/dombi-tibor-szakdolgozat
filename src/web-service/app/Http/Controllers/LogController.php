<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogRequest;
use App\Http\Requests\LogUpdateRequest;
use App\Http\Resources\LogResource;
use App\Models\Log;
use App\Utils\Bouncer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Symfony\Component\HttpFoundation\Response as ResponseCode;

class LogController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        return LogResource::collection(Log::all());
    }

    public function show(Log $log): LogResource
    {
        return LogResource::make($log);
    }
}
