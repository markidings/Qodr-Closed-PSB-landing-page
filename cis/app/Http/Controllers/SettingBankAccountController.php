<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SettingBankAccount as BankAccount;
use App\Models\Role;

class SettingBankAccountController extends Controller
{
    public function __construct()
    {
        // authorize role
        $adminCS = Role::ADMIN_CS;
        $adminSystem = Role::ADMIN_SYSTEM;
        $this->middleware("role:{$adminCS},{$adminSystem}");
    }

    public function index()
    {
        $bankAccount = BankAccount::first();

        return view('bank-account.index', compact('bankAccount'));
    }

    public function edit()
    {
        $bankAccount = BankAccount::first();

        return view('bank-account.edit', compact('bankAccount'));
    }

    public function update(Request $request)
    {
        $bankAccountData = $request->all();

        $bankAccount = BankAccount::first();
        $bankAccount
            ? $bankAccount->update($bankAccountData)
            : BankAccount::create($bankAccountData);

        flash('Data berhasil diperbarui', 'success');

        return redirect()->route('setting.bank-account');
    }
}
