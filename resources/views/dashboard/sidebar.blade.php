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
        <li>
            <a
                    href="{{ route('timoneiro.media.index') }}"
                    class="px-6 py-2 flex hover:text-info {{ request()->routeIs('timoneiro.media.*') ? 'text-info': '' }} items-center"
            >
                <i class="mdi mdi-folder-multiple-image mr-2"></i>
                <span class="flex-1">Media</span>
            </a>
        </li>
        {{--<li class="px-5 py-2 uppercase text-xs font-semibold">Auth</li>--}}
        @foreach(timoneiro_menu() as $menuItem)
            <li>
                <a href="{{ route('timoneiro.'.$menuItem['slug'].'.index') }}" class="px-6 py-2 flex hover:text-info {{ $menuItem['active'] ? 'text-info': '' }} items-center">
                    <i class="{{ $menuItem['icon-class'] }} mr-2"></i>
                    <span class="flex-1">{{ $menuItem['label'] }}</span>
                </a>
            </li>
        @endforeach
        <li>
            <a
                href="{{ route('timoneiro.settings.index') }}"
                class="px-6 py-2 flex hover:text-info {{ request()->routeIs('timoneiro.settings.index') ? 'text-info': '' }} items-center"
            >
                <i class="mdi mdi-settings mr-2"></i>
                <span class="flex-1">Settings</span>
            </a>
        </li>
    </ul>
</div>
<!--======== End Left Sidebar =======-->
