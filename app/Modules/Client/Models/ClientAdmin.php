<?php
namespace App\Modules\Client\Models;

use App\Models\Base\BaseModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;

class ClientAdmin extends BaseModel implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'client_admin';

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
        [
            'username', 'email',
            'password','gender',
            'first_name', 'last_name',
            'company', 'title',
            'email', 'telephone',
            'country_id', 'language_code',
            'contact_name','contact_email',
            'customer_number', 'status',
            'is_read_policy'
        ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];
}
