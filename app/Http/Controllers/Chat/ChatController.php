<?php

namespace App\Http\Controllers\Chat;

use App\Chat;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\User;
use Illuminate\Http\Request;

class ChatController extends ApiController
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
    public function store(Request $request)
    {
        $chat = new Chat;
        $chat->fill($request->all());
        $chat->saveOrFail();

        if ($request->has('users')) {
            $users = User::whereIn('id', $request->users)->get();
            $chat->users()->attach($users);
        }

        return $this->api_success([
            'data'      =>  new ChatResource($chat),
            'message'   => __('pages.responses.created'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        return $this->singleResponse(new ChatResource($chat));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit(Chat $chat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chat $chat)
    {
        if ($request->has('name')) {
            $chat->name = $request->name;
        }
        if (!$chat->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $chat->saveOrFail();

        return $this->api_success([
            'data'      =>  new ChatResource($chat),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chat $chat)
    {
        $chat->delete();
        return $this->api_success([
            'data'      =>  new ChatResource($chat),
            'message'   => __('pages.responses.deleted'),
            'code'      =>  201
        ], 201);
    }
}
