<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends CrudController
{
    protected $modelPath = "App\\Models\\User\\";

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $model, Request $request)
    {
        /**
         * ?this be register 
         */
        try {
            $Model = app("App\\Models\\$model");
            //Code v
            //get model rule
            $rule = $Model->getRules();
            $input = $request->all();

            switch ($model) {
                case $model == 'customer':
                    $idParam = $request->name;
                    break;
                case $model == 'staff':
                    $idParam = $request->role;
                    break;
                default:
                    $idParam = bin2hex(random_bytes(4));
            }
            $generatedId =  $Model->generateId($idParam);
            $input[$Model->getKeyName()] = $generatedId;
            $validator = Validator::make($input, $rule);
            if ($validator->fails()) {
                return [$validator->errors()];
            }

            if (isset($input['password'])) {
                $input['password'] = bcrypt($input['password']);
            }

            $Model->create($input);

            return response()->json(['success' => 'Success', 'redirect' => '/login']);
        } catch (BindingResolutionException $e) {
            return 'invalid model';
        }
    }

    /**
     * Display the specified resource.
     */

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $model, Request $request, string $id)
    {
        try {
            $Model = app("App\\Models\\$model");
            //Code v
            $item = $Model::find($id);
            if ($item == null) {
                return response()->json(['error' => 'Data not found'], 404);
            }


            $input = $request->all();

            if (isset($item->password) && !isset($input['password'])) {
                $input['password'] = $item->password;
            }

            $validator = Validator::make($input, $Model->getRules($id));
            if ($validator->fails()) {
                return $validator->errors();
            }

            $item->fill($input);
            $item->save();

            return response()->json(['success' => 'Success']);
        } catch (BindingResolutionException $e) {
            return response()->json(['error' => 'Invalid model'], 404);
        }
    }
}
