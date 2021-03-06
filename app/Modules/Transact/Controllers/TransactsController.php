<?php

namespace App\Modules\Transact\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Transact\Models\Transact;
use App\Modules\Company\Models\Company;
use App\Modules\Shareholder\Models\Shareholder;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactsController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transact::get();
        $users = User::get();
        $companies = Company::get();
        $activeCompany = $request->session()->get('activeCompany');
        if($activeCompany->id) {
            $transactions = Transact::where('company_id', $activeCompany->id)->get();
        }
        $companiesArray = [];
        $usersArray = [];
        foreach($companies as $currentCompany) {
            $companiesArray[$currentCompany->id] = $currentCompany->name;
        }
        foreach($users as $currentUser) {
            $usersArray[$currentUser->id] = $currentUser->name;
        }
        $shareholders = Shareholder::where('company_id', $activeCompany->id)->get();
        $shareholdersArray = [];
        foreach($shareholders as $currentShareholder) {
            $shareholdersArray[$currentShareholder->id] = $currentShareholder->ref_name;
        }
        return view('Transact::index', compact('transactions', 'users', 'companiesArray', 'usersArray', 'shareholders', 'shareholdersArray'));
    }

    public function pending_transact(Request $request)
    {
        $transactions = Transact::where('status', '=', 1)->get();
        $activeCompany = $request->session()->get('activeCompany');
        if(isset($activeCompany->id)) { 
            $transactions = Transact::where('status', 1)->where('company_id', $activeCompany->id)->get();
        }
        return view('Transact::pending', compact('transactions'));
    }

    public function edit($transactionId) {
        $users = User::get();
        $transaction = Transact::find($transactionId);
        return view('Transact::edit', compact('transaction', 'users'));
    }

    public function store(Request $request) {
        $loggedInUser = Auth::user();
        $loggedInUserId = $loggedInUser->id;
        $transactionData = $request->all();
        $activeCompany = $request->session()->get('activeCompany');
        $transactionData['company_id'] = $activeCompany->id;
        $transactionData['assigned_to'] = $loggedInUserId;
        Transact::create($transactionData);
        return redirect()->route('admin.logTransacts.index');
    }

    public function update(Request $request, $transactionId)
    {
        $transaction = Transact::find($transactionId);
        $transaction->update($request->all());
        
        return redirect()->route('admin.logTransacts.index');
    }

    public function delete($transactionId) {
        Transact::destroy($transactionId);
        return redirect()->route('admin.logTransacts.index');
    }
}
