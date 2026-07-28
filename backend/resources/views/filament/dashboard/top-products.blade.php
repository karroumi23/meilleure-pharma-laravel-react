@php

$products = \App\Models\Medicine::orderByDesc('stock')->take(5)->get();

@endphp

<div class="bg-white rounded-2xl shadow-sm p-6">

    <h2 class="text-xl font-bold mb-4">

        ⭐ Produits les plus disponibles

    </h2>

    <table class="w-full">

        @foreach($products as $product)

            <tr class="border-b">

                <td class="py-3">

                    {{ $product->name }}

                </td>

                <td class="text-right">

                    {{ $product->stock }}

                </td>

            </tr>

        @endforeach

    </table>

</div>