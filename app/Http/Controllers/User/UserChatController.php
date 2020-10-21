<?php

namespace App\Http\Controllers\User;

use App\Chat;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use App\User;
use Illuminate\Http\Request;

class UserChatController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Request $request)
    {
        if ($request->has('email')) {
            $admin = User::where('email', $request->email)->first();
            if ($user) {

                $chat = Chat::whereHas('users', function ($query) use ($user) {
                    return $query->where('users.id', $user->id);
                })->whereHas('users', function ($query) use ($admin) {
                    return $query->where('users.id', $admin->id);
                })->first();

                if ($chat) {

                    return $this->singleResponse(new ChatResource($chat));

                } else {
                    
                    $chat = new Chat;
                    $chat->name = $request->email;
                    $chat->saveOrFail();

                    $chat->users()->attach([$user, $admin]);

                    return $this->singleResponse(new ChatResource($chat));
                }
            } else {
                return $this->errorResponse("Correo invalido");
            }
        }
        return $this->collectionResponse(ChatResource::collection($this->getModel(new Chat, [], $user->chats())));
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
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
