<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use App\DataSync\ApiConnect;

use App\Brand;
use App\Product;
use App\Category;
use App\CustomField;
use App\OptionGroup;
use App\FitmentGroup;


use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.dashboard');
    }

    public function syncData()
    {
        $client = new Client;
        $base = config('services.bigcommerce.base_url');
        $response = $client->request('GET', $base . 'catalog/categories', [
            'headers' => [
                'X-Auth-Client' => config('services.bigcommerce.client_id'),
                'X-Auth-Token' => config('services.bigcommerce.token'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
        // return json_decode($response->getBody(), true); // returns array
        $res = json_decode($response->getBody(), true);
        $data = json_encode($res['data']);
        return view('admin.syncdata')->with('products', $data);
    }

    public function products()
    {
        $connect = new ApiConnect;
        $products = json_encode($connect->products()['data']);
        return view('admin.products')->with('products', $products);
    }

    public function productsAdd()
    {
        return view('admin.products.add');
    }

    public function productOptions()
    {
        $group = OptionGroup::find(1);
        return view('admin.product-options.index')->with('group', $group);
    }

    public function brands()
    {
        $brands = Brand::all();
        return view('admin.brands')->with('brands', $brands);
    }

    public function categories()
    {
        $categories = Category::all();
        return view('admin.categories')->with('categories', $categories);
    }

    public function fitments()
    {
        return view('admin.fitment.index');
    }

    public function attributes()
    {
        return view('admin.attributes.index');
    }
    
}
