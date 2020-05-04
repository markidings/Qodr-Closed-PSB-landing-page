<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingBankAccount extends Model
{
    protected $table = 'setting_bank_accounts';

    protected $fillable = [
        'bank',
        'name',
        'account_number'
    ];
}
