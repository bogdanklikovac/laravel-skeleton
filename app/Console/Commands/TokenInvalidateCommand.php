<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class TokenInvalidateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:token:invalidate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Invalidate given token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $email = $this->ask('Email : ');
        $tokenId = $this->ask('Token Id : ');

        try {
            $user = User::where('email', '=', $email)->firstOrFail();
            $user->tokens()->where('id', $tokenId)->delete();
        } catch (\Throwable $exception) {
            $this->error('Could not delete token for user ' . $email . ' email with token ID ' . $tokenId);

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
