<x-filament-panels::page>

<div class="space-y-6">

    @include('filament.dashboard.welcome')

    @include('filament.dashboard.stats')

    @include('filament.dashboard.chart')

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        @include('filament.dashboard.alerts')

        @include('filament.dashboard.latest-orders')

    </div>

    @include('filament.dashboard.top-products')

</div>

</x-filament-panels::page>