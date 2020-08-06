<?php

namespace App\Http\Controllers\Location;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLocationRequest;
use App\Http\Requests\UpdateLocationRequest;
use App\Http\Resources\LocationResource;
use App\Location;
use Illuminate\Http\Request;

class LocationController extends ApiController
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
    public function store(StoreLocationRequest $request)
    {
        $location = new Location;
        $location->fill($request->all());
        $location->saveOrFail();

        return $this->api_success([
            'data' => new LocationResource($location),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return $this->singleResponse(new LocationResource($location));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLocationRequest $request, Location $location)
    {
        if ($request->has("complex_id")) {
            $location->complex_id = $request->complex_id;
        }
        if ($request->has("name")) {
            $location->name = $request->name;
        }
        if ($request->has("opening")) {
            $location->opening = $request->opening;
        }
        if ($request->has("closing")) {
            $location->closing = $request->closing;
        }
        if (!$location->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        return $this->api_success([
            'data' => new LocationResource($location),
            'message' => __('pages.responses.updated'),
            'code' => 201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location->delete();
        return $this->api_success([
            'data' => new LocationResource($location),
            'message' => __('pages.responses.deleted'),
            'code' => 201
        ], 201);
    }
}
