<?php

namespace App\Observers;

use App\Models\Project;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class ProjectObserver
{
  /**
   * Handle the Project "created" event.
   */
  public function created(Project $project): void
  {
    Cache::forget('content');

  }

  /**
   * Handle the Project "updated" event.
   */
  public function updated(Project $project): void
  {
    Cache::forget('content');
  }

  /**
   * Handle the Project "deleted" event.
   */
  public function deleted(Project $project): void
  {
    Cache::forget('content');
  }
}
