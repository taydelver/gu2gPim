<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\FitmentGroup;
use App\FitmentModel;
use App\Http\Resources\FitmentGroupResource;
use App\Http\Resources\FitmentModelResource;

class FitmentsController extends Controller
{
    public function getFitments(Request $request)
    {
        $pagination = $request->paginate;
        if( $pagination ) {
            $groups = FitmentGroup::paginate($pagination);
            return FitmentGroupResource::collection($groups);
        } else {
            $groups = FitmentGroup::all();
            return FitmentGroupResource::collection($groups);
        }
        
    }

    public function getFitmentsAll(Request $request)
    {
        $groups = FitmentGroup::all();
        return FitmentGroupResource::collection($groups);
    }

    public function getFitmentModels(Request $request)
    {
        $models = FitmentModel::all();
        return FitmentModelResource::collection($models);
    }

    public function createFitmentGroup(Request $request)
    {
        $group = new FitmentGroup;
        $group->name = $request->name;
        $group->save();

        foreach($request->values as $value) {
            $model = new FitmentModel;
            $model->value = $value;
            $model->fitment_group_id = $group->id;
            $model->save();
        }
    }

    public function updateFitmentGroup(Request $request)
    {
        $group = FitmentGroup::find($request->id);
        $group->name = $request->name;
        $group->fitment_models()->delete();
        $group->save();
        foreach($request->values as $value) {
            $model = new FitmentModel;
            $model->value = $value;
            $model->fitment_group_id = $request->id;
            $model->save();
        }

    }

    public function createFitmentModel(Request $request)
    {

    }
}
