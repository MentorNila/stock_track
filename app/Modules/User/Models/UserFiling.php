<?php namespace App\Modules\User\Models;

use App\Models\Multitenancy\MultitenancyModel;

class UserFiling extends MultitenancyModel
{
    public $table = 'user_filings';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'filing_id',
    ];

    public static function store($userIds, $filingId){
        static::where('filing_id', $filingId)->delete();
        if (!empty($userIds)){
            foreach ($userIds['users'] as $userId){
                $data['user_id'] = $userId;
                $data['filing_id'] = $filingId;
                static::create($data);
            }
        }
    }
}
