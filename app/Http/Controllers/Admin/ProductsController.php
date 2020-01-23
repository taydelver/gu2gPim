<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    public function saveProductImage(Request $request)
    {
      // $image = $request->file;
      // $path = $image->store('products');
      // return response()->json(['path' => $path]);
      $image = $request->image;
      $path = $image->store('products');
      return response()->json(['path' => $path]);

      // $paths = [];
      // $images = $request->files;
      // foreach($images as $image) {
      //   $path = $image->store('products');
      //   $paths[] = $path;
      // }
      // return $paths;
    }

    public function test()
    {
      $array1 = ['small','large'];
      $array2 = ['red', 'green', 'blue'];
      $array3 = ['gloss', 'matte'];

      $arr = [$array1, $array2, $array3];




    }
}
