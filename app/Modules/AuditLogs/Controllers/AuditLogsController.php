<?php

namespace App\Modules\AuditLogs\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\AuditLogs\Models\AuditLog;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuditLogsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('audit_log_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $auditLogs = AuditLog::where('user_id', Auth::user()->id)->get();
        if(Auth::user()->is_superadmin){
            $auditLogs = AuditLog::all();
        }


        return view('AuditLogs::index', compact('auditLogs'));
    }

    public function show(AuditLog $auditLog)
    {
        abort_if(Gate::denies('audit_log_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('AuditLogs::show', compact('auditLog'));
    }
}
