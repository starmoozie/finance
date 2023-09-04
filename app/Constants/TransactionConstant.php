<?php

namespace App\Constants;

class TransactionConstant
{
    const EXPENSE  = 0;
    const SALE     = 1;
    const PURCHASE = 2;

    const ALL      = [
        ['label' => 'expense', 'value' => 0, 'color' => 'warning'],
        ['label' => 'sale', 'value' => 1, 'color' => 'success'],
        ['label' => 'purchase', 'value' => 2, 'color' => 'danger'],
    ];
}
