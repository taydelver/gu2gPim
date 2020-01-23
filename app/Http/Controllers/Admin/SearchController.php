<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataSync\ApiConnect;
use GuzzleHttp\Client;

class SearchController extends Controller
{
    public function init()
    {
        $client = new Client([
            'headers' => [
                'X-Auth-Client' => config('services.bigcommerce.client_id'),
                'X-Auth-Token' => config('services.bigcommerce.token'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ],
        ]);
        return $client;
    }

    public function productName(Request $request)
    {
        $client = $this->init();
        $query = $request->name;
        $url = config('services.bigcommerce.base_url') . 'catalog/products?name=' . $query;
        $response = $client->get($url);
        return json_decode($response->getBody(), true);
    }
}
