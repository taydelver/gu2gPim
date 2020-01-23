<?php

namespace App\DataSync;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException as Exception;

class ApiConnect {

    public function connect( $endpoint )
    {
         
        try {
            $client = new Client;
            $base = config('services.bigcommerce.base_url');
            $response = $client->request('GET', $base . $endpoint, [
                'headers' => [
                    'X-Auth-Client' => config('services.bigcommerce.client_id'),
                    'X-Auth-Token' => config('services.bigcommerce.token'),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ]
            ]);
                return json_decode($response->getBody(), true); // returns array
            }
            catch(Exception $e) {
                // return json_decode($response->getResponse(), true);
                // return $e->getResponse(); // returns array
                return response()->json($e->getResponse());
            }
    }

    // public function create( $endpoint, $body )
    // {
    //     $client = new Client;
    //     $base = config('services.bigcommerce.base_url');
    //     $response = $client->request('POST', $base . $endpoint, [
    //         'headers' => [
    //             'X-Auth-Client' => config('services.bigcommerce.client_id'),
    //             'X-Auth-Token' => config('services.bigcommerce.token'),
    //             'Accept' => 'application/json',
    //             'Content-Type' => 'application/json'
    //         ],
    //         ['form_params' => $body]
    //     ]);
    //     return $response->getBody();
    //     // return json_decode($response->getBody(), true); // returns array
    // }

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

    public function create( $endpoint, $body )
    {
        try {
                $base = config('services.bigcommerce.base_url');
                $client = new Client([
                    'headers' => [
                        'X-Auth-Client' => config('services.bigcommerce.client_id'),
                        'X-Auth-Token' => config('services.bigcommerce.token'),
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json'
                    ],
                ]);
                $response = $client->post($base . $endpoint, [
                    'json' => $body
                ]);
                return $response->getBody();
            }
            catch(Exception $e) {
                // return json_decode($response->getResponse(), true);
                return response()->json($e->getResponse());
            }
        // return json_decode($response->getBody(), true); // returns array
    }

    public function products( $page = 1, $limit = 20 )
    {
    
        $query = '?include=custom_fields,variants,primary_image&limit=' . $limit . '&page=' . $page;
        $data = $this->connect('catalog/products' . $query );
        return $data;
    }

    public function product_categories() {

    }

    public function categories( $page = 1 )
    {
        $data = $page == 'all' ? $this->connect('catalog/categories' ) : $this->connect('catalog/categories?page=' . $page );
        return $data['data'];
    }

    public function brands( $page = 1 )
    {
        $data = $this->connect('catalog/brands?page=' . $page );
        return $data;
    }

    public function category_tree()
    {
        $data = $this->connect('catalog/categories/tree');
        return $data;
    }

    public function product( $id )
    {
        $query = '?include=custom_fields,variants,primary_image';
        $product = $this->connect('catalog/products/' . $id . $query);
        return $product;
    }
}

