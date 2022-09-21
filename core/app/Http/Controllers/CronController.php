<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Winner;
use App\Models\GeneralSetting;
use Carbon\Carbon;

class CronController extends Controller
{
    public function cron()
    {
        $general = GeneralSetting::first();
        $general->last_cron = Carbon::now()->toDateTimeString();
        $general->save();

        $products = Product::expired()->doesntHave('winner')->get();
        if (count($products)) {
            foreach ($products as $key => $product) {
                $productBid = $product->bids->where('status', 1)->first();

                if ($productBid) {
                    $user = $productBid->user;

                    $winner = new Winner();
                    $winner->user_id = $user->id;
                    $winner->product_id = $product->id;
                    $winner->bid_id = $productBid->id;
                    $winner->save();

                    notify($user, 'BID_WINNER', [
                        'product' => $product->name,
                        'product_price' => showAmount($product->price),
                        'currency' => $general->cur_text,
                        'amount' => showAmount($productBid->amount),
                    ]);

                    $product->merchant->balance += $productBid->amount;
                    $product->merchant->save();

                    $transaction = new Transaction();
                    $transaction->merchant_id = $product->merchant_id;
                    $transaction->amount = $productBid->amount;
                    $transaction->post_balance = $product->merchant->balance;
                    $transaction->trx_type = '+';
                    $transaction->details = showAmount($productBid->amount) . ' ' . $general->cur_text . ' Added for Bid';
                    $transaction->trx =  $productBid->trx;
                    $transaction->save();

                    notify($product->merchant, 'BID_COMPLETE', [
                        'trx' => $productBid->trx,
                        'amount' => showAmount($productBid->amount),
                        'currency' => $general->cur_text,
                        'product' => $product->name,
                        'product_price' => showAmount($product->price),
                        'post_balance' => showAmount($product->merchant->balance),
                    ], 'merchant');
                }
            }
        }
        return 'cron executed successfully';
    }
}
