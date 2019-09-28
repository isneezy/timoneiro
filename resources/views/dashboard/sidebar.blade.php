<!--======== Begin Left Sidebar =======-->
<div class="w-56 bg-white h-full shadow py-5">
    <ul class="text-base">
        <li>
            <a
                href="{{ route('timoneiro.dashboard') }}"
                class="px-6 py-2 flex hover:text-info {{ request()->routeIs('timoneiro.dashboard') ? 'text-info': '' }} items-center"
            >
                <i class="mdi mdi-view-dashboard mr-2"></i>
                <span class="flex-1">Dashboard</span>
            </a>
        </li>
        {{--<li class="px-5 py-2 uppercase text-xs font-semibold">Auth</li>--}}
        @foreach(menu() as $menuItem)
            <li>
                <a href="{{ $menuItem['link'] }}" class="px-6 py-2 flex hover:text-info {{ $menuItem['active'] ? 'text-info': '' }} items-center">
                    <i class="{{ $menuItem['icon-class'] }} mr-2"></i>
                    <span class="flex-1">{{ $menuItem['label'] }}</span>
                </a>
            </li>
        @endforeach
    </ul>
</div>
<!--======== End Left Sidebar =======-->
