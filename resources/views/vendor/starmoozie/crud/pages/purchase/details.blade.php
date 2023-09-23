<thead>
    <tr>
        <th>{{ __('starmoozie::title.product') }}</th>
        <th class="text-right">{{ __('starmoozie::title.qty') }}</th>
        <th class="text-right">{{ __('starmoozie::title.buy_item') }}</th>
        <th class="text-right">{{ __('starmoozie::title.sell_item') }}</th>
        <th class="text-right">{{ __('starmoozie::title.total_price') }}</th>
        <th>{{ __('starmoozie::title.type_profit') }}</th>
        <th class="text-right">{{ __('starmoozie::title.amount_profit') }}</th>
        <th class="text-right">{{ __('starmoozie::title.calculated_profit') }}</th>
        <th class="text-right">{{ __('starmoozie::title.total_profit') }}</th>
    </tr>
</thead>
<tbody>
    @foreach($column['value'] as $key => $value)
        <?php
            $pivot        = $value->pivot;
            $type_profit  = App\Constants\TypeProfitConstant::ALL[$pivot->type_profit];
            $total_profit = $pivot->calculated_profit * $pivot->qty;
        ?>
        <tr>
            <td>{{ $value->name }}</td>
            <td class="text-right">{{ rupiah($pivot->qty) }}</td>
            <td class="text-right">{{ rupiah($pivot->buy_price) }}</td>
            <td class="text-right">{{ rupiah($pivot->sell_price) }}</td>
            <td class="text-right">{{ rupiah($pivot->total_price) }}</td>
            <td>{{ __("starmoozie::title.{$type_profit}") }}</td>
            <td class="text-right">{{ rupiah($pivot->amount_profit) }}</td>
            <td class="text-right">{{ rupiah($pivot->calculated_profit) }}</td>
            <td class="text-right">{{ rupiah($total_profit) }}</td>
        </tr>
    @endforeach
</tbody>
