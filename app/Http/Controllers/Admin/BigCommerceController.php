<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataSync\ApiConnect;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request as Req;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Exception\ClientException as Exception;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;

class BigCommerceController extends Controller
{
    public function init()
    {
        $base = config('services.bigcommerce.base_url');
        $client = new Client([
            'headers' => [
                'X-Auth-Client' => config('services.bigcommerce.client_id'),
                'X-Auth-Token' => config('services.bigcommerce.token'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
        ]);
        return $client;
        // return json_decode($response->getBody(), true); // returns array
    }

    public function createProduct(Request $request)
    {
        $base = config('services.bigcommerce.base_url');
        $client = $this->init();
        try {
            $response = $client->post($base . 'catalog/products', [
                'json' => $request->product
            ]);
            return $response->getBody();
        } catch(Exception $e) {
            // return json_decode($response->getResponse(), true);
            return $e->getResponse(); 
        }
        // return json_decode($response->getBody(), true); // returns array
    }

    public function createProductOptions(Request $request)
    {
        $base = config('services.bigcommerce.base_url');
        $client = $this->init();
        $variant = $request->option;
        $product_id = $request->product_id;

        $response = $client->post($base . 'catalog/products/' . $product_id . '/options', [
            'json' => $request->option
        ]);

        // return response()->json($variant);
        
        return $response->getBody();
    }

    public function createProductVariants(Request $request)
    {
        $base = config('services.bigcommerce.base_url');
        $client = $this->init();
        $product_id = $request->product_id;

        $response = $client->post($base . 'catalog/products/' . $product_id . '/variants', [
            'json' => $request->variant
        ]);
        // return response()->json($request->variant);
        
        return $response->getBody();
    }

    public function createProductCustomFields(Request $request)
    {
        $base = config('services.bigcommerce.base_url');
        $client = $this->init();
        $product_id = $request->product_id;

        $response = $client->post($base . 'catalog/products/' . $product_id . '/custom-fields', [
            'json' => $request->field
        ]);
        // return response()->json($request->variant);
        
        return $response->getBody();
    }

    public function saveProductImage(Request $request)
    {
        $base = config('services.bigcommerce.base_url');
        $client = $this->init();
        $product_id = $request->product_id;

        $response = $client->post($base . 'catalog/products/' . $product_id . '/images', [
            'json' => $request->image
        ]);
        // return response()->json($request->variant);
        
        return $response->getBody();
    }

    
}
