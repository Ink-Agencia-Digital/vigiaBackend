<?php

namespace App\Http\Controllers\Complex;

use App\Complex;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\UserResource;
use App\User;
use Illuminate\Http\Request;

class ComplexEmployeeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Complex $complex)
    {
        return $this->collectionResponse(UserResource::collection($this->getModel(new User, [], $complex->employees())));
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
