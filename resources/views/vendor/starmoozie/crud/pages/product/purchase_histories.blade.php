<thead>
    <tr>
        <th>{{ __('starmoozie::title.created') }}</th>
        <th>{{ __('starmoozie::title.qty') }}</th>
        <th>{{ __('starmoozie::title.buy_item') }}</th>
        <th>{{ __('starmoozie::title.sell_item') }}</th>
        <th>{{ __('starmoozie::title.sub_total') }}</th>
        <th>{{ __('starmoozie::title.type_profit') }}</th>
        <th>{{ __('starmoozie::title.profit_item') }}</th>
        <th>{{ __('starmoozie::title.profit_total') }}</th>
    </tr>
</thead>
<tbody>
    @foreach($column['value']->sortByDesc('created_at') as $key => $purchase)
        <?php
            $value         = collect($purchase->details)->where('product_id', $entry->id)->first();
            $buy_item    = $value['sub_total'] / $value['qty'];
            $profit_item = calculateProfit($value['type_profit'], $value['profit'], $buy_item);
            $sell_item   = $buy_item + $profit_item;
            $profitTotal = $profit_item * $value['qty'];
            $type_profit = $value['type_profit'] == 1 ? "Rp ".rupiah($profit_item) : rupiah($value['profit'])." %";
        ?>
        <tr>
            <td>{{ $purchase->created_at }}</td>
            <td>{{ rupiah($value['qty']) }}</td>
            <td>{{ rupiah($buy_item) }}</td>
            <td>{{ rupiah($sell_item) }}</td>
            <td>{{ rupiah($value['sub_total']) }}</td>
            <td>{{ $type_profit }}</td>
            <td>{{ rupiah($profit_item) }}</td>
            <td>{{ rupiah($profit_item * $value['qty']) }}</td>
        </tr>
    @endforeach
</tbody>
