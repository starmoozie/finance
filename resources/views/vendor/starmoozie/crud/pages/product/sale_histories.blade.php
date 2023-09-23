<thead>
    <tr>
        <th>#</th>
        <th>{{ __('starmoozie::title.qty') }}</th>
        <th>{{ __('starmoozie::title.total_price') }}</th>
        <th>{{ __('starmoozie::title.price_item') }}</th>
        <th>{{ __('starmoozie::title.created') }}</th>
    </tr>
</thead>
<tbody>
    @foreach($column['value'] as $key => $purchase)
        <?php
            $value = collect($purchase->details)->where('product_id', $entry->id)->first();
        ?>
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ rupiah($value['qty']) }}</td>
            <td>{{ rupiah($value['sub_total']) }}</td>
            <td>{{ rupiah($value['sell_price']) }}</td>
            <td>{{ $purchase->created_at }}</td>
        </tr>
    @endforeach
</tbody>
