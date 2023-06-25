<a href="{{ $path }}" {!! count($attributes) ? $column->arrayToAttributes($attributes) : '' !!}>{!! html_entity_decode($title) !!}</a>
