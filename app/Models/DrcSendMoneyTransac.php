<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DrcSendMoneyTransac extends Model
{
    use HasFactory;
    protected $connection = 'paydrc';
    protected $table = 'drc_send_money_transac';
    protected $guarded = [];
}
