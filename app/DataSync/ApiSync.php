<?php

namespace App\DataSync;

use App\DataSync\ApiConnect;

use App\Category;
use App\Product;
use App\CustomField;
use App\Brand;

use Illuminate\Support\Facades\DB;

class ApiSync {

    public function products()
    {
        $init = new ApiConnect;
        $data = $init->products();
        $totalPages = $data['meta']['pagination']['total_pages'];
        $pages = range(1, $totalPages);
        
        foreach( $pages as $page ) {
            $connect = new ApiConnect;
            $products = $connect->products($page);
            foreach( $products['data'] as $product ) {
                Product::updateOrCreate(
                    ['bc_id' => $product['id']],
                    [
                        'title' => $product['name'],
                        'availability' => $product['availability'],
                        'brand_id' => $product['brand_id'],
                        'calculated_price' => $product['calculated_price'],
                        'is_featured' => $product['is_featured'],
                        'is_visible' => $product['is_visible'],
                        'inventory_level' => $product['inventory_level'],
                        'sku' => $product['sku'],
                        'base_variant_id' => $product['base_variant_id'],
                    ]
                );
            }
        }
        
    }

    public function product_categories() {
        
    }

    public function categories()
    {
        $connect = new ApiConnect;
        $categories = $connect->categories();
        foreach( $categories as $category ) {
            Category::updateOrCreate(
                ['bc_id' => $category['id']],
                [
                    'title' => $category['name'], 
                    'parent_id' => $category['parent_id'],
                    'description' => $category['description']
                ]
            );
        }

        // $deleted = Category::onlyTrashed()->get();
        // Category::destroy($toDelete);
        return response()->json(['success' => 'Categories updated successfully'], 200);
    }

    public function brands()
    {
        $init = new ApiConnect;
        $data = $init->brands();
        $totalPages = $data['meta']['pagination']['total_pages'];
        $pages = range(1, $totalPages);
        
        foreach( $pages as $page ) {
            $connect = new ApiConnect;
            $brands = $connect->brands($page);
            foreach( $brands['data'] as $category ) {
                Category::updateOrCreate(
                    ['bc_id' => $category['id']],
                    ['title' => $category['name']]
                );
            }
        }
    }

    public function custom_fields()
    {
        $init = new ApiConnect;
        $data = $init->products();
        $totalPages = $data['meta']['pagination']['total_pages'];
        $pages = range(1, $totalPages);
        $custom_fields = [];
        
        foreach( $pages as $page ) {
            $connect = new ApiConnect;
            $products = $connect->products($page);
       
            foreach( $products['data'] as $product ) {
                $fields = $custom_fields;
                $custom_fields = array_merge($fields, $product['custom_fields']);
            }
      
        }
        return $custom_fields;
    }
}