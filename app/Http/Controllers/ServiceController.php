<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\JsonResponse;

class ServiceController extends Controller
{

    public function getServices(Request $request)
    {
        $services = Service::all();
        return response()->json($services, 200, [], JSON_UNESCAPED_UNICODE);
    }

    public function getServiceById(Request $request, $service)
    {
        return response()->json(Service::find($service));
    }
}
