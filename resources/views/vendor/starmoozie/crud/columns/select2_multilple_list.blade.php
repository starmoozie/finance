{{-- relationships with pivot table (n-n) --}}
@php
    $column['value'] = $column['value'] ?? data_get($entry, $column['name'], []);
    $column['escaped'] = $column['escaped'] ?? true;
    $column['prefix'] = $column['prefix'] ?? '';
    $column['suffix'] = $column['suffix'] ?? '';
    $column['limit'] = $column['limit'] ?? 40;
    $column['attribute'] = $column['attribute'] ?? (new $column['model'])->identifiableAttribute();

    if($column['value'] instanceof \Closure) {
        $column['value'] = $column['value']($entry);
    }

    if($column['value'] instanceof \Illuminate\Database\Eloquent\Collection && $column['value'] !== null && !$column['value']->isEmpty()) {
        $related_key = $column['value']->first()->getKeyName();
        $column['value'] = $column['value']->pluck($column['attribute'], $related_key);
    }

    if($column['value'] instanceof \Illuminate\Support\Collection) {
        $column['value'] = $column['value']
            ->each(function($value) use ($column) {
                $value = Str::limit($value, $column['limit'], '…');
            })
            ->toArray();
    } elseif(!is_array($column['value'])) {
        $column['value'] = collect($column['value']->{$column['attribute']})->pluck('name');
    }
@endphp

<span>
    @if(!empty($column['value']))
        {{ $column['prefix'] }}
        <ul class="mb-n1 ml-n4">
            @foreach($column['value'] as $key => $text)
                @php
                    $related_key = $key;
                @endphp
                <li>
                    @if(!$column['url'])
                        {!! $text !!}
                    @else
                        <?php
                            $url = str_replace('{id}', $key, $column['url']);
                        ?>
                        <a href="{{ $url }}">
                            {!! $text !!}
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
        {{ $column['suffix'] }}
    @else
        {{ $column['default'] ?? '-' }}
    @endif
</span>
