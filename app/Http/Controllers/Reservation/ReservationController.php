<?php

namespace App\Http\Controllers\Reservation;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Reservation;
use Illuminate\Http\Request;

class ReservationController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->has('date')) {
            $reservations = Reservation::whereDate('start', $request->date)->orWhereDate('end', $request->date);
        } else {
            $reservations = new Reservation;
        }
        return $this->collectionResponse(ReservationResource::collection($this->getModel(new Reservation, [], $reservations)));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reservation = new Reservation;
        $reservation->fill($request->all());
        $reservation->saveOrFail();
        return $this->api_success([
            'data' => new ReservationResource($reservation),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reservation $reservation)
    {
        if ($reservation->has("user_id")) {
            $reservation->user_id = $reservation->user_id;
        }
        if ($reservation->has("location_id")) {
            $reservation->location_id = $reservation->location_id;
        }
        if ($reservation->has("event")) {
            $reservation->event = $reservation->event;
        }
        if ($reservation->has("start")) {
            $reservation->start = $reservation->start;
        }
        if ($reservation->has("end")) {
            $reservation->end = $reservation->end;
        }
        if ($reservation->has("aproved")) {
            $reservation->aproved = $reservation->aproved;
        }
        
        if (!$reservation->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $reservation->saveOrFail();

        return $this->api_success([
            'data'      =>  new ReservationResource($reservation),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return $this->api_success([
            'data' => new ReservationResource($reservation),
            'message' => __('pages.responses.deleted'),
            'code' => 201
        ], 201);
    }
}
