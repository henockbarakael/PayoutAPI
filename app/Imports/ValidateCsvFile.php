<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ValidateCsvFile implements ToCollection, WithHeadingRow
{
    /**
   * @var errors
   */
    public $errors = [];
    
    /**
     * @var isValidFile
     */
    public $isValidFile = false;
    
    /**
     * ValidateCsvFile constructor.
     * @param StoreEntity $store
     */
    public function __construct()
    {
        //
    }
    public function collection(Collection $rows){
      $errors = [];
      if (count($rows) > 1) {
          $rows = $rows->slice(1);
          foreach ($rows as $key => $row) {
              $validator = Validator::make($row->toArray(), [
                'credit_account' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'amount' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'currency' => [
                    'required',
                    'string',
                    'max:255',
                ],
              ]);
 
              if ($validator->fails()) {
                  $errors[$key] = $validator;
              }
          }
          $this->errors = $errors;
          $this->isValidFile = true;
      }
    }
 
    public function startRow(): int{
        return 1;
    }
}
