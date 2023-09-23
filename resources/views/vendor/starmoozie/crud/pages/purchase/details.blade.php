<thead>
    <tr>
        <th>#</th>
        <th>{{ __('starmoozie::title.product') }}</th>
        <th>{{ __('starmoozie::title.qty') }}</th>
        <th>{{ __('starmoozie::title.buy_item') }}</th>
        <th>{{ __('starmoozie::title.sell_item') }}</th>
        <th>{{ __('starmoozie::title.sub_total') }}</th>
        <th>{{ __('starmoozie::title.type_profit') }}</th>
        <th>{{ __('starmoozie::title.profit_item') }}</th>
    </tr>
</thead>
<tbody>
    @foreach($column['value'] as $key => $value)
        <?php
            $buy_item  = $value['sub_total'] / $value['qty'];
            $profit    = calculateProfit($value['type_profit'], $value['profit'], $buy_item);
            $sell_item = $buy_item + $profit;
        ?>
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $value['product'] }}</td>
            <td>{{ rupiah($value['qty']) }}</td>
            <td>{{ rupiah($buy_item) }}</td>
            <td>{{ rupiah($sell_item) }}</td>
            <td>{{ rupiah($value['sub_total']) }}</td>
            <td>{{ $value['type_profit_formatted'] }}</td>
            <td>{{ rupiah($value['profit']) }}</td>
        </tr>
    @endforeach
</tbody>
