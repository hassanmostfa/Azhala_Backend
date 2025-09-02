<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

abstract class BaseApiController extends Controller
{
    use ApiResponse;

    /**
     * Constructor
     */
    public function __construct()
    {
        // Add any common middleware or initialization here
    }
}
