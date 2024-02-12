<?php

namespace Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class RetrieveDataController extends Controller
{
    public function __invoke()
    {
        $client = new Client(
            [
                'base_uri' => 'http://api.example.com',
                
            ]
        );
        $response = $client->get('endpoint_X');
        $data = $response->getBody()->getContents();
        
        return $data;
    }
}