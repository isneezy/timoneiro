@php
    $user = auth()->id();
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
                <dropdown>
                    <a slot="label" href="javascript:void(0)" class="h-full flex items-center text-center whitespace-no-wrap">
                        <img
                                class="rounded-full inline-block h-8"
                                src="{{ $avatar }}"
                                alt="user-image"
                        />
                        <span class="ml-2">{{ auth()->user()->name }} <i class="mdi mdi-chevron-down"></i></span>
                    </a>
                    <ul slot="items" class="bg-white shadow right-0 text-secondary leading-normal p-1 rounded mt-1 min-w-40">
                        <li class="bg-white px-4 py-4 font-bold whitespace-no-wrap text-dark">Welcome!</li>
                        <li>
                            <a href="{{ route('timoneiro.users.edit', compact('user')) }}" class="py-2 px-3 block hover:bg-gray-200">
                                <i class="mdi mdi-account"></i> Profile
                            </a>
                        </li>
                        {{--<li>--}}
                            {{--<a href="{{ route('timoneiro.users.edit', compact('user')) }}" class="py-2 px-3 block hover:bg-gray-200">--}}
                                {{--<i class="mdi mdi-settings"></i> Settings--}}
                            {{--</a>--}}
                        {{--</li>--}}
                        <li class="border-t border-light mt-1">
                            <form action="{{ route('timoneiro.logout') }}" method="post">
                                {{ csrf_field() }}
                                <button type="submit" href="{{ route('timoneiro.logout') }}" class="w-full text-left py-2 px-3 block mt-1 appearance-none hover:bg-gray-200">
                                    <i class="mdi mdi-logout"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </dropdown>
            </li>
        </ul>
    </div>
</div>
<!-- End Top Bar -->
