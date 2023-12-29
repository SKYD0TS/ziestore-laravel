<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * TODO: Fix try catch Model binding exception duplications
 */
class CrudController extends Controller
{
    protected $modelPath = "App\\Models\\";
    protected function getModel($model)
    {
        try {
            return app($this->modelPath . $model);
        } catch (BindingResolutionException $e) {
            return response()->json(['error' => 'Invalid model']);
        }
    }

    // /**
    //  * Get select options for select input
    //  * GET
    //  */
    // public function getSelectOptions(string $model)
    // {
    //     try {
    //         $Model = $this->getModel($model);
    //         return $Model->getSelectOptions();
    //     } catch (BindingResolutionException $e) {
    //         return response()->json(['error' => 'Invalid model']);
    //     }
    // }

    /**
     * Return input attributes of columns
     * GET
     */
    public function getInputAttributes(string $model)
    {
        try {
            $model = app("App\\Models\\$model");
            return response()->json(['inputs' => $model->getColumnsInputAttribute()]);
        } catch (BindingResolutionException $e) {
            return response()->json(['error' => 'Invalid model']);
        }
    }

    /**
     * Display a listing of the resource.
     * GET
     */
    public function index(string $model, Request $request)
    {
        try {
            $Model = $this->getModel($model);
            //Code v

            $perPage = $request->input('per_page', 50); // Set a default value or configure as needed
            $page = $request->input('page', 1);

            $query = $Model::query();
            $results = $query->paginate($perPage, ['*'], 'page', $page);
            return response()->json($results);
        } catch (BindingResolutionException $e) {
            return response()->json(['error' => 'invalid model']);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    // public function create()
    // {
    //     //
    // }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $model, Request $request)
    {
        try {
            $Model = $this->getModel($model);
            //Code v
            //get model rule
            $rule = $Model->getRules();
            //validate the request
            $validator = Validator::make($request->all(), $rule);

            if ($validator->fails()) {
                return $validator->errors();
            }

            $Model->create($validator->validated());
            return response()->json(['success' => 'Success']);
        } catch (BindingResolutionException $e) {
            return response()->json(['error' => 'invalid model']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $model, string $id)
    {
        try {
            $Model = $this->getModel($model);
            //Code v
            $item = $Model::findOr($id, function () use ($model) {
                return response()->json(['error' => ucfirst($model) . " Not found"]);
            });
            return $item;
        } catch (BindingResolutionException $e) {
            return response()->json(['error' => 'invalid model']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $model, Request $request, string $id)
    {
        try {
            $Model = $this->getModel($model);
            //Code v
            $item = $Model::find($id);
            if ($item == null) {
                return response()->json(['error' => 'Data not found'], 404);
            }
            $validator = Validator::make($request->all(), $Model->getRules($id));
            if ($validator->fails()) {
                return $validator->errors();
            }

            $validatedData = $validator->validated();
            $item->fill($validatedData);
            $item->save();

            return response()->json(['success' => 'Success']);
        } catch (BindingResolutionException $e) {
            return response()->json(['error' => 'invalid model']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $model, string $id)
    {
        try {
            $Model = $this->getModel($model);
            //Code v

            $item = $Model->find($id);
            if ($item == null) {
                return response()->json(['error' => 'Data not found'], 404);
            }
            $item->delete();
            return response()->json(['success' => 'Success']);
        } catch (BindingResolutionException $e) {
            return response()->json(['error' => 'invalid model']);
        }
    }
}
