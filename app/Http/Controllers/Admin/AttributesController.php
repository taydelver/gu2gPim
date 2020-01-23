<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\AttributeGroup;
use App\AttributeOption;
use App\Http\Resources\AttributeGroupResource;
// use App\Http\Resources\FitmentModelResource;

class AttributesController extends Controller
{
    public function all(Request $request)
    {
        $pagination = $request->paginate;
        $groups;
        if( $pagination ) {
            $groups = AttributeGroup::paginate($pagination);
        } else {
            $groups = AttributeGroup::all();
        }
        return AttributeGroupResource::collection($groups);
    }

    public function createGroup(Request $request)
    {
        $group = new AttributeGroup;
        $group->name = $request->name;
        $group->category = $request->category;
        $group->save();

        foreach($request->values as $value) {
            $option = new AttributeOption;
            $option->value = $value;
            $option->attribute_group_id = $group->id;
            $option->save();
        }
        return response()->json(['message' => 'Group added!']);
    }

    public function updateGroup(Request $request)
    {
        $group = AttributeGroup::find($request->id);
        $group->name = $request->name;
        $group->category = $request->category;
        $group->options()->delete();
        $group->save();
        foreach($request->values as $value) {
            $option = new AttributeOption;
            $option->value = $value;
            $option->attribute_group_id = $group->id;
            $option->save();
        }
        return response()->json(['message' => 'Group updated!']);


    }
}
