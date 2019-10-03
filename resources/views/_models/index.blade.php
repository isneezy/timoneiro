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
        @include('timoneiro::_models.partials.search')
        <div class="overflow-x-auto w-full">
            <table class="w-full">
                <thead>
                    <tr>
                        @foreach($dataType->list_display as $column)
                            <th class="p-3 cursor-pointer relative whitespace-no-wrap border-b-2">
                                @php
                                    $sort_column = $orderBy;
                                    $sort_direction = $sortOrder ?? 'asc';
                                    $sort_direction = $sort_direction === 'asc' && $column === $sort_column  ? 'desc': 'asc';
                                    $classes = ['mdi'];
                                    //dd($sort_column !== $column);
                                    array_push($classes, $sort_column !== $column
                                      ? 'mdi-sort'
                                      : ($sort_direction === 'asc' ? 'mdi-sort-descending' : 'mdi-sort-ascending')
                                     );
                                    array_push($classes, $sort_column === $column ? 'text-gray-700' : 'text-gray-400');
                                    $classes = implode(' ', $classes);
                                @endphp
                                <a
                                    class="flex items-center"
                                    href="{{
                                 request()->fullUrlWithQuery(['sort' => [
                                    'column' => $column,
                                     'direction' => $sort_direction
                                 ]])
                                }}"
                                >
                                    <span class="flex-1">{{ $dataType->getColumnLabel($column) }}</span>
                                    <i class="{{ $classes }}"></i>
                                </a>
                            </th>
                        @endforeach
                        <th class="p-3 cursor-pointer relative whitespace-no-wrap border-b-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data->items() as $item)
                        <tr class="bg-black hover:bg-gray-200  hover:text-gray-700">
                            @foreach($dataType->list_display as $column)
                                <td class="relative whitespace-no-wrap p-3 border-t">
                                    {{ $item->{$column} }}
                                </td>
                            @endforeach
                            <td class="relative cursor-pointer whitespace-no-wrap p-3 border-t text-right text-lg">
                                @foreach($actions as $action)
                                    @include('timoneiro::_models.partials.actions')
                                @endforeach
                            </td>
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
