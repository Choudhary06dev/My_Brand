<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class TestWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wallet:test {user_id} {amount}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test wallet credit for a user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $userId = $this->argument('user_id');
        $amount = $this->argument('amount');

        $user = User::find($userId);

        if (!$user) {
            $this->error('User not found.');
            return;
        }

        $this->info("Current Balance: {$user->wallet_balance}");
        $this->info("Crediting {$amount}...");

        try {
            $user->creditWallet($amount, "Test Credit via Command", "TEST-" . time());
            $this->info("New Balance: {$user->wallet_balance}");
            $this->info("Transaction created.");
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
