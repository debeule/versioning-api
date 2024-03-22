<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Exports\User;
use Illuminate\Console\Command;

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
    
    public function handle(): void
    {
        $user = User::create();
        $token = $user->createToken('token-name');
        $token = $token->plainTextToken;

        $this->info("API token generated successfully: $token");
    }
}
