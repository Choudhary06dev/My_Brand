<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ReturnRequest;
use App\Models\WalletTransaction;

class CheckReturns extends Command
{
    protected $signature = 'check:returns';
    protected $description = 'Check recent return requests';

    public function handle()
    {
        $requests = ReturnRequest::with(['user', 'order'])->latest()->take(5)->get();

        foreach ($requests as $req) {
            $uName = $req->user ? $req->user->name : 'N/A';
            $uId = $req->user ? $req->user->id : 'N/A';
            $oNum = $req->order ? $req->order->order_number : 'N/A';
            
            $this->info("RetID:{$req->id} User:{$uName}({$uId}) Status:{$req->status} Order:{$oNum}");
            
            $trans = WalletTransaction::where('reference_id', $req->id)->get();
            if ($trans->count() > 0) {
                $this->info(" -> Trans Found! Amt: " . $trans->first()->amount);
            } else {
                $this->warn(" -> No Trans");
            }
        }
    }
}
