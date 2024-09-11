<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\InstallmentSupplierPayments;
use Illuminate\Support\Facades\Mail;

class SendNotifyInstallmentJob implements ShouldQueue
{
  use Queueable;

  protected $installmentsPayment;
  /**
   * Create a new job instance.
   */
  public function __construct()
  {
    $this->installmentsPayment =  InstallmentSupplierPayments::where('status', 'unpaid')
      ->where('date', '<=', today())
      ->get();
  }

  /**
   * Execute the job.
   */
  public function handle($installmentsPayment): void
  {

    foreach ($installmentsPayment as $payment) {
      Mail::send([], [], function ($message) use ($payment) {
        $message->to($payment->supplier->email)
          ->subject("Installment Payment")
          ->setBody("Installment Payment ID " . $payment->installment_id . " Amount " . $payment->amount . ' Date ' . $payment->date, 'text/html')
          ->from("xR6rA@example.com", "Pembayaran Tagihan");
      });
    }
  }
}
