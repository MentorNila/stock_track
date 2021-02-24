<?php

namespace App\Http\Middleware;

use App\Modules\Client\Classes\ClientStatusCode;
use App\Modules\Client\Models\Client;
use Closure;

class VerifyClientStatus {

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    /*
$table->increments('id');
            $table->string('subdomain', 100)->unique();
            $table->string('name', 200);
            $table->string('active_key', 200)->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamp('active_date')->nullable();
            $table->timestamp('expired_date')->nullable();
            $table->unsignedInteger('admin_id')->nullable();
            $table->tinyInteger('plan_id')->default(1);
            $table->timestamps();
            $table->softDeletes();
    */
    public function handle($request, Closure $next)
    {
        $client = Client::getCurrentClient();
        if(is_null($client)) {
            $client = Client::where('subdomain', 'rln')->first();
            if(empty($client)) {
                $client = new Client();
                $client->subdomain = 'rln';
                $client->name = 'RLN US LLP';
                $client->status = 3;
                $client->save();
            }
        }
        if (empty($client)) {
            return abort(403);
        } else {
            if ($client->status !== ClientStatusCode::$ACTIVATED) {
                throw new \Exception("Client is not activated", 100);
            } else {
                if (!empty($client->expired_date) && $client->expired_date->isPast()) {
                    throw new \Exception("Client is expired", 101);
                } else {
                    Client::setCurrentClient($client);
                    return $next($request);
                }
            }
        }
    }
}
