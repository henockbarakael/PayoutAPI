<?php

namespace App\Imports;

use App\Models\Payout;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PayoutsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Payout([
            "credit_account" => $row['credit_account'],
            "amount" => $row['amount'],
            "currency" => $row['currency'],
        ]);
    }
}
