<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\JsonResponse;

class StatusApiController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Status::query()->orderBy('nom')->get());
    }
}
