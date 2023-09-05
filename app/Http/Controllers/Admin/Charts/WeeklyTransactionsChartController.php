<?php

namespace App\Http\Controllers\Admin\Charts;

use Starmoozie\CRUD\app\Http\Controllers\ChartController;
use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use App\Constants\TransactionConstant;
use App\Models\Transaction;

/**
 * Class WeeklyTransactionsChartController
 * @package App\Http\Controllers\Admin\Charts
 * @property-read \Starmoozie\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class WeeklyTransactionsChartController extends ChartController
{
    public function setup()
    {
        $this->chart = new Chart();

        // MANDATORY. Set the labels for the dataset points
        $labels = [];
        for ($days_backwards = 6; $days_backwards >= 0; $days_backwards--) {
            if ($days_backwards == 1) {
            }
            $labels[] = \Carbon\Carbon::now()->subDays($days_backwards)->format('l');
        }
        $this->chart->labels($labels);

        // RECOMMENDED. Set URL that the ChartJS library should call, to get its data using AJAX.
        $this->chart->load(starmoozie_url('charts/weekly-transactions'));

        // OPTIONAL
        $this->chart->minimalist(false);
        $this->chart->displayLegend(true);
    }

    /**
     * Respond to AJAX calls with all the chart data points.
     *
     * @return json
     */
    public function data()
    {
        for ($days_backwards = 6; $days_backwards >= 0; $days_backwards--) {
            $transactions = Transaction::whereDate('created_at', today()->subDays($days_backwards))
                ->countEachType()
                ->orderBy('type')
                ->get();
            
            $sales[]     = $transactions->where('type', TransactionConstant::SALE)->first()->total ?? 0;
            $purchases[] = $transactions->where('type', TransactionConstant::PURCHASE)->first()->total ?? 0;
            $expenses[]  = $transactions->where('type', TransactionConstant::EXPENSE)->first()->total ?? 0;
        }

        $this->chart->dataset(__('starmoozie::title.sale'), 'bar', $sales)
            ->color('rgb(77, 189, 116)')
            ->backgroundColor('rgba(77, 189, 116, 0.3)');

        $this->chart->dataset(__('starmoozie::title.purchase'), 'bar', $purchases)
            ->color('rgb(255, 193, 7)')
            ->backgroundColor('rgba(255, 193, 7, 0.3)');

        $this->chart->dataset(__('starmoozie::title.expense'), 'bar', $expenses)
            ->color('rgba(223, 70, 88)')
            ->backgroundColor('rgba(223, 70, 88, 0.3)');
    }
}