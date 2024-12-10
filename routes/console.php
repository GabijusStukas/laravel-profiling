<?php

use App\Services\Statistics\DailyStatisticsService;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('app:calculate-daily-stats', function (DailyStatisticsService $service) {
    $service->calculateDailyPoints();
})->purpose('Calculate and store daily global statistics')->dailyAt('00:05');
