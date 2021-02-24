<?php

namespace App\Modules\AuditLogs\Models;

use App\Models\Multitenancy\MultitenancyModel;

class AuditLog extends MultitenancyModel
{
    public $table = 'audit_logs';

    protected $fillable = [
        'description',
        'subject_id',
        'subject_type',
        'user_id',
        'properties',
        'host',
    ];

    protected $casts = [
        'properties' => 'collection',
    ];

    public function user()
    {
        return $this->belongsTo('App\Modules\User\Models\User');
    }
}
