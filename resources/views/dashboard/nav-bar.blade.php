@php
    if(starts_with(auth()->user()->avatar, ['http://', 'https://'])) {
        $avatar = auth()->user()->avatar;
    } else {
        $avatar = timoneiro_assets('images/avatar.png');
    }
@endphp
<!-- Begin Top Bar -->
<div class="bg-dark text-white shadow fixed right-0 left-0 h-16 z-30" style="line-height: 64px;">
    <div class="flex justify-end">
        <a
            href="{{ route('timoneiro.dashboard') }}"
            class="text-xl font-bold w-56 px-5"
        >
            <span>.Timoneiro</span>
        </a>
        <ul class="flex-1 px-5">
            <li class="flex justify-end">
                <a href="javascript:void(0)" class="h-full flex items-center text-center whitespace-no-wrap">
                    <img
                        class="rounded-full inline-block h-8"
                        src="{{ $avatar }}"
                        alt="user-image"
                    />
                    <span class="ml-2">{{ auth()->user()->name }} <i class="mdi mdi-chevron-down"></i></span>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- End Top Bar -->
