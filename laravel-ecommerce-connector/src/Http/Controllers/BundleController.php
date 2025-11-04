<?php

namespace Solimap\Ecommerce\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Solimap\Ecommerce\Ecommerce;

class BundleController extends Controller
{
    public function index(Request $request, Ecommerce $api)
    {
        $cats = (array) $request->input('category', []);
        $bundle = $api->bundles($cats);
        $vendor = $api->vendors();

        $categories = $api->bundleCategories();

        $vendors = $vendor['data'] ?? [];
        $bundles = $bundle['data'] ?? [];

        $price = [];
        foreach ($bundles as $bundle) {
            if (!empty($bundle['price'])) {
                $price[] = $bundle['price'];
            }
        }


        return view('solimap::bundles.index', compact('bundles', 'categories', 'vendors', 'price'));
    }

    public function search(Request $request, Ecommerce $api)
    {
        // dd($request->all());
        $query = $request->input('q', '');
        $cats = (array) $request->input('category', []);

        $bundle = $api->bundles($cats);
        $bundles = $bundle['data'] ?? [];

        // Filter bundles by search query
        if (!empty($query)) {
            $bundles = array_filter($bundles, function ($b) use ($query) {
                return stripos($b['name'], $query) !== false;
            });
        }

        // Take only necessary fields
        $bundles = array_values(array_map(function ($b) {
            return [
                'id' => $b['id'],
                'name' => $b['name'],
                'price' => $b['price'] ?? null,
            ];
        }, $bundles));

        return response()->json($bundles);
    }
}
