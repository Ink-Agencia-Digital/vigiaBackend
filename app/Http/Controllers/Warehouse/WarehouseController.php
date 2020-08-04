<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Http\Resources\WarehouseResource;
use App\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends ApiController
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
    public function store(StoreWarehouseRequest $request)
    {
        $warehouse = new Warehouse;
        $warehouse->fill($request->all());
        $warehouse->saveOrFail();

        return $this->api_success([
            'data' => new WarehouseResource($warehouse),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function show(Warehouse $warehouse)
    {
        return $this->singleResponse(new WarehouseResource($warehouse));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function edit(Warehouse $warehouse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
    {
        if ($request->has("apartment_id")) {
            $warehouse->apartment_id = $request->apartment_id;
        }
        if ($request->has("user_id")) {
            $warehouse->user_id = $request->user_id;
        }
        if ($request->has("item")) {
            $warehouse->item = $request->item;
        }

        if (!$warehouse->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $warehouse->saveOrFail();

        return $this->api_success([
            'data'      =>  new WarehouseResource($warehouse),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Warehouse  $warehouse
     * @return \Illuminate\Http\Response
     */
    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return $this->api_success([
            'data'      =>  new WarehouseResource($warehouse),
            'message'   => __('pages.responses.deleted'),
            'code'      =>  201
        ], 201);
    }
}
