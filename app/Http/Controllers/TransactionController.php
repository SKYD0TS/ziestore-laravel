<?php

namespace App\Http\Controllers;

use App\Models\TransactionIn;
use App\Models\TransactionOut;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * !!ALERT!!ALERT!!ALERT!!ALERT
     * !inherited functions might not work
     * !!ALERT!!ALERT!!ALERT!!ALERT
     */
    protected function getModel(string $model, string $type)
    {
        try {
            $modelPath = '';
            switch ($model . $type) {
                case 'transactionin':
                    $modelPath = 'App\Models\Transaction\TransactionIn';
                case 'transactionout':
                    $modelPath = 'App\Models\Transaction\TransactionOut';
                case 'detailin':
                    $modelPath = 'App\Models\Transaction\TransactionDetailIn';
                case 'detailout':
                    $modelPath = 'App\Models\Transaction\TransactionDetailOut';
            }

            $Model = app($modelPath);
            return $Model;
        } catch (BindingResolutionException $e) {
            return response()->json(['error' => 'Invalid model']);
        }
    }

    /**
     * 
     * GET 
     */
    public function index(string $model, string $type, Request $request)
    {
        try {
            $Model = $this->getModel($type, $model);
            //Code v
            $perPage = $request->input('per_page', 50);
            $page = $request->input('page', 1);
            $query = $Model::query();

            $results = $query->paginate($perPage, ['*'], 'page', $page);
            return response()->json(['data' => $results, 'model' => $model]);
        } catch (BindingResolutionException $e) {
            return response()->json(['error' => 'Invalid model'], 404);
        }
    }

    /**
     * Display a listing of the resource.
     */
    protected function updateTransactionTotal($transactionId, $type = 'out', $transactionModel)
    {
        $Model = $this->getModel($transactionModel, $type);
        $transaction = $Model::find($transactionId);
        $transaction->total = $transaction->details->sum('subtotal');
        $transaction->save();
        DB::commit();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $model, string $type, Request $request)
    {
        DB::beginTransaction();
        try {
            $transactionModel = $this->getModel($model, $type);
            $rules = $transactionModel->getRules();

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                DB::rollBack();
                return $validator->errors();
            }
            $input = $validator->validated();

            switch ($type) {
                case 'in':
                    $input['transaction_code'] = $transactionModel->generateId();
                    $input['total'] = $transactionModel->details()->sum('subtotal');
                    $returnData['code'] = $input['transaction_code'];
                    break;
                case 'out':
                    // Handle 'out' case if needed
                    break;
            }

            $transactionModel->create($input);
            DB::commit();

            $returnData['success'] = 'Success';
            return response()->json($returnData);
        } catch (BindingResolutionException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Invalid model']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $model, string $type, Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            $transactionModel = $this->getModel($model, $type);
            // Code v
            $rules = $transactionModel->getRules($id);
            $item = $transactionModel::find($id);

            if ($item == null) {
                return response()->json(['error' => 'Data not found'], 404);
            }

            switch ($type) {
                case 'in':
                    $input['total'] = $transactionModel->details()->sum('subtotal');
                    break;
                case 'out':
                    // Handle 'out' case if needed
                    break;
            }

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return $validator->errors();
            }
            $input = $validator->validated();

            $item->fill($input);
            $item->save();
            DB::commit();

            return response()->json(['success' => 'Success']);
        } catch (BindingResolutionException $e) {
            DB::rollBack();
            return response()->json(['error' => 'Invalid model'], 404);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $model, string $type, string $id)
    {
        try {
            $Model = $this->getModel($model, $type);
            //Code v
            $item = $Model->find($id);
            if ($item == null) {
                return response()->json(['error' => 'Data not found'], 404);
            }
            $item->delete();
            return response()->json(['success' => 'Success']);
        } catch (BindingResolutionException $e) {
            return response()->json(['error' => 'Invalid model'], 404);
        }
    }
}
