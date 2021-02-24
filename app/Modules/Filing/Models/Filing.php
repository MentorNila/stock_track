<?php

namespace App\Modules\Filing\Models;

use App\Models\Multitenancy\MultitenancyModel;
use App\Modules\User\Models\User;
use App\Notifications\StatusChanged;
use App\Traits\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;

class Filing extends MultitenancyModel
{
    use SoftDeletes, Auditable, \App\Traits\Notification;

    public $table = 'filings';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'company_id',
        'filing_type',
        'amendment_flag',
        'status',
        'approved',
        'fiscal_year_end_date',
        'fiscal_period_focus',
        'fiscal_year_focus',
    ];

    public function store($data){
        return static::create($data);
    }

    public static function updateStatus($filingId, $status){
        return static::find($filingId)->update(['status' => $status]);
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function($filing){
            if ($filing->getOriginal('status') !== $filing->status){
                $users = User::all();
                Notification::send($users, new StatusChanged($filing));
            }
        });
    }

}
