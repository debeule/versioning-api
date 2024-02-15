<?php

declare(strict_types=1);

namespace Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Imports\Version;
use DateTimeImmutable;

final class RetrieveDataController extends Controller
{
    protected Version $version;

    public function __invoke(Request $request): void
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