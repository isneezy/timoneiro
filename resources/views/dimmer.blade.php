<div class="bg-white p-6 rounded">
    <div class="flex -mx-2 items-center">
        <div class="w-1/2 px-2">
            <div class="flex relative overflow-hidden items-center justify-center rounded-full border border-{{ $variant }} h-16 w-16">
                <div class="absolute h-full w-full bg-{{ $variant }} opacity-25"></div>
                <i class="{{ $icon }} text-2xl text-{{ $variant }}"></i>
            </div>
        </div>
        <div class="w-1/2 px-2 text-right">
            <h3 class="text-dark text-2xl font-semibold">{{ $title }}</h3>
            <p class="truncate">{{ $description }}</p>
        </div>
    </div>
</div>
