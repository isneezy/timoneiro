@extends('timoneiro::master')

@section('title', 'Visualizando '.$dataType->display_name_plural)
@section('page_title', $dataType->display_name_plural)

@section('page_content')
    <div class="bg-white rounded p-5">
        <div class="flex items-center mb-8">
            <h4 class="flex-1 text-base font-semibold text-dark">Manage {{ $dataType->display_name_plural }}</h4>
            <div>
                <a
                    class="text-white px-3 py-2 bg-primary leading-normal rounded"
                    href="{{ route("timoneiro.$dataType->slug.create") }}">
                    <i class="mdi mdi-plus-circle"></i> Add {{ $dataType->display_name_plural }}
                </a>
            </div>
        </div>
        <div class="flex mb-3">
            <div class="flex-1">
                <label class="flex items-center">
                    <span class="mr-1">Show</span>
                    <div class="inline-block relative">
                        <select value="{{ $data->perPage() }}" name="per_page" class="block text-sm p-1 pl-2 pr-6 bg-white text-dark border border-gray-500 appearance-none rounded">
                            <option>10</option>
                            <option>25</option>
                            <option>50</option>
                            <option>100</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700 top-0">
                            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" width="401.998" height="401.998">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </svg>
                        </div>
                    </div>
                    <span class="ml-1">entries</span>
                </label>
            </div>
            <div class="flex justify-end">
                <label>
                    <div class="relative inline-block w-auto">
                        <input type="search" class="px-3 pl-8 py-1 border border-gray-500 w-full rounded" placeholder="Search" />
                        <div class="pointer-events-none absolute left-0 top-0 bottom-0 px-2 flex items-center opacity-75">
                            <svg class="h-4 w-4" viewBox="0 0 20 20">
                                <path d="M18.125,15.804l-4.038-4.037c0.675-1.079,1.012-2.308,1.01-3.534C15.089,4.62,12.199,1.75,8.584,1.75C4.815,1.75,1.982,4.726,2,8.286c0.021,3.577,2.908,6.549,6.578,6.549c1.241,0,2.417-0.347,3.44-0.985l4.032,4.026c0.167,0.166,0.43,0.166,0.596,0l1.479-1.478C18.292,16.234,18.292,15.968,18.125,15.804 M8.578,13.99c-3.198,0-5.716-2.593-5.733-5.71c-0.017-3.084,2.438-5.686,5.74-5.686c3.197,0,5.625,2.493,5.64,5.624C14.242,11.548,11.621,13.99,8.578,13.99 M16.349,16.981l-3.637-3.635c0.131-0.11,0.721-0.695,0.876-0.884l3.642,3.639L16.349,16.981z"></path>
                            </svg>
                        </div>
                    </div>
                </label>
            </div>
        </div>
        <div>
            <table class="w-full">
                <thead>
                    @foreach($dataType->list_display as $column)
                        <th class="p-3 pr-8 cursor-pointer relative whitespace-no-wrap border-b-2">
                            <div class="flex items-center">
                                <span class="flex-1">{{ $column }}</span>
                                <span class="w-1">
                                    <svg class="h-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="0 0 65.492 123.358" width="65.492" height="123.358"><defs><clipPath id="_clipPath_SDK7jcufiwZNkxPa0N26w1e9UKFCNL1d"><rect width="65.492" height="123.358"/></clipPath></defs><g clip-path="url(#_clipPath_SDK7jcufiwZNkxPa0N26w1e9UKFCNL1d)"><g><g><path d=" M 0.331 80.267 C 0.108 80.564 0 80.915 0 81.261 C 0 81.613 0.113 81.97 0.342 82.267 L 31.437 122.715 C 31.75 123.121 32.236 123.358 32.745 123.358 C 33.258 123.358 33.741 123.119 34.055 122.715 L 65.149 82.268 C 65.603 81.678 65.605 80.863 65.158 80.267 C 64.712 79.677 63.926 79.456 63.236 79.727 L 42.645 87.86 L 42.645 1.65 C 42.645 0.736 41.908 0 40.997 0 L 24.495 0 C 23.585 0 22.844 0.736 22.844 1.65 L 22.844 87.86 L 2.255 79.727 C 1.566 79.456 0.781 79.678 0.331 80.267 Z " fill="currentColor"/></g></g></g></svg>
                                </span>
                                <span class="w-1">
                                    <svg class="h-2" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="isolation:isolate" viewBox="0 0 65.492 123.358" width="65.492" height="123.358"><defs><clipPath id="_clipPath_f583ZFfHPYybMgwXZXG8c9teiBO9vQFn"><rect width="65.492" height="123.358"/></clipPath></defs><g clip-path="url(#_clipPath_f583ZFfHPYybMgwXZXG8c9teiBO9vQFn)"><g><g><path d=" M 65.161 43.091 C 65.383 42.794 65.492 42.442 65.492 42.097 C 65.492 41.745 65.378 41.388 65.15 41.091 L 34.054 0.643 C 33.742 0.237 33.256 0 32.747 0 C 32.234 0 31.75 0.239 31.436 0.643 L 0.343 41.09 C -0.112 41.68 -0.114 42.495 0.334 43.091 C 0.779 43.681 1.566 43.902 2.256 43.631 L 22.846 35.498 L 22.846 121.708 C 22.846 122.622 23.584 123.358 24.495 123.358 L 40.996 123.358 C 41.907 123.358 42.647 122.622 42.647 121.708 L 42.647 35.498 L 63.237 43.631 C 63.925 43.902 64.711 43.68 65.161 43.091 Z " fill="currentColor"/></g></g></g></svg>
                                </span>
                            </div>
                        </th>
                    @endforeach
                </thead>
                <tbody>
                    @foreach($data->items() as $item)
                        <tr class="bg-black hover:bg-gray-200  hover:text-gray-700">
                            @foreach($dataType->list_display as $column)
                                <td class="relative cursor-pointer whitespace-no-wrap p-3 border-t">
                                    {{ $item->{$column} }}
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@stop
