<?php

namespace App\Http\Controllers\Tower;

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTowerRequest;
use App\Http\Resources\TowerResource;
use App\Tower;
use Illuminate\Http\Request;

class TowerController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(TowerResource::collection($this->getModel(new Tower, [])));
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
    public function store(StoreTowerRequest $request)
    {
        $tower = new Tower;
        $tower->fill($request->all());
        $tower->saveOrFail();

        return $this->api_success([
            'data' => new TowerResource($tower),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function show(Tower $tower)
    {
        return $this->singleResponse(new TowerResource($tower));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function edit(Tower $tower)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tower $tower)
    {
        if ($request->has('name')) {
            $tower->name = $request->name;
        }
        if ($request->has('complex_id')) {
            $tower->complex_id = $request->complex_id;
        }

        if (!$tower->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $tower->saveOrFail();

        return $this->api_success([
            'data'      =>  new TowerResource($tower),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Tower  $tower
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tower $tower)
    {
        $tower->delete();
        return $this->singleResponse(new TowerResource($tower), 200);
    }
}
