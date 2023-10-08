<?php

namespace App\Filament\Widgets;

use App\Models\Addon;
use App\Models\Category;
use App\Models\Customers;
use App\Models\CustomPackage;
use App\Models\IternityTemplate;
use App\Models\PackageTemplate;
use App\Models\payment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsAdminOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('No. of Custom Packages',CustomPackage::all()->count()),
            Stat::make('No. of Customer',Customers::all()->count()),
            Stat::make('No. of Payment Voucher',payment::all()->count()),
            Stat::make('Total Revenue','₹ '.payment::sum('amount_paid')),
            Stat::make('Total Categories',Category::all()->count()),
            Stat::make('Total Addons',Addon::all()->count()),
            Stat::make('Total Iternity Template',IternityTemplate::all()->count()),
            Stat::make('Total Package Template',PackageTemplate::all()->count()),
        ];
    }
}
