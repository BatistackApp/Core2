<?php

namespace App\Providers;

use App\Models\Articles\ArticleOuvrage;
use App\Models\Articles\ArticleStock;
use App\Models\Flottes\VehicleTollLog;
use App\Models\Flottes\VehicleUsageLog;
use App\Models\GED\Document;
use App\Models\GPAO\ProductionOrder;
use App\Models\GPAO\ProductionOrderComponent;
use App\Models\GPAO\ProductionOrderOperation;
use App\Models\Locations\RentalContract;
use App\Models\Locations\RentalContractLine;
use App\Models\NoteFrais\Expense;
use App\Models\NoteFrais\ExpenseReceipt;
use App\Models\NoteFrais\ExpenseReport;
use App\Models\Signature\SignatureProcedure;
use App\Models\Signature\SignatureSigner;
use App\Models\Tiers\Tiers;
use App\Models\Tiers\TiersBank;
use App\Models\Vision\BimModel;
use App\Observer\Articles\ArticleOuvrageObserver;
use App\Observer\Articles\ArticleStockObserver;
use App\Observer\Flottes\VehicleTollLogObserver;
use App\Observer\Flottes\VehicleUsageLogObserver;
use App\Observer\GED\DocumentObserver;
use App\Observer\GPAO\ProductionOrderComponentObserver;
use App\Observer\GPAO\ProductionOrderObserver;
use App\Observer\GPAO\ProductionOrderOperationObserver;
use App\Observer\Locations\RentalContractLineObserver;
use App\Observer\Locations\RentalContractObserver;
use App\Observer\NoteFrais\ExpenseObserver;
use App\Observer\NoteFrais\ExpenseReceiptObserver;
use App\Observer\NoteFrais\ExpenseReportObserver;
use App\Observer\Signature\SignatureProcedureObserver;
use App\Observer\Tiers\TiersBankObserver;
use App\Observer\Tiers\TiersObserver;
use App\Observer\Vision\BimModelObserver;
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
        Tiers::observe(TiersObserver::class);
        TiersBank::observe(TiersBankObserver::class);

        ArticleOuvrage::observe(ArticleOuvrageObserver::class);
        ArticleStock::observe(ArticleStockObserver::class);

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

        RentalContract::observe(RentalContractObserver::class);
        RentalContractLine::observe(RentalContractLineObserver::class);

        BimModel::observe(BimModelObserver::class);
    }
}
