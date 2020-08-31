<?php

namespace App\Http\Controllers\Complex;

use App\Complex;
use App\Http\Controllers\Controller;
use App\Http\Resources\TowerResource;
use App\Tower;
use Illuminate\Http\Request;

class ComplexTowerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Complex $complex)
    {
        $towers = $complex->buildings();
        return $this->collectionResponse(TowerResource::collection($this->getModel(new Tower, ['apartments'], $towers)));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Complex  $complex
     * @return \Illuminate\Http\Response
     */
    public function show(Complex $complex)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Complex  $complex
     * @return \Illuminate\Http\Response
     */
    public function destroy(Complex $complex)
    {
        //
    }
}
