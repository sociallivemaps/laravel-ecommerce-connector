<?php

namespace Solimap\Ecommerce\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Solimap\Ecommerce\Ecommerce;

class ProductController extends Controller
{
    public function index(Request $request, Ecommerce $api)
    {
        $cats = (array) $request->input('category', []);
        $product = $api->products($cats);
        $vendor = $api->vendors();
        $categories = $api->categories();

        $vendors = $vendor['data'] ?? [];
        $products = $product['data'] ?? [];
        $price = [];

        $colors = [];
        foreach ($products as $product) {
            if (!empty($product['color'])) {
                $colors[] = $product['color'];
            }
        }
        $colors = array_unique($colors);

        return view('solimap::products.index', compact('products', 'categories', 'vendors', 'colors', 'price'));
    }

    public function show_vendor($id, Ecommerce $api)
    {
        // $vendors = $api->vendors([], $id);
        // $vendor = $vendors['data'][0];
        // return view('solimap::vendors.index', compact('vendor'));
        $vendors = $api->vendors([], $id);
        $vendor = $vendors['data'][0] ?? null;

        if (!empty($vendor['products'])) {
            $vendor['products'] = array_slice($vendor['products'], 0, 6);
        }

        return view('solimap::vendors.index', compact('vendor'));
    }

    public function filter(Request $request, Ecommerce $api)
    {
        //dd($request->all());
        $categories = $request->input('categories', []);
        $colors = $request->input('colors', []);
        $vendors = $request->input('vendors', []);
        $price = $request->input('price', []);

        $bundle = $api->bundles($vendors);
        $main_bundles = $bundle['data'] ?? [];

        $product = $api->products($categories);
        $main_products = $product['data'] ?? [];

        $products = [];
        foreach ($main_products as $cat) {
            $match = false;

            if (!empty($categories) && in_array($cat['category']['id'], $categories)) {
                $match = true;
            }

            if (!empty($colors) && in_array($cat['color'], $colors)) {
                $match = true;
            }

            if (!empty($vendors) && !empty($cat['vendors'])) {
                foreach ($cat['vendors'] as $vendor) {
                    if (in_array($vendor['id'], $vendors)) {
                        $match = true;
                        break;
                    }
                }
            }

            if ($match && !isset($products[$cat['id']])) {
                $products[$cat['id']] = $cat;
            }
        }

        $products = array_values($products);

        $bundles = [];
        if (!empty($price)) {
            foreach ($main_bundles as $bundle) {
                if (isset($bundle['price']) && $bundle['price'] <= $price) {
                    $bundles[] = $bundle;
                }
            }
        }

        return response()->json(['products' => array_values($products), 'bundles' => array_values($bundles)]);
    }

    public function search(Request $request, Ecommerce $api)
    {
        // dd($request->all());
        $query = $request->input('q', '');
        $cats = (array) $request->input('category', []);

        $products = $api->products($cats);
        $products = $products['data'] ?? [];

        if (!empty($query)) {
            $products = array_filter($products, function ($p) use ($query) {
                return stripos($p['name'], $query) !== false;
            });
        }

        $products = array_values(array_map(function ($p) {
            return [
                'id' => $p['id'],
                'name' => $p['name'],
                'price' => $p['price'] ?? null,
                'image' => $p['image'] ?? null
            ];
        }, $products));

        return response()->json($products);
    }
}
