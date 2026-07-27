<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

use App\Models\Medicine;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Order;

class Dashboard extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static string $view = 'filament.pages.dashboard';

    protected static ?string $title = 'Tableau de bord';

    public array $stats = [];

    public function mount(): void
    {
        $this->stats = [

            'medicines' => Medicine::count(),

            'categories' => Category::count(),

            'brands' => Brand::count(),

            'orders' => Order::count(),

            'low_stock' => Medicine::whereColumn(
                'stock',
                '<=',
                'minimum_stock'
            )->count(),

            'prescription' => Medicine::where(
                'requires_prescription',
                true
            )->count(),

            'featured' => Medicine::where(
                'featured',
                true
            )->count(),

        ];
    }
}