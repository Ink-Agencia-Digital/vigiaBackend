<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Resources\VehicleResource;
use App\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(StoreVehicleRequest $request)
    {
        $vehicle = new Vehicle;
        $vehicle->fill($request->all());
        $vehicle->saveOrFail();

        return $this->api_success([
            'data'      =>  new VehicleResource($vehicle),
            'message'   => __('pages.responses.created'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        return $this->singleResponse(new VehicleResource($vehicle));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        if ($request->has("apartment_id")) {
            $vehicle->apartment_id = $request->apartment_id;
        }
        if ($request->has("brand")) {
            $vehicle->brand = $request->brand;
        }
        if ($request->has("year")) {
            $vehicle->year = $request->year;
        }
        if ($request->has("color")) {
            $vehicle->color = $request->color;
        }

        if (!$vehicle->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $vehicle->saveOrFail();

        return $this->api_success([
            'data'      =>  new VehicleResource($vehicle),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return $this->api_success([
            'data'      =>  new VehicleResource($vehicle),
            'message'   => __('pages.responses.deleted'),
            'code'      =>  201
        ], 201);
    }
}
