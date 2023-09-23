<thead>
    <tr>
        <th>#</th>
        <th>{{ __('starmoozie::title.product') }}</th>
        <th>{{ __('starmoozie::title.qty') }}</th>
        <th>{{ __('starmoozie::title.buy_price') }}</th>
        <th>{{ __('starmoozie::title.sell_price') }}</th>
        <th>{{ __('starmoozie::title.sub_total') }}</th>
        <th>{{ __('starmoozie::title.profit') }}</th>
    </tr>
</thead>
<tbody>
    <?php
        $profit = 0;
    ?>
    @foreach($column['value'] as $key => $value)
        <?php
            $profit = ($value['sell_price'] - $value['buy_price']) * $value['qty'];
        ?>
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $value['product'] }}</td>
            <td>{{ rupiah($value['qty']) }}</td>
            <td>{{ rupiah($value['buy_price']) }}</td>
            <td>{{ rupiah($value['sell_price']) }}</td>
            <td>{{ rupiah($value['sub_total']) }}</td>
            <td>{{ rupiah($profit) }}</td>
        </tr>
    @endforeach
</tbody>
<tfoot>
    <tr>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th>{{ rupiah($profit) }}</th>
    </tr>
</tfoot>
