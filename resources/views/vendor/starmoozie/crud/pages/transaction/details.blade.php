@php
	$column['value'] = $column['value'] ?? data_get($entry, $column['name']);
    $column['columns'] = $column['columns'] ?? ['value' => 'Value'];

    if($column['value'] instanceof \Closure) {
        $column['value'] = $column['value']($entry);
    }

	// if this attribute isn't using attribute casting, decode it
	if (is_string($column['value'])) {
	    $column['value'] = json_decode($column['value']);
    }
@endphp

<span>
    @if ($column['value'] && count($column['columns']))

    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')

    <div class="table-responsive">
        <table class="table table-bordered table-condensed table-striped m-b-0">
            <thead>
                <tr>
                    <th>#</th>
                    @foreach($column['value'][0] as $tableColumnKey => $tableColumnLabel)
                        <th>{{ ucwords($tableColumnKey) }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($column['value'] as $key => $value)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        @foreach($value as $label => $null)
                            <td>{!! is_numeric($value[$label]) ? rupiah($value[$label]) : $value[$label] !!}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
    
    @else
    
    {{ $column['default'] ?? '-' }}

	@endif
</span>