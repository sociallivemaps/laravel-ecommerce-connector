@extends('solimap::layouts.app')

@section('title', 'Ecommerce Bundles')

@section('content')
    <div class="container">
        <!-- Top Bar -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Bundles Collection</h4>
            <div class="d-flex gap-3 align-items-center">
                <!-- Search box -->
                <div class="input-group" style="max-width: 250px; position: relative;">
                    <input type="text" id="bundleSearch" class="form-control" placeholder="Search Bundles...">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="bi bi-search"></i>
                    </button>

                    <!-- Loader -->
                    <div id="searchLoader"
                        style="display: none; position: absolute; right: 10px; top: 50%; transform: translateY(-50%);">
                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <!-- Dropdown results -->
                    <div id="searchResults" class="list-group position-absolute w-100"
                        style="z-index: 1000; top: 100%; left: 0; display: none;"></div>
                </div>

                <!-- Sort by Vendor -->
                <div class="d-flex align-items-center">
                    <span class="text-muted me-2 text-nowrap">Sort by:</span>
                    <div class="dropdown">
                        <button class="sort-btn dropdown-toggle d-flex align-items-center" type="button" id="sortMenu"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Newest
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="sortMenu">
                            <li><a class="dropdown-item" href="#" data-value="Newest">Newest</a></li>
                            <li><a class="dropdown-item" href="#" data-value="Oldest">Oldest</a></li>
                            <li><a class="dropdown-item" href="#" data-value="Vendor">Vendor</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <!-- Filters Sidebar -->
            @include('solimap::filter.index', [
                'categories' => $categories,
                'vendors' => $vendors,
                'price' => $price,
            ])
            <!-- Product Grid -->
            <div class="col-lg-9">
                <div class="row g-4" id="bundleList">
                    <!-- Product Card 1 -->
                    @foreach ($bundles as $bundle)
                        <div class="col-md-4">
                            <div class="product-card shadow-sm">
                                <style>
                                    .product-image {
                                        width: 100%;
                                        height: 250px;
                                        object-fit: contain;
                                        background: #f2f2f2;
                                    }
                                </style>
                                <div class="position-relative">
                                    @if (!empty($bundle['image']))
                                        <img src="{{ $bundle['image'] }}" class="product-image" alt="{{ $bundle['name'] }}">
                                    @else
                                        <img src="{{ asset('vendor/solimap/uploads/no_photo.png') }}" class="product-image"
                                            alt="No Image Available">
                                    @endif

                                    <span class="discount-badge">-20%</span>
                                    <button class="wishlist-btn">
                                        <i class="bi bi-heart"></i>
                                    </button>
                                </div>

                                <div class="p-3">
                                    {{-- <span
                                        class="category-badge mb-2 d-inline-block">{{ $bundle['category']['name'] }}</span> --}}
                                    <h6 class="mb-1">{{ $bundle['name'] }}</h6>
                                    <p class="card-text">{{ $bundle['description'] }}</p>
                                    <div class="rating-stars mb-2">
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-fill"></i>
                                        <i class="bi bi-star-half"></i>
                                        <span class="text-muted ms-2">(4.5)</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mt-2">Price : {{ '$' . $bundle['price'] }}</h6>
                                            {{-- <ul class="mb-0">
                                                 @foreach ($bundle['currencies'] as $currency)
                                                    <li>{{ $currency['pivot']['count'] }} × {{ $currency['name'] }}</li>
                                                @endforeach
                                            </ul> --}}
                                        </div>

                                        <div>
                                            <a href="{{ config('app.bundle_url') . '/products/' . $bundle['id'] }}"
                                                target="_blank"> <button class="btn cart-btn mx-2">
                                                    <i class="bi bi-cart-plus"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('bundleSearch');
            const resultsDiv = document.getElementById('searchResults');
            const loader = document.getElementById('searchLoader');

            if (!searchInput) return;

            let timeout = null;

            searchInput.addEventListener('input', function() {
                clearTimeout(timeout);
                const query = this.value.trim();

                timeout = setTimeout(() => {
                    if (query.length > 0) {
                        resultsDiv.style.display = 'none';
                        resultsDiv.innerHTML = '';
                        loader.style.display = 'inline-block'; // show loader
                        fetchBundles(query);
                    } else {
                        loader.style.display = 'none'; // hide loader
                        resultsDiv.style.display = 'none';
                        resultsDiv.innerHTML = '';
                    }
                }, 300);
            });

            function fetchBundles(query) {
                fetch("{{ url(config('solimap.app.prefix', 'solimap') . '/bundles/search') }}?q=" + encodeURIComponent(
                        query), {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        loader.style.display = 'none'; // hide loader
                        displayResults(data);
                    })
                    .catch(err => {
                        console.error(err);
                        loader.style.display = 'none';
                    });
            }

            function displayResults(data) {
                if (!data.length) {
                    resultsDiv.innerHTML = '<div class="list-group-item">No bundles found</div>';
                    resultsDiv.style.display = 'block';
                    return;
                }

                //     resultsDiv.innerHTML = data.map(b => `
            // <a href="{{ config('app.bundle_url') }}/products/${b.id}" class="list-group-item list-group-item-action">
            //     ${b.name} - ${b.price ? '$'+b.price : 'N/A'}
            // </a>
            resultsDiv.innerHTML = data.map(b => `
                        <a href="#" class="list-group-item list-group-item-action">
                            ${b.name} - ${b.price ? '$'+b.price : 'N/A'}
                        </a>
                    `).join('');
                resultsDiv.style.display = 'block';
            }

            // hide dropdown on outside click
            document.addEventListener('click', function(e) {
                if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
                    resultsDiv.style.display = 'none';
                }
            });
        });
    </script>
@endpush
