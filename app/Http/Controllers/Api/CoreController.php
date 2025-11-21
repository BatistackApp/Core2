<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Core\Service;
use App\Models\User;
use App\Notifications\Core\BackupRestoreSuccessful;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;

class CoreController extends Controller
{
    public function backup(Request $request)
    {
        Artisan::call('down');
        $output = Artisan::call('backup:run', ['--only-db']);

        if ($output === 0) {
            Artisan::call('up');
            return response()->json(true);
        } else {
            return response()->json(false, 500);
        }
    }

    public function backupRestore(Request $request)
    {
        Artisan::call('down');
        $output = Artisan::call('backup:restore --no-interaction');

        if ($output === 0) {
            Artisan::call('up');
            User::all()->each(function (User $user): void {
                $user->notify(new BackupRestoreSuccessful());
            });

            return response()->json([
                'message' => 'Restauration effectuée avec succès',
            ]);
        }

        return response()->json($output);
    }

    public function storageInfo(Request $request)
    {
        $license = collect();

        $storageBase = 0;
        $storageBaseMax = Service::query()->first()->storage_limit * 1024 * 1024 * 1024;
        foreach (Storage::disk('public')->allFiles('upload') as $file) {
            $storageBase += Storage::disk('public')->size($file);
        }

        $license->push([
            'storage_used' => $storageBase,
            'storage_used_gb' => round($storageBase / (1024 * 1024 * 1024), 2),
            'storage_used_mb' => round($storageBase / (1024 * 1024), 2),
            'storage_used_percentage' => round(($storageBase / $storageBaseMax) * 100, 2),
        ]);

        return response()->json($license);
    }

    public function activityLog(Request $request)
    {
        $logs = Activity::with('causer')->latest()->paginate(10);
        return response()->json($logs);
    }
}
