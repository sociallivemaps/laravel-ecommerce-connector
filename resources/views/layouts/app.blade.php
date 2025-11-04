<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .filter-sidebar {
            background: white;
            border-radius: 12px;
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .product-card {
            background: white;
            border-radius: 12px;
            transition: all 0.3s ease;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .product-image {
            height: 200px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }

        .price {
            color: #2563eb;
            font-weight: 600;
        }

        .discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #dc2626;
            color: white;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.875rem;
        }

        .wishlist-btn {
            position: absolute;
            top: 10px;
            left: 10px;
            background: white;
            border: none;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
        }

        .wishlist-btn:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        .rating-stars {
            color: #fbbf24;
        }

        .category-badge {
            background: #e5e7eb;
            color: #4b5563;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
        }

        .filter-group {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
        }

        .color-option {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            cursor: pointer;
            position: relative;
        }

        .color-option.selected::after {
            content: '';
            position: absolute;
            inset: -3px;
            border: 2px solid #2563eb;
            border-radius: 50%;
        }

        .sort-btn {
            background: white;
            border: 1px solid #e5e7eb;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s;
        }

        .sort-btn:hover {
            background: #f3f4f6;
        }

        .cart-btn {
            background: #2563eb;
            color: white;
            border: none;
            transition: all 0.2s;
        }

        .cart-btn:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .product-image {
            width: 100%;
            height: 250px;
            object-fit: contain;
            background: #f2f2f2;
        }
    </style>
</head>

<body>

    {{-- Navbar --}}
    {{-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <!-- Logo + Brand -->
            <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
                <img src="{{ asset('vendor/solimap/logo/logo.png') }}" alt="Logo" width="150" height="40"
                    class="me-2">
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu Items -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is(config('solimap.app.prefix', 'solimap') . '/bundles*') ? 'active' : '' }}"
                            href="{{ url(config('solimap.app.prefix', 'solimap') . '/bundles') }}">
                            Bundles
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is(config('solimap.app.prefix', 'solimap') . '/products*') ? 'active' : '' }}"
                            href="{{ url(config('solimap.app.prefix', 'solimap') . '/products') }}">
                            Products
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </nav> --}}


    {{-- Main Content --}}
    <main class="container py-4">
        @yield('content')
    </main>

    {{-- Bootstrap JS (bundle with Popper) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script>
        document.querySelectorAll('.dropdown-menu .dropdown-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault(); // page reload na ho
                const selectedText = this.getAttribute("data-value");
                document.getElementById("sortMenu").textContent = selectedText;
            });
        });
    </script>


    {{-- Extra JS --}}
    @stack('scripts')

</body>

</html>
