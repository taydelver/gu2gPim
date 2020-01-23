<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use App\DataSync\ApiSync;
use App\DataSync\ApiConnect;

use App\Category;
use App\Product;

class SyncController extends Controller
{
    public function getProducts(Request $request)
    {
        $client = new Client;
        $base = config('services.bigcommerce.base_url');
        $response = $client->request('GET', $base . 'catalog/products', [
            'headers' => [
                'X-Auth-Client' => config('services.bigcommerce.client_id'),
                'X-Auth-Token' => config('services.bigcommerce.token'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
        return json_decode($response->getBody(), true); // returns array
    }

    public function getCategories(Request $request)
    {
        $client = new Client;
        $base = config('services.bigcommerce.base_url');
        $response = $client->request('GET', $base . 'catalog/categories?limit=4000', [
            'headers' => [
                'X-Auth-Client' => config('services.bigcommerce.client_id'),
                'X-Auth-Token' => config('services.bigcommerce.token'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]
        ]);
        return json_decode($response->getBody(), true); // returns array
    }

    public function syncCategories()
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
        $categories = $res['data'];

        foreach( $categories as $category ) {
            Category::updateOrCreate(
                ['bc_id' => $category['id']],
                ['title' => $category['name'], 'parent_id' => $category['parent_id']]
            );
        }
 
    }

    public function runSync()
    {
        $sync = new ApiSync;
        // $sync->products();
        return $sync->categories();
    }

    public function test()
    {
        $sync = new ApiSync;
        // $fields = $sync->custom_fields();
        // $data = [];
        // foreach( $fields as $field ) {
            
        // }
        // return $fields;

        return $sync->categories();
    }

    public function apiSync(Request $request)
    {
        

        foreach( $categories as $category ) {
            Category::updateOrCreate(
                ['bc_id' => $category['id']],
                ['title' => $category['name'], 'parent_id' => $category['parent_id']]
            );
        }
        foreach( $products as $product ) {
            $p = Product::updateOrCreate(
                ['bc_id' => $product['id']],
                ['title' => $product['name']]
            );
            $test[] = $p;
            foreach($product['categories'] as $cat) {
                $c = Category::where('bc_id', $cat);
                $c->products()->attach($p->id);
                $p->save();
            }
        }
    

    }

    public function apiProducts()
    {
        $connect = new ApiConnect;
        $products = json_encode($connect->products()['data']);
        return $products;
    }
}
