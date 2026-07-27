<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mt-6">

    @include('filament.components.stat-card',[
        'title'=>'Médicaments',
        'value'=>$stats['medicines'],
        'icon'=>'💊'
    ])

    @include('filament.components.stat-card',[
        'title'=>'Catégories',
        'value'=>$stats['categories'],
        'icon'=>'📂'
    ])

    @include('filament.components.stat-card',[
        'title'=>'Marques',
        'value'=>$stats['brands'],
        'icon'=>'🏭'
    ])

    @include('filament.components.stat-card',[
        'title'=>'Commandes',
        'value'=>$stats['orders'],
        'icon'=>'🛒'
    ])

    @include('filament.components.stat-card',[
        'title'=>'Stock faible',
        'value'=>$stats['low_stock'],
        'icon'=>'⚠️'
    ])

    @include('filament.components.stat-card',[
        'title'=>'Sous ordonnance',
        'value'=>$stats['prescription'],
        'icon'=>'📄'
    ])

    @include('filament.components.stat-card',[
        'title'=>'Produits vedettes',
        'value'=>$stats['featured'],
        'icon'=>'⭐'
    ])

</div>