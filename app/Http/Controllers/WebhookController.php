<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Payement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Shwary\ShwaryClient;

class ShwaryWebhookController extends Controller
{
    public function __construct(
        private ShwaryClient $shwary
    ) {}

    public function handle(Request $request)
    {
        $transaction = $this->shwary->parseWebhook(
            $request->getContent()
        );

        $payment = Paiement::where(
            'transactionId',
            $transaction->id,
        )->first();

        if (!$payment) {
            return redirect()->back()->withErrors('Payment not found');
        }

        if ($transaction->isCompleted()) {
            $payment->update(['status' => 'success']);
        }

        if ($transaction->isFailed()) {
            $payment->update([
                'status' => 'Failed',
            ]);
        }

        return redirect()->back()->with('success', 'Payment status updated successfully');
    }
}
