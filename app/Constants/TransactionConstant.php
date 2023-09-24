<?php

namespace App\Constants;

class TransactionConstant
{
    const SALE     = 0;
    const PURCHASE = 1;
    const EXPENSE  = 2;

    const ALL      = [
        ['label' => 'sale', 'value' => Self::SALE, 'color' => 'success'],
        ['label' => 'purchase', 'value' => Self::PURCHASE, 'color' => 'warning'],
        ['label' => 'expense', 'value' => Self::EXPENSE, 'color' => 'danger'],
    ];
}
