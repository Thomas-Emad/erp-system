<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use App\Jobs\SendNotifyInstallmentJob;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
  $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::job(new SendNotifyInstallmentJob())->dailyAt("01:00");
