<?php
namespace App\Modules\Client\Models;

use App\Models\Base\BaseModel;
use App\Modules\Plans\Models\Plan;
use App\Modules\Register\Classes\ClientRequestStatusCode;
use App\Modules\Register\Models\ClientRequest;
use DateTime;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Client\Classes\ClientStatusCode;

class Client extends BaseModel
{
    use SoftDeletes;

    protected $table = 'clients';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'subdomain', 'name', 'active_key',
        'active_date', 'expired_date',
        'status', 'admin_id',
        'plan_id', 'is_domain'
    ];

    public function getActiveDateAttribute($value)
    {
        return DateTime::createFromFormat('Y-m-d H:i:s', $value)->format('Y-m-d');
    }

    public function getExpiredDateAttribute($value)
    {
        if (is_null($value)) {
            return '';
        } else {
            return DateTime::createFromFormat('Y-m-d H:i:s', $value)->format('Y-m-d');
        }
    }


    protected static $currentClient = null;

    public static function setCurrentClient($client)
    {
        static::$currentClient = $client;
    }

    public function scopeInitedTables($query)
    {
        return $query;//->whereIn('status', [ClientStatusCode::$DECLINED, ClientStatusCode::$ACTIVATED]);
    }

    public static function getCurrentClient()
    {
        if (is_null(static::$currentClient)) {
            $host = request()->getHost();
            if ($host == config('app.host')) {
                $subdomain = ''; // default subdomain
            } else if (ends_with($host, config('app.host')) && (substr($host, -strlen(config('app.host')) - 1, 1) == '.')) {
                $subdomain = substr($host, 0, -strlen(config('app.host')) - 1);
            } else {
                $subdomain = $host;
            }
            $dotIndex = strpos($subdomain, '.');

           if($dotIndex > 0) {
               $subdomain = substr($subdomain, 0, $dotIndex);
           } else {
               $subdomain = '';
           }
            try {
                static::$currentClient = static::where(['subdomain' => $subdomain])->first();
            } catch (\Exception $e) {
                // artisan command comes into here
                // do nothing
            }
        }

        return static::$currentClient;
    }

    public static function getCurrentClientId()
    {
        $client = static::getCurrentClient();
        return $client ? $client->id : 0;
    }

    public static function setCurrentClientBySubdomain($subdomain)
    {
        $client = Client::where('subdomain', $subdomain)->first();
        if (!empty($client)) {
            Client::setCurrentClient($client);
        }
        return $client;
    }

    public function listAllClient()
    {
        return $all = $this::with('clientAdmin')->where('status', '<>', ClientStatusCode::$PENDING)->orderBy('id', 'DESC')->get();
    }

    public function getClientByID($id)
    {
        return $this::find($id);
    }

    public function checkToken($id, $token)
    {
        if (!empty($token)) {
            $clientByToken = $this::where('active_key', '=', $token)->where('subdomain', '=', $id)->where('status', ClientStatusCode::$PENDING)->first();
            if ($clientByToken) {
                return $clientByToken;
            } else {
                return false;
            }
        }
        return false;
    }

    public function updateClient($id, $data)
    {
        $client = $this::find($id)->first();
        if (!empty($client)) {
            foreach ($data as $key => $value) {
                if ($value == "") {
                    //unset($data[$key]);
                }
            }
            return $this::find($id)->update($data);
        }
        return false;
    }

    public function updateActive($id)
    {
        $currentTime = date("Y-m-d");
        $trails_day = config('modules.client.number_trials_day');
        $expired_date = date('Y-m-d', strtotime("+" . $trails_day . " day"));
        $ACTIVATED = ClientStatusCode::$ACTIVATED;
        if ($this::find($id)->update(['active_date' => $currentTime, 'status' => $ACTIVATED, 'expired_date' => $expired_date])) {
            return true;
        }
        return false;
    }


    public function clientAdmin()
    {
        return $this->belongsTo('App\Modules\Client\Models\ClientAdmin', 'admin_id');
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

}
