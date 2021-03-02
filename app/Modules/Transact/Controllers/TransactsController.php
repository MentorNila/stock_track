<?php

namespace App\Modules\Transact\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Transact\Models\Transact;
use App\Modules\User\Models\User;
use Illuminate\Http\Request;

class TransactsController extends Controller
{
    public function index()
    {
        $transactions = Transact::get();
        $users = User::get();
        return view('Transact::index', compact('transactions', 'users'));
    }

    public function pending_transact()
    {
        $transactions = Transact::where('statuts', '=', 1)->get();
        return view('Transact::pending', compact('transactions'));
    }

    public function store(Request $request) {
        $transactionData = $request->all();
        $activeCompany = $request->session()->get('activeCompany');
        $transactionData['company_id'] = $activeCompany->id;
        Transact::create($transactionData);
        return redirect()->route('admin.logTransacts.index');
    }

    public function delete($feedbackId) {
        Transact::destroy($feedbackId);
        return redirect()->route('admin.feedbacks.index');
    }
}
