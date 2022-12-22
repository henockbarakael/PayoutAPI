<?php

namespace App\Imports;

use App\Models\Payout;
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

class PayoutsImport implements ToCollection, WithHeadingRow, SkipsOnError, WithValidation, SkipsOnFailure, WithChunkReading, ShouldQueue, WithEvents
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
            Payout::create([
                'credit_account' => $row['credit_account'],
                'amount' => $row['amount'],
                'currency' => $row['currency'],
                'userid' => Auth::user()->id,
            ]);
        }
    }

    public function rules(): array {
        return [
            '*.credit_account' => 'required',
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
