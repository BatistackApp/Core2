<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// Note de Frais
Schedule::command(\App\Console\Commands\SendExpenseReportRemindersCommand::class)
    ->dailyAt('09:00')
    ->description('Send expense report reminders to users');

Schedule::command(\App\Console\Commands\CheckProductionOrderDelaysCommand::class)
    ->dailyAt('08:00')
    ->description('Check production order delays');
