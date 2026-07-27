<div
    class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 p-6 border border-gray-100">

    <div class="flex items-center justify-between">

        <div>

            <p class="text-gray-500 text-sm font-medium">
                {{ $title }}
            </p>

            <h2
                class="text-4xl font-bold mt-2"
                style="color: {{ $color ?? '#169DB3' }};">

                {{ $value }}

            </h2>

        </div>

        <div class="text-5xl">
            {{ $icon }}
        </div>

    </div>

</div>