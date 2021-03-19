<?php

namespace App\Modules\Reservation\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Reservation\Models\Reservation;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function index(Request $request)
    {
        $reservations = Reservation::get();
        $activeCompany = $request->session()->get('activeCompany');
        if(isset($activeCompany->id)) {
            $reservations = Reservation::where('company_id', $activeCompany->id)->get();
        }
        return view('Reservation::index', compact('reservations'))->with(['reservations' => $reservations]);
    }

    public function store(Request $request) {
        $reservationData = $request->all();
        $activeCompany = $request->session()->get('activeCompany');
        $reservationData['company_id'] = $activeCompany->id;
        Reservation::create($reservationData);
        return redirect()->route('admin.reservations.index');
    }

    public function delete($reservationId) {
        Reservation::destroy($reservationId);
        return redirect()->route('admin.reservations.index');
    }

    public function edit($reservationId)
    {
        $reservation = Reservation::find($reservationId);
        return view('Reservation::edit', compact('reservation'));
    }
    
    public function update(Request $request, $shareholderId)
    {
        $reservation = Reservation::find($shareholderId);
        $reservation->update($request->all());
        
        return redirect()->route('admin.reservations.index');
    }
}
