<?php

namespace App\Http\Controllers\Code;

use App\Code;
use App\Http\Controllers\Api\ApiController;
use Illuminate\Support\Str;
use App\Http\Resources\CodeResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CodeController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->has('code')) {
            $code = Code::where('code', request()->code)->firstOrfail();
            $code->delete();
            return $this->singleResponse(new CodeResource($code->load(["user", 'apartment.tower'])));
        } else {
            return $this->collectionResponse(CodeResource::collection($this->getModel(new Code, [])));
        }
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
        $code = new Code;
        $code->fill($request->all());

        if ($request->has('photo')) {
            $image = $request->photo;
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = Str::random(10) . '.jpeg';
            Storage::disk('images')->put($imageName, base64_decode($image));
            $code->photo =  $imageName;
        }

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        function generate_string($input, $strength = 16)
        {
            $input_length = strlen($input);
            $random_string = '';
            for ($i = 0; $i < $strength; $i++) {
                $random_character = $input[random_int(0, $input_length - 1)];
                $random_string .= $random_character;
            }
            return $random_string;
        }

        $code->code = generate_string($permitted_chars, 10);
        while (Code::where('code', $code->code)->first()) {
            $code->code = generate_string($permitted_chars, 10);
        }
        $code->saveOrFail();

        return $this->api_success([
            'data' => new CodeResource($code),
            'message' => __('pages.responses.created'),
            'code' => 201
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function show(Code $code)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function edit(Code $code)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Code $code)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Code  $code
     * @return \Illuminate\Http\Response
     */
    public function destroy(Code $code)
    {
        $code->delete();
        return $this->api_success([
            'data' => new CodeResource($code),
            'message' => __('pages.responses.deleted'),
            'code' => 201
        ], 201);
    }
}
