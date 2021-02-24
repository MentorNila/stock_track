<?php
namespace App\Modules\Filing\Models;

use App\Models\Multitenancy\MultitenancyModel;
use Illuminate\Database\Eloquent\Model;

class FilingFinancialData extends MultitenancyModel
{

    public $table = 'filing_financial_data';
    public $timestamps = false;

    protected $fillable = [
        'filing_id',
        'fs_type',
        'fs_file_path',
    ];

    public function store($data)
    {
        return static::create($data);
    }
}
