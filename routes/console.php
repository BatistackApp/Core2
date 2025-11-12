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

// GPAO
Schedule::command(\App\Console\Commands\CheckProductionOrderDelaysCommand::class)
    ->dailyAt('08:00')
    ->description('Check production order delays');

// Flottes
Schedule::command(\App\Console\Commands\ImportUlysTollLogsCommand::class)
    ->everySixHours()
    ->description('Import Ulys toll logs');

Schedule::command(\App\Console\Commands\SendFleetRemindersCommand::class)
    ->dailyAt('08:30')
    ->description('Send fleet reminders');
