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
                    <th>{{ __('starmoozie::title.old_stock') }}</th>
                    <th>{{ __('starmoozie::title.new_stock') }}</th>
                    <th>{{ __('starmoozie::title.old_price') }}</th>
                    <th>{{ __('starmoozie::title.new_price') }}</th>
                    <th>{{ __('starmoozie::title.created') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($column['value']->sortByDesc('created_at')->values() as $key => $history)
                    <?php
                        $old = $history->properties['old'];
                        $new = $history->properties['attributes'];
                    ?>

                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ rupiah($old['stock']) }}</td>
                        <td>{{ rupiah($new['stock']) }}</td>
                        <td>{{ rupiah($old['price']) }}</td>
                        <td>{{ rupiah($new['price']) }}</td>
                        <td>{{ $history->created_at }}</td>
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