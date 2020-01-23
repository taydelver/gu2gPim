<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Category;
use App\DataSync\ApiConnect;

use GuzzleHttp\Client;
// use GuzzleHttp\Exception\BadResponseException as Exception;
use GuzzleHttp\Exception\BadResponseException as Exception;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        try {
            $client = new Client;
            // MOVE TO ENV VARIABLE
            $url = 'http://laravelcms.test/oauth/token';
            $secret = 'rHuR7HTUVZPSCtFQivmDHLBABZBrpplTQdrUzhgG';
            $response = $client->request('POST', $url, [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => 2,
                    'client_secret' => $secret,
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);
            return $response->getBody();
        } catch(Exception $e) {
            if($e->getCode() === 400) {
                return response()->json('Invalid Request', $e->getCode());
            }
        } 
        // return json_decode($response->getBody(), true); // returns array
    }
    
    public function categories()
    {
        $categories = Category::all();
        $children = Category::where('parent_id', '!=', 0)->get();
        $top = Category::where('parent_id', 0)->get();

        foreach($categories as $cat) {
            if($cat->parent_id != '0') {

            }
        }
    }
    public function categoryTree()
    {
        $api = new ApiConnect;
        return json_encode($api->category_tree());
    }

    public function product( Request $request, $id )
    {
        $api = new ApiConnect;
        $product = $api->product($id);
        return $product;
    }

    public function bcCategories( Request $request )
    {
        $api = new ApiConnect;
        $categories = $api->categories('all');
        return $categories;
    }

    public function products( Request $request )
    {
        $page = $request->page ? $request->page : 1;
        $limit = $request->limit ? $request->limit : 20;
        $api = new ApiConnect;
        $products = $api->products($page, $limit);
        return $products;
    }

    public function productVariants(Request $request)
    {

    }
}
