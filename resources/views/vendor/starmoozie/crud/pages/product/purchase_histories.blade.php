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
                    <th>{{ __('starmoozie::title.qty') }}</th>
                    <th>{{ __('starmoozie::title.buy_price') }}</th>
                    <th>{{ __('starmoozie::title.sell_price') }}</th>
                    <th>{{ __('starmoozie::title.buy_item') }}</th>
                    <th>{{ __('starmoozie::title.sell_item') }}</th>
                    <th>{{ __('starmoozie::title.profit_item') }}</th>
                    <th>{{ __('starmoozie::title.created') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($column['value'] as $key => $purchase)
                    <?php
                        $value         = collect($purchase->details)->where('product_id', $entry->id)->first();
                        $profitPerItem = $value['profit'] ?? 0;
                        $profitTotal   = $profitPerItem * $value['qty'];
                        $pricePerItem  = $value['sub_total'] / $value['qty'];
                    ?>
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td>{{ rupiah($value['qty']) }}</td>
                        <td>{{ rupiah($value['sub_total']) }}</td>
                        <td>{{ rupiah($value['sub_total'] + $profitTotal) }}</td>
                        <td>{{ rupiah($pricePerItem) }}</td>
                        <td>{{ rupiah($pricePerItem + $profitPerItem) }}</td>
                        <td>{{ rupiah($profitPerItem) }}</td>
                        <td>{{ $purchase->created_at }}</td>
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