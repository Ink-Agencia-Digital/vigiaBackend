<?php

namespace App\Http\Controllers\User;

use App\Apartment;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;
use App\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;


class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->collectionResponse(UserResource::collection($this->getModel(new User, ['roles.permissions'])));
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
    public function store(StoreUserRequest $request)
    {
        $user = new User;
        $user->fill($request->all());

        if ($request->has('photo')) {
            $user->photo = $request->photo->store('photos');
        }
        $user->saveOrFail();


        if ($request->has('role')) {
            $role = Role::where('name', $request->role)->firstOrFail();
            $user->assignRole($role);
        }

        if ($request->has('apartment_id')) {
            $apartment = Apartment::findOrFail($request->apartment_id);
            $apartment->users()->attach($user);
            $user->load(['apartments']);
        }


        //  VerifyEmailController::sendEmail($user);

        return $this->api_success([
            'data' => new UserResource($user),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->singleResponse(new UserResource($user));
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
    public function update(UpdateUserRequest $request, User $user)
    {
        if ($request->has("name")) {
            $user->name = $request->name;
        }
        if ($request->has("lastname")) {
            $user->lastname = $request->lastname;
        }
        if ($request->has("phone")) {
            $user->phone = $request->phone;
        }
        if ($request->has("identification")) {
            $user->identification = $request->identification;
        }
        if ($request->has("email")) {
            $user->email = $request->email;
        }
        if ($request->has("ice")) {
            $user->ice = $request->ice;
        }
        if ($request->has("photo")) {
            Storage::delete($user->photo);
            $image = $request->photo;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10) . '.jpeg';
            Storage::disk('photos')->put($imageName, base64_decode($image));
            $user->photo =  $imageName;
        }

        if (!$user->isDirty()) {
            return $this->errorResponse(
                'Se debe especificar al menos un valor diferente para actualizar',
                422
            );
        }

        $user->saveOrFail();

        return $this->api_success([
            'data'      =>  new UserResource($user),
            'message'   => __('pages.responses.updated'),
            'code'      =>  201
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return $this->singleResponse(new UserResource($user), 200);
    }
}
