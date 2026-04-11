<?php

namespace App\Http\Controllers\Api\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Application\Home\Services\HomeService;
class HomeApiController extends Controller
{
    public function __construct(
        private HomeService $homeService
    )
    {
    }
    public function index(){
        return $this->homeService->getReport();

    }
}
