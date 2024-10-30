<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TokenIssueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:token:issue';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Issue a token for user';

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

        try {
            $user = User::where('email', '=', $email)->firstOrFail();

            auth()->setUser($user);
            $planTextToken = auth()->user()?->createToken('api_token')->plainTextToken;
        } catch (ModelNotFoundException $exception) {
            $this->error('Could not find user with ' . $email . ' email');

            return Command::FAILURE;
        }

        $this->info('Token for user ' . $email . ' : ' . $planTextToken);

        return Command::SUCCESS;
    }
}
