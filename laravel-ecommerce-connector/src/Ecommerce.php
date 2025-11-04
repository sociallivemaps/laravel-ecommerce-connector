<?php

namespace Solimap\Ecommerce;

use Illuminate\Support\Facades\Http;

class Ecommerce
{
    protected string $baseUrl;
    protected string $clientId;
    protected string $eventId;

    public function __construct()
    {
        $this->baseUrl  = rtrim(config('solimap.base_url', 'https://pay2go.solimap.com/api/v1'), '/');
        $this->clientId = (string) config('solimap.client_id');
        $this->eventId  = (string) config('solimap.event_id');
    }

    protected function get(string $endpoint, array $params = [])
    {
        $response = Http::withHeaders([
            'Accept'      => 'application/json',
            'Content-Type' => 'application/json',
            'Client-Id'   => $this->clientId,
            'Event-Id'    => $this->eventId,
        ])->timeout(30)->get($this->baseUrl . $endpoint, $params);

        $response->throw(); // error to exception if not 2xx
        return $response->json();
    }
    public function bundleCategories()
    {
        return $this->get('/ecommerce/bundle-categories');
    }
    public function categories()
    {
        return $this->get('/ecommerce/categories');
    }

    public function bundles(array $cats = [])
    {
        return $this->get('/ecommerce/bundles',   ['category' => $cats]);
    }
    public function products(array $cats = [])
    {
        return $this->get('/ecommerce/products',  ['category' => $cats]);
    }
    public function passes(array $cats = [])
    {
        return $this->get('/ecommerce/passes',    ['category' => $cats]);
    }
    public function vendors(array $cats = [], $id = null)
    {
        return $this->get('/ecommerce/vendors' . ($id ? '/' . $id : ''),  ['category' => $cats]);
    }
}
