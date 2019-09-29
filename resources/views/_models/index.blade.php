@extends('timoneiro::master')

@section('title', 'Viewing '.$dataType->display_name_plural)
@section('page_title', $dataType->display_name_plural)

@section('page_content')
    <div class="bg-white rounded p-5">
        <div class="flex items-center mb-8">
            <h4 class="flex-1 text-base font-semibold text-dark">Manage {{ $dataType->display_name_plural }}</h4>
            <div>
                <a
                    class="text-white px-3 py-2 bg-primary leading-normal rounded"
                    href="{{ route("timoneiro.$dataType->slug.create") }}">
                    <i class="mdi mdi-plus-circle"></i> Add {{ $dataType->display_name_singular }}
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
        <div class="overflow-x-auto w-full">
            <table class="w-full">
                <thead>
                    @foreach($dataType->list_display as $column)
                        <th class="p-3 cursor-pointer relative whitespace-no-wrap border-b-2">
                            <div class="flex items-center">
                                <span class="flex-1">{{ $dataType->getColumnLabel($column) }}</span>
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
        <div class="flex items-center mt-3">
            @php
                $total = $data->total();
                $currentPage = $data->currentPage();
                $perPage = $data->perPage();
                $to = ($currentPage * $perPage);
                $from = $to  - $perPage + 1;
            @endphp
            <div>Showing {{ $from  }} to {{ $to < $total ? $to : $total }} of {{ $total }} entries</div>
            {{--<div class="flex-1">--}}
                {{--<ul class="flex">--}}
                    {{--<li><a class="rounded text-white p-2 bg-primary mr-3 text-center" href="javascript:void(0)"><i class="mdi mdi-chevron-left"></i></a></li>--}}
                    {{--<li><a class="rounded text-white p-2 bg-primary mr-3 text-center" href="javascript:void(0)"><i class="mdi mdi-chevron-right"></i></a></li>--}}
                {{--</ul>--}}
            {{--</div>--}}
            {{ $data->links() }}
        </div>
    </div>
@stop
