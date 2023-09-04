<?php

namespace App\Constants;

class TransactionConstant
{
    const SALE     = 0;
    const EXPENSE  = 1;
    const PURCHASE = 2;

    const ALL      = [
        ['label' => 'sale', 'value' => 0, 'color' => 'success'],
        ['label' => 'expense', 'value' => 1, 'color' => 'warning'],
        ['label' => 'purchase', 'value' => 2, 'color' => 'danger'],
    ];
}
