<?php

namespace App\Imports;

use App\Models\payout_test;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PayoutTestsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new payout_test([
                "credit_account" => $row['credit_account'],
                "amount" => $row['amount'],
                "currency" => $row['currency'],
        ]);
    }
}
