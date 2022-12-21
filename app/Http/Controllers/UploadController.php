<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UploadController extends Controller
{
    public function upload(Request $request){ 
        $file = $request->file('file'); 
        if($file){ 
            $row = 1; 
            $array = []; 
            if (($handle = fopen($file, "r")) !== FALSE) { 
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) { 
                    if($row > 1){ 
                        Http::post('http://127.0.0.1:8000/api/v1/csv/upload', [ 'credit_account' => $data[0], 'amount' => $data[1], 'currency' => $data[1], ]); 
                        array_push($array,$data[0]); 
                    } 
                    $request->session()->flash('status', 'Users '.implode($array,", ").' created successfully!'); 
                    $row++; 
                } 
            } 
        }
        else{ 
            $request->session()->flash('error', 'Please choose a file to submit.'); 
        } 
        return redirect()->back();

    }
}
