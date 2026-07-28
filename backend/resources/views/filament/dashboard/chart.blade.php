<div class="bg-white rounded-2xl shadow-sm p-6 mt-6">

    <h2 class="text-xl font-bold mb-4">
        📊 État du Stock
    </h2>

    <div style="height:350px;">

        <canvas id="stockChart"></canvas>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const ctx = document.getElementById('stockChart');

new Chart(ctx,{
    type:'bar',

    data:{
        labels:[
            'Stock',
            'Minimum'
        ],

        datasets:[{
            label:'Produits',

            data:[
                {{ \App\Models\Medicine::sum('stock') }},
                {{ \App\Models\Medicine::sum('minimum_stock') }}
            ]
        }]
    },

    options: {
    responsive: true,
    maintainAspectRatio: false,
}

});

</script>