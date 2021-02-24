<?php
namespace App\Modules\Register\Models;

use App\Models\Base\BaseModel;
use App\Modules\Plans\Models\Plan;
use App\Modules\Register\Classes\ClientRequestStatusCode;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientRequest extends BaseModel
{
    use SoftDeletes;

    protected $table = 'clients_requests';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'company',
        'job_title',
        'country',
        'method_of_contact',
        'request',
        'plan_id',
        'status'
    ];

    public function updateRequestStatus($id)
    {
        $APPROVED = ClientRequestStatusCode::$APPROVED;
        if (ClientRequest::find($id)->update(['status' => $APPROVED])) {
            return true;
        }
        return false;
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

}
