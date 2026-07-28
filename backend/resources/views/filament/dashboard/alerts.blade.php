@php

$lowStock = \App\Models\Medicine::whereColumn('stock','<=','minimum_stock')->get();

@endphp

<div class="bg-white rounded-2xl shadow-sm p-6">

    <h2 class="text-xl font-bold mb-4">

        ⚠ Alertes Stock

    </h2>

    @forelse($lowStock as $medicine)

        <div class="border-b py-3">

            <strong>{{ $medicine->name }}</strong>

            <div class="text-red-600">

                Stock : {{ $medicine->stock }}

            </div>

        </div>

    @empty

        <div class="text-green-600">

            Aucun produit en rupture.

        </div>

    @endforelse

</div>