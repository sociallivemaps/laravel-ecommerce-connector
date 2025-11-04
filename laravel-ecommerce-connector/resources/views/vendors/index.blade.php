@extends('solimap::layouts.app')

@section('title', 'Ecommerce Products')

@section('content')
    <div class="container">
        <h4 class="mb-4">Vendor Details</h4>
        <!-- Breadcrumb -->
        <div class="row">
            <!-- Left Column -->
            <div class="col-lg-4 fixed-left">
                <!-- Profile Card -->
                <div class="profile-card">
                    <div class="d-flex justify-content-end mb-2">
                        <i class="far fa-heart" style="color: #ccc; font-size: 1.2rem;"></i>
                    </div>
                    <div class="profile-img">
                        @if (!empty($vendor['logo']))
                            <img src="{{ $vendor['logo'] }}" alt="{{ $vendor['name'] }}" style="background-color: #a0d9d8;">
                        @else
                            <img src="{{ asset('vendor/solimap/uploads/no_photo.png') }}" alt="{{ $vendor['name'] }}"
                                style="background-color: #a0d9d8;">
                        @endif
                    </div>
                    <h2 class="vendor-title">{{ $vendor['name'] }}</h2>
                    <div class="vendor-badge">
                        <i class="fas fa-crown me-1"></i>
                        Top Vendor
                    </div>

                    <div class="trust-badges">
                        <a href="#" class="trust-badge trusted-vendor">Trusted Vendor</a>
                        <a href="#" class="trust-badge trusted">Trusted</a>
                        <a href="#" class="trust-badge veterans">Veterans PRG</a>
                    </div>

                    {{-- <a href="#" class="trust-badge veterans d-block mb-3">Veterans services</a>
                    <a href="#" class="trust-badge veterans d-block mb-3">Vendor Riley</a> --}}

                    <p class="text-muted small mb-3">
                        Fran Riley is a trusted vendor known for delivering
                        top-quality services tailored to enhance event
                        experiences. Specializing in... <strong>Read More</strong>
                    </p>

                    <div class="action-buttons">
                        <a href="#" class="btn-action" style="background: #f1f5f9; color: #666;">
                            <i class="fas fa-envelope"></i> Email
                        </a>
                        <a href="#" class="btn-action" style="background: #f1f5f9; color: #666;">
                            <i class="fas fa-comment"></i> Chat
                        </a>
                        <a href="#" class="btn-action" style="background: #f1f5f9; color: #666;">
                            <i class="fas fa-share"></i> Share
                        </a>
                    </div>

                    <button class="btn btn-contact">Contact Vendor</button>

                    <div class="info-item">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span class="info-label">Location</span>
                        </div>
                        <span class="info-value">United States</span>
                    </div>
                    <div class="info-item">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-globe me-2"></i>
                            <span class="info-label">Language</span>
                        </div>
                        <span class="info-value">English</span>
                    </div>
                </div>
            </div>

            <!-- Middle Column -->
            <div class="col-lg-8 scrollable-right">
                @if (!empty($vendor['products']))
                    <div class="content-card">
                        <div class="card-header-custom d-flex justify-content-between">
                            <h3 class="card-title">Vendor Products</h3>
                            <a href="#" class="see-more-link">See More Products</a>
                        </div>
                        <div class="row g-3" id="venderList">
                            @foreach ($vendor['products'] as $product)
                                <div class="col-md-4">
                                    <div class="product-card bg-white rounded-3 shadow-sm h-100 position-relative">
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2 z-1">New</span>
                                        <div class="product-image-container overflow-hidden rounded-top-3">
                                            @if (!empty($product['image']))
                                                <img src="{{ $product['image'] }}" class="product-image w-100"
                                                    alt="{{ $product['name'] }}"
                                                    style="height: 120px; object-fit: contain; background:#f8f9fa;">
                                            @else
                                                <img src="{{ asset('vendor/solimap/uploads/no_photo.png') }}"
                                                    class="product-image w-100" alt="No Image Available"
                                                    style="height: 120px; object-fit: contain; background:#f8f9fa;">
                                            @endif
                                        </div>
                                        <div class="p-3">
                                            <h6 class="fw-bold mb-2">{{ $product['name'] }}</h6>
                                            <div class="d-flex align-items-center mb-2">
                                                <div class="me-2">
                                                    <i class="fas fa-star text-warning" style="font-size: 0.8rem;"></i>
                                                    <i class="fas fa-star text-warning" style="font-size: 0.8rem;"></i>
                                                    <i class="fas fa-star text-warning" style="font-size: 0.8rem;"></i>
                                                    <i class="fas fa-star text-warning" style="font-size: 0.8rem;"></i>
                                                    <i class="fas fa-star-half-alt text-warning"
                                                        style="font-size: 0.8rem;"></i>
                                                </div>
                                                <small class="text-muted">(4.5)</small>
                                            </div>
                                            <p class="text-muted mb-3" style="font-size: 0.85rem;">
                                                {{ $product['description'] }}
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="fw-bold text-primary">${{ $product['price'] }}</span>
                                                <button class="btn btn-sm text-white px-3 py-1 rounded-pill"
                                                    style="background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%); font-size: 0.8rem;">
                                                    Add to Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if (!empty($vendor['venue']))
                    <!-- Vendor Locations -->
                    <div class="content-card">
                        <div class="card-header-custom d-flex justify-content-between">
                            <h3 class="card-title">Vendor Locations</h3>
                        </div>
                        <div class="card-body p-0">
                            <!-- Google Map iframe -->
                            <iframe width="100%" height="350" style="border:0; border-radius: 8px;" loading="lazy"
                                allowfullscreen referrerpolicy="no-referrer-when-downgrade"
                                src="https://www.google.com/maps?q={{ $vendor['venue'][0]['latitude'] }},{{ $vendor['venue'][0]['longitude'] }}&hl=en&z=14&output=embed">
                            </iframe>
                        </div>
                    </div>
                @endif
                <!-- Services Offered -->
                <div class="content-card">
                    <div class="card-header-custom d-flex justify-content-between">
                        <h3 class="card-title">Vendor Services Offered</h3>
                        <a href="#" class="see-more-link">See More Offered</a>
                    </div>
                    <ul class="services-list">
                        <li class="service-item">
                            <div class="service-icon">
                                <i class="fas fa-calendar-alt" style="color: #6366f1;"></i>
                            </div>
                            <span>Event Planning & Coordination</span>
                        </li>
                        <li class="service-item">
                            <div class="service-icon">
                                <i class="fas fa-map-marker-alt" style="color: #10b981;"></i>
                            </div>
                            <span>Venue Sourcing & Setup</span>
                        </li>
                        <li class="service-item">
                            <div class="service-icon">
                                <i class="fas fa-volume-up" style="color: #f59e0b;"></i>
                            </div>
                            <span>Audio/Visual Support</span>
                        </li>
                        <li class="service-item">
                            <div class="service-icon">
                                <i class="fas fa-users" style="color: #ec4899;"></i>
                            </div>
                            <span>Entertainment & Guest Engagement</span>
                        </li>
                        <li class="service-item">
                            <div class="service-icon">
                                <i class="fas fa-cogs" style="color: #8b5cf6;"></i>
                            </div>
                            <span>On-site Management</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fafafa;
        }

        /* Breadcrumb */
        .breadcrumb-custom {
            background: transparent;
            padding: 1rem 0;
        }

        .breadcrumb-custom .breadcrumb-item+.breadcrumb-item::before {
            content: ">";
            color: #666;
        }

        /* Navigation Tabs */
        .nav-tabs-custom {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 2rem;
        }

        .nav-tabs-custom .nav-link {
            border: none;
            color: #666;
            font-weight: 500;
            padding: 1rem 1.5rem;
            border-bottom: 3px solid transparent;
        }

        .nav-tabs-custom .nav-link.active {
            color: #6366f1;
            border-bottom: 3px solid #6366f1;
            background: transparent;
        }

        .nav-tabs-custom .nav-link:hover {
            border-color: transparent;
            color: #6366f1;
        }

        /* Profile Section */
        .profile-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            margin-bottom: 2rem;
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin: 0 auto 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .profile-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-img .badge-overlay {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
            background: #333;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 0.7rem;
        }

        .vendor-title {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .vendor-badge {
            background: linear-gradient(45deg, #f59e0b, #d97706);
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            margin-bottom: 1rem;
        }

        .trust-badges {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .trust-badge {
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
            text-decoration: none;
        }

        .trust-badge.trusted-vendor {
            background: #8b5cf6;
            color: white;
        }

        .trust-badge.trusted {
            background: #10b981;
            color: white;
        }

        .trust-badge.veterans {
            background: #3b82f6;
            color: white;
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
        }

        .btn-action {
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-contact {
            background: linear-gradient(135deg, #8b5cf6 0%, #ec4899 100%);
            color: white;
            border: none;
            width: 100%;
            padding: 1rem;
            border-radius: 25px;
            font-weight: 600;
            margin-top: 1rem;
        }

        /* Content Cards */
        .content-card {
            background: white;
            border-radius: 15px;
            padding: 1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .card-header-custom {
            display: flex;
            justify-content: between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
            margin: 0;
        }

        .see-more-link {
            color: #6366f1;
            text-decoration: none;
            font-size: 0.9rem;
        }

        /* Media Gallery */
        .media-gallery {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            grid-template-rows: auto auto;
            gap: 0.5rem;
            height: 300px;
        }

        .media-main {
            grid-row: 1 / 3;
            border-radius: 10px;
            overflow: hidden;
        }

        .media-thumb {
            border-radius: 10px;
            overflow: hidden;
        }

        .media-gallery img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Services */
        .services-list {
            list-style: none;
            padding: 0;
        }

        .service-item {
            display: flex;
            align-items: center;
            padding: 0.8rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .service-item:last-child {
            border-bottom: none;
        }

        .service-icon {
            width: 40px;
            height: 40px;
            background: #f8fafc;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
        }

        /* Rating */
        .rating-display {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .rating-number {
            font-size: 3rem;
            font-weight: bold;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .rating-bars {
            margin: 1rem 0;
        }

        .rating-bar {
            display: flex;
            align-items: center;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .rating-bar-fill {
            flex: 1;
            height: 8px;
            background: #f1f5f9;
            border-radius: 4px;
            margin: 0 1rem;
            overflow: hidden;
        }

        .rating-bar-progress {
            height: 100%;
            background: #10b981;
            border-radius: 4px;
        }

        /* Companies Grid */
        .companies-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem;
        }

        .company-item {
            text-align: center;
            padding: 1rem;
            border-radius: 10px;
            background: #f8fafc;
        }

        .company-logo {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            margin: 0 auto 0.5rem;
            overflow: hidden;
        }

        .company-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .company-name {
            font-size: 0.9rem;
            font-weight: 500;
            color: #333;
        }

        /* Info Items */
        .info-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #666;
            font-size: 0.9rem;
        }

        .info-value {
            color: #333;
            font-weight: 500;
        }

        /* Fix left column */
        .fixed-left {
            position: sticky;
            top: 0;
            height: 100vh;
            /* full screen height */
            overflow: hidden;
            /* andar ka content scroll na ho */
        }

        /* Right column scroll kare */
        .scrollable-right {
            max-height: 100vh;
            overflow-y: auto;
            padding-right: 10px;
            /* scrollbar ke liye thoda gap */
        }
    </style>
@endsection
