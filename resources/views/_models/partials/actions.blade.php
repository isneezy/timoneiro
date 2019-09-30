@if($item)
    @php
        $class = get_class($action);
        /** @var \Isneezy\Timoneiro\Actions\AbstractAction $action */
        $action = new $class($dataType, $item);
    @endphp
    @can($action->getPolicy(), $item)
        <a
            href="{{ $action->getRoute($dataType->slug) }}"
            {!! $action->convertAttributesToHtml() !!}
            title="{{ $action->getTitle() }}">
            <i class="{{ $action->getIcon() }}"></i>
        </a>
    @endcan
@endif
