<thead>
    <tr>
        <th>{{ __('starmoozie::title.product') }}</th>
        <th class="text-right">{{ __('starmoozie::title.qty') }}</th>
        <th class="text-right">{{ __('starmoozie::title.buy_item') }}</th>
        <th class="text-right">{{ __('starmoozie::title.sell_item') }}</th>
        <th class="text-right">{{ __('starmoozie::title.total_price') }}</th>
        <th class="text-right">{{ __('starmoozie::title.calculated_profit') }}</th>
        <th class="text-right">{{ __('starmoozie::title.total_profit') }}</th>
    </tr>
</thead>
<tbody>
    <?php
        $profit = 0;
    ?>
    @foreach($column['value'] as $key => $value)
        <?php
            $pivot        = $value->pivot;
            $total_profit = $pivot->calculated_profit * $pivot->qty;
            $profit      += $total_profit;
        ?>
        <tr>
            <td>{{ $value->name }}</td>
            <td class="text-right">{{ rupiah($pivot->qty) }}</td>
            <td class="text-right">{{ rupiah($pivot->buy_price) }}</td>
            <td class="text-right">{{ rupiah($pivot->sell_price) }}</td>
            <td class="text-right">{{ rupiah($pivot->total_price) }}</td>
            <td class="text-right">{{ rupiah($pivot->calculated_profit) }}</td>
            <td class="text-right">{{ rupiah($total_profit) }}</td>
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
        <th class="text-right">{{ rupiah($profit) }}</th>
    </tr>
</tfoot>
