<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserChangePasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:user:change-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change password for given user';

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
        $email = $this->ask('Enter user email : ');

        try {
            $user = User::where('email', '=', $email)->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            $this->error('Could not find user with ' . $email . ' email');

            return Command::FAILURE;
        }

        $user->password = $this->ask('Enter new password ');
        $user->save();

        return Command::SUCCESS;
    }
}
