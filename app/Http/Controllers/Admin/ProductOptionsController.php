<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\OptionGroup;
use App\OptionValue;
use App\OptionValueCategory;

use App\Http\Resources\OptionGroupResource;
use App\Http\Resources\OptionValueCategoryResource;
use App\Http\Resources\OptionValueResource;

class ProductOptionsController extends Controller
{
    public function createOptionGroup(Request $request)
    {
        $values = $request->values;
        $group = new OptionGroup;
        $group->display_name = $request->display_name;
        $group->name = $request->name;
        $group->type = $request->type;
        $group->save();

        foreach($values as $v) {
            if($request->type) {
                $colors = [];
                $colors[] = $v['color'];
                $value = OptionValue::firstOrCreate(['label' => $v['label'], 'value_data' => json_encode($colors)]);
                $group->values()->attach($value, ['sort_order' => $v['sort_order']]);
            } else {
                $value = OptionValue::firstOrCreate(['label' => $v['label']]);
                $group->values()->attach($value, ['sort_order' => $v['sort_order']]);
            }
        }

        return response()->json(['message' => 'Group created!']);

    }

    public function getOptionGroups(Request $request)
    {
        $pagination = $request->paginate;
        $groups;
        if( $pagination ) {
            $groups = OptionGroup::paginate($pagination);
        } else {
            $groups = OptionGroup::all();
        }
        return OptionGroupResource::collection($groups);
    }

    public function updateOptionGroup(Request $request)
    {
        $values = $request->values;
        $id = $request->group_id;
        $group = OptionGroup::find($id);
        $group->display_name = $request->display_name;
        $group->type = $request->type;
        $group->name = $request->name;
        $group->save();
        
        $updatedValues = [];
        foreach($values as $v) {
            $value = OptionValue::firstOrCreate(['label' => $v['label']]);
            $updatedValues[$value->id] = ['sort_order' => $v['sort_order']];
        }

        $group->values()->sync($updatedValues);
        return response()->json(['message' => 'Group updated!']);
        
    }

    public function getOptionValues(Request $request)
    {
        
        if ($request->filled('list_by')) {
            $listby = $request->list_by;
            if($listby && $listby == 'category') {
                $values = OptionValueCategory::all();
                return OptionValueCategoryResource::collection($values);
            }
        } else {
            $values = OptionValue::all();
            return OptionValueResource::collection($values);
        }
    }

    public function createOptionValues(Request $request)
    {
        $output = [];
        $values = $request->values;
        foreach($values as $v) {
            $value = new OptionValue;
            $value->label = $v; 
            $value->save();
            $output[] = $value;
        }
        return response()->json($output);
    }

    public function getOptionGroupValues(Request $request, OptionGroup $group)
    {
        $values = $group->values;
        return OptionValueResource::collection($values);
    }

}
