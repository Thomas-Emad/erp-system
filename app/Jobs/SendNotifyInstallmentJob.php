<?php

namespace App\Jobs;

use App\Models\InstallmentPayment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
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
    $this->installmentsPayment =  InstallmentPayment::where('status', 'unpaid')
      ->where('date', '<=', today())
      ->get();
  }

  /**
   * Execute the job.
   */
  public function handle(): void
  {
    foreach ($this->installmentsPayment as $payment) {
      $emailTo = $payment->installment->type == 'supplier' ? $payment->installment->supplier->email : $payment->installment->customer->email;
      Mail::send([], [], function ($message) use ($payment, $emailTo) {
        $message->to($emailTo)
          ->subject("Installment Payment To:" . $payment->installment->type)
          ->text("Installment Payment ID: " . $payment->installment_id . "\nAmount: " . $payment->amount . "\nDate: " . $payment->date)
          ->from("xR6rA@example.com", "Pembayaran Tagihan");
      });
    }
  }
}
