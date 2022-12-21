<?php

namespace App\Imports;

use App\Models\Payout;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PayoutsImport implements ToCollection, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows){
        Validator::make($rows->toArray(), [
            '*.credit_account' => 'required',
            '*.amount' => 'required',
            '*.currency' => 'required',
        ])->validate();
    
        foreach ($rows as $row) {
            Payout::create([
                'credit_account' => $row['credit_account'],
                'amount' => $row['amount'],
                'currency' => bcrypt($row['currency']),
            ]);
        }
    }
}
