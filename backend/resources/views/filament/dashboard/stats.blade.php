<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">

    @include('filament.components.stat-card',[
        'title'=>'Médicaments',
        'value'=>\App\Models\Medicine::count(),
        'icon'=>'💊',
        'color'=>'#169DB3'
    ])

    @include('filament.components.stat-card',[
        'title'=>'Stock',
        'value'=>\App\Models\Medicine::sum('stock'),
        'icon'=>'📦',
        'color'=>'#16A34A'
    ])

    @include('filament.components.stat-card',[
        'title'=>'Catégories',
        'value'=>\App\Models\Category::count(),
        'icon'=>'📂',
        'color'=>'#F59E0B'
    ])

    @include('filament.components.stat-card',[
        'title'=>'Marques',
        'value'=>\App\Models\Brand::count(),
        'icon'=>'🏷',
        'color'=>'#DC2626'
    ])

</div>