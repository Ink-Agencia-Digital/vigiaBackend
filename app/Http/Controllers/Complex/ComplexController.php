<?php

namespace App\Http\Controllers\Complex;

use App\Complex;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComplexRequest;
use App\Http\Resources\ComplexResource;
use Illuminate\Http\Request;

class ComplexController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(ComplexResource::collection($this->getModel(new Complex, [])));
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
    public function store(StoreComplexRequest $request)
    {
        $complex = new Complex;
        $complex->fill($request->all());
        $complex->saveOrFail();

        return $this->api_success([
            'data' => new ComplexResource($complex),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Complex  $complex
     * @return \Illuminate\Http\Response
     */
    public function show(Complex $complex)
    {
        return $this->singleResponse(new ComplexResource($complex));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Complex  $complex
     * @return \Illuminate\Http\Response
     */
    public function edit(Complex $complex)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Complex  $complex
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Complex $complex)
    {
        if ($request->has("name")) {
            $complex->name = $request->name;
        }
        if ($request->has("address")) {
            $complex->address = $request->address;
        }
        if ($request->has("lat")) {
            $complex->lat = $request->lat;
        }
        if ($request->has("lng")) {
            $complex->lng = $request->lng;
        }
        if ($request->has("geofence")) {
            $complex->geofence = $request->geofence;
        }

        if (!$complex->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $complex->saveOrFail();

        return $this->api_success([
            'data'      =>  new ComplexResource($complex),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Complex  $complex
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complex $complex)
    {
        $complex->delete();
        return $this->singleResponse(new ComplexResource($complex), 200);
    }
}
