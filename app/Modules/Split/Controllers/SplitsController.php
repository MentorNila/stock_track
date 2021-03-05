<?php

namespace App\Modules\Split\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Split\Models\Split;
use Gate;
use Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SplitsController extends Controller
{
    public function index(Request $request)
    {
        $splits = Split::get();
        return view('Split::index', compact('splits'));
    }

    public function edit($splitId) {
        $split = Split::find($splitId);
        return view('Split::edit', compact('split'));
    }

    public function update(Request $request, $splitId)
    {
        $split = Split::find($splitId);
        $split->update($request->all());
        
        return redirect()->route('admin.splits.index');
    }

    public function store(Request $request) {
        $splitData = $request->all();
        $activeCompany = $request->session()->get('activeCompany');
        $splitData['company_id'] = $activeCompany->id;
        Split::create($splitData);
        return redirect()->route('admin.splits.index');
    }

    public function delete($splitId) {
        Split::destroy($splitId);
        return redirect()->route('admin.splits.index');
    }
}
