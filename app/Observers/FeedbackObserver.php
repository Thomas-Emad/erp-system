<?php

namespace App\Observers;

use App\Models\Feedback;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class FeedbackObserver
{
  /**
   * Handle the Feedback "created" event.
   */
  public function created(Feedback $feedback): void
  {
    Cache::forget('content');
  }

  /**
   * Handle the Feedback "deleted" event.
   */
  public function deleted(Feedback $feedback): void
  {
    Cache::forget('content');
  }
}
