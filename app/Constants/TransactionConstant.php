<?php

namespace App\Constants;

class TransactionConstant
{
    const SALE     = 0;
    const PURCHASE = 1;
    const EXPENSE  = 2;

    const ALL      = [
        ['label' => 'sale', 'value' => 0, 'color' => 'success'],
        ['label' => 'purchase', 'value' => 1, 'color' => 'warning'],
        ['label' => 'expense', 'value' => 2, 'color' => 'danger'],
    ];
}
