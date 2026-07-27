<x-filament-panels::page>

    @include('filament.dashboard.welcome')

    @include('filament.dashboard.stats',[
        'stats'=>$this->stats
    ])

    @include('filament.dashboard.chart')

    @include('filament.dashboard.alerts')

    @include('filament.dashboard.latest-orders')

    @include('filament.dashboard.top-products')

</x-filament-panels::page>