<?php

namespace App\Providers;

use App\Models\Flottes\VehicleTollLog;
use App\Models\Flottes\VehicleUsageLog;
use App\Models\GED\Document;
use App\Models\GPAO\ProductionOrder;
use App\Models\GPAO\ProductionOrderComponent;
use App\Models\GPAO\ProductionOrderOperation;
use App\Models\NoteFrais\Expense;
use App\Models\NoteFrais\ExpenseReceipt;
use App\Models\NoteFrais\ExpenseReport;
use App\Models\Signature\SignatureProcedure;
use App\Models\Signature\SignatureSigner;
use App\Observer\Flottes\VehicleTollLogObserver;
use App\Observer\Flottes\VehicleUsageLogObserver;
use App\Observer\GED\DocumentObserver;
use App\Observer\GPAO\ProductionOrderComponentObserver;
use App\Observer\GPAO\ProductionOrderObserver;
use App\Observer\GPAO\ProductionOrderOperationObserver;
use App\Observer\NoteFrais\ExpenseObserver;
use App\Observer\NoteFrais\ExpenseReceiptObserver;
use App\Observer\NoteFrais\ExpenseReportObserver;
use App\Observer\Signature\SignatureProcedureObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Expense::observe(ExpenseObserver::class);
        ExpenseReceipt::observe(ExpenseReceiptObserver::class);
        ExpenseReport::observe(ExpenseReportObserver::class);

        ProductionOrder::observe(ProductionOrderObserver::class);
        ProductionOrderComponent::observe(ProductionOrderComponentObserver::class);
        ProductionOrderOperation::observe(ProductionOrderOperationObserver::class);

        Document::observe(DocumentObserver::class);

        SignatureProcedure::observe(SignatureProcedureObserver::class);
        SignatureSigner::observe(SignatureProcedureObserver::class);

        VehicleTollLog::observe(VehicleTollLogObserver::class);
        VehicleUsageLog::observe(VehicleUsageLogObserver::class);
    }
}
