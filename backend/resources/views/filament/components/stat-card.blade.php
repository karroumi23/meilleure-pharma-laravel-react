<div class="bg-white rounded-2xl shadow-sm p-6">

    <div class="flex items-center justify-between">

        <div>

            <p class="text-gray-500">

                {{ $title }}

            </p>

            <h2 class="text-3xl font-bold mt-2">

                {{ $value }}

            </h2>

        </div>

        <div
            class="w-16 h-16 rounded-xl flex items-center justify-center text-3xl"
            style="background:{{ $color }}20;color:{{ $color }};">

            {{ $icon }}

        </div>

    </div>

</div>