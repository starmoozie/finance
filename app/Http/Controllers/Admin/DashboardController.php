<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Charts\WeeklyTransactionsChartController;
use Starmoozie\CRUD\app\Library\Widget;
use App\Constants\TransactionConstant;
use Illuminate\Routing\Controller;
use App\Models\Transaction;

class DashboardController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(starmoozie_middleware());
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $this->data['title'] = __('starmoozie::base.dashboard'); // set the page title
        $this->data['breadcrumbs'] = [
            __('starmoozie::crud.admin')     => starmoozie_url('dashboard'),
            __('starmoozie::base.dashboard') => false,
        ];

        // Widgets
        Widget::add()
            ->to('before_content')
            ->class('row')
            ->type('div')
            ->content([...$this->widgets(), ...$this->weeklyTransactionsCharts()]);

        return view(starmoozie_view('dashboard'), $this->data);
    }

    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(starmoozie_url('dashboard'));
    }

    /**
     * setup widgets
     */
    private function widgets(): array
    {
        $transactions = Transaction::selectCurrentMonth()
            ->sumEachType()
            ->orderBy('type')
            ->get();

        $size = 12 / ($transactions->count() + 1);

        return [
            ...[$this->mapCardWidgets(
                'balance',
                'primary',
                $this->calculateBalance($transactions),
                $size
            )],
            ...$this->handleEloquentToWidgets($transactions, $size)
        ];
    }

    /**
     * Calculate balance ( total sales - total expenses )
     */
    private function calculateBalance($transactions)
    {
        $sales    = $transactions->where('type', TransactionConstant::SALE)->sum('total_price');
        $expenses = $transactions->where('type', '!=', TransactionConstant::SALE)->sum('total_price');

        return $sales - $expenses;
    }

    /**
     * Mapping eloquent query to widgets
     */
    private function handleEloquentToWidgets($transactions, $size): array
    {
        return $transactions->map(function($transaction) use ($size) {
            $constant = collect(TransactionConstant::ALL)->where('value', $transaction->type)->first();

            return $this->mapCardWidgets(
                $constant['label'],
                $constant['color'],
                $transaction->total_price,
                $size
            );
        })->toArray();
    }

    /**
     * Mapping widget attributes
     */
    private function mapCardWidgets($label, $color, $value, $size): array
    {
        return [
            'wrapper'       => ['class' => "col-md-{$size}"],
            'class'         => "card shadow mb-2",
            'type'          => 'progress_white',
            'progress'      => 100,
            'progressClass' => "progress-bar bg-{$color}",
            'value'         => rupiah($value),
            'description'   => __("starmoozie::title.{$label}"),
            'hint'          => __("starmoozie::title.hint_amount_dashboard")
        ];
    }

    private function weeklyTransactionsCharts()
    {
        return [
            [
                'type'       => 'chart',
                'controller' => WeeklyTransactionsChartController::class,
                'class'      => 'card mt-4 shadow',
                'wrapper'    => ['class'=> 'col-md-12'] ,
                'content'    => [
                    'header' => __('starmoozie::title.hint_weekly_transactions'),
                ],
            ]
        ];
    }
}
