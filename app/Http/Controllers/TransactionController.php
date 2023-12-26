<?php

namespace App\Http\Controllers;

use App\Models\TransactionIn;
use App\Models\TransactionOut;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $type, Request $request)
    {
        try {
            if ($type == 'in') {
                $Model = new TransactionIn();
            } else if ($type == 'out') {
                $Model = new TransactionOut;
            }
            $perPage = $request->input('per_page', 50); // Set a default value or configure as needed
            $page = $request->input('page', 1);

            $query = $Model::query();
            $results = $query->paginate($perPage, ['*'], 'page', $page);

            return response()->json($results);
        } catch (BindingResolutionException $e) {
            return 'invalid modeeel';
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return auth()->staff_id;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
