<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Exports\Token;

class GenerateApiToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'api-token:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate api token and return it';

    /**
     * Execute the console command.
     */
    
    public function handle()
    {
        Token::create();
        
        $token = Token::first()->api_token;
        
        $this->info("API token generated successfully: $token");
    }
}
