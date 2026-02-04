<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReturnRequest;
use App\Models\WalletTransaction;

class FixRefund extends Command
{
    protected $signature = 'fix:refund {id}';
    protected $description = 'Manually refund a return request to wallet';

    public function handle()
    {
        $id = $this->argument('id');
        $req = ReturnRequest::with(['user', 'order'])->find($id);

        if (!$req) {
            $this->error("Return Request not found.");
            return;
        }

        if ($req->status !== 'refunded') {
            $this->warn("Status is not refunded. It is: {$req->status}");
            if (!$this->confirm('Proceed anyway?')) return;
        }

        $user = $req->user;
        $order = $req->order;

        if (!$user) { // Updated check
            $this->error("User not found.");
            return;
        }
        
        $this->info("User: {$user->name} (Balance: {$user->wallet_balance})");
        
        $amount = $order->total_amount;
        $this->info("Order Amount: $amount");

        $user->creditWallet($amount, "Refund for Order #{$order->order_number}", $req->id);
        
        $this->info("Credited! New Balance: {$user->wallet_balance}");
    }
}
