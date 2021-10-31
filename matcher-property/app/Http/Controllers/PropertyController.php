<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class PropertyController extends Controller
{
    /**
     * Gets the property search for a property 
     *
     * @param Property $property
     * @return Response
     */
    public function __invoke( Property $property )
    {
        $response = Http::get('http://127.0.0.1:8001/api/search', $property->toArray());
        
        return Response::json($response->body(), $response->status);
    }
}
