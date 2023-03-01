<?php

namespace App\Imports;

use App\Models\Remboursement;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;

class RemboursementImport implements ToCollection, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure, WithChunkReading, ShouldQueue, WithEvents
{
    use Importable, SkipsErrors, SkipsFailures, RegistersEventListeners;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            Remboursement::create([
                "id" => $row['id'],
                "merchant_code"=>$row['merchant_code'],
                "thirdparty_reference"=>$row['thirdparty_reference'],
                "amount"=>$row['amount'],
                "currency"=>$row['currency'],
                "method"=>$row['method'],
                "customer_details"=>$row['customer_details'],
                "paydrc_reference"=>$row['paydrc_reference'],
                "status"=>$row['status'],
                "action"=>$row['action'],
                "switch_reference"=>$row['switch_reference'],
                "telco_reference"=>$row['telco_reference'],
                "callback_url"=>$row['callback_url'],
                "status_description"=>$row['status_description'],
                "user_id"=>Auth::user()->id
            ]);
        }
    }

    public function rules(): array {
        return [
            '*.paydrc_reference' => 'required',
            '*.amount' => 'required',
            '*.currency' => 'required',
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public static function afterImport(AfterImport $event)
    {
    }

    public function onFailure(Failure ...$failure)
    {
    }
}
