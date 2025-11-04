<style>
    .color-option.selected {
        border: 3px solid #000;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.4);
    }
</style>

</style>
<div class="col-lg-3">
    <div class="filter-sidebar p-4 shadow-sm">
        @if (!empty($categories))
            <div class="filter-group">
                <h6 class="mb-3">Categories</h6>
                @foreach ($categories as $category)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="checkbox" id="{{ $category['id'] }}"
                            value="{{ $category['name'] }}">
                        <label class="form-check-label" for="{{ $category['id'] }}">
                            {{ $category['name'] }}
                        </label>
                    </div>
                @endforeach
            </div>
        @endif
        @if (!empty($vendors))
            <div class="filter-group">
                <h6 class="mb-3">Vendors</h6>
                @foreach ($vendors as $vendor)
                    <div class="form-check mb-2 d-flex align-items-center justify-content-between">
                        <div>
                            <input class="form-check-input" type="checkbox" name="vendor_id[]"
                                id="vendor_{{ $vendor['id'] }}" value="{{ $vendor['id'] }}">
                            <label class="form-check-label" for="vendor_{{ $vendor['id'] }}">
                                {{ $vendor['name'] }}
                            </label>
                        </div>
                        <a href="{{ url(config('solimap.app.prefix', 'solimap') . '/vendor/' . $vendor['id']) }}"
                            class="btn btn-primary btn-sm px-2 py-1" style="font-size: 0.7rem;">
                            View
                        </a>
                    </div>
                @endforeach
            </div>
        @endif

        @if (!empty($price))
            <div class="filter-group">
                <h6 class="mb-3">Price Range</h6>
                <input type="range" class="form-range" id="price_range" min="0" max="1000" value="1000"
                    step="10">
                <div class="d-flex justify-content-between align-items-center mt-2">
                    <span class="text-muted">$0</span>

                    <div class="input-group input-group-sm" style="width: 110px;">
                        <span class="input-group-text">$</span>
                        <input type="number" id="price_input" value="1000" min="0" max="1000"
                            step="10" class="form-control text-center">
                    </div>
                    <span class="text-muted">$1000</span>
                </div>
                <input type="hidden" name="selected_price" id="selected_price" value="500">
            </div>
        @endif
        @if (!empty($colors))
            <div class="filter-group">
                <h6 class="mb-3">Colors</h6>
                <div class="d-flex gap-2 flex-wrap">
                    @foreach ($colors as $color)
                        <div class="color-option" data-color="{{ $color }}"
                            style="width: 30px; height: 30px; border-radius: 50%; cursor: pointer; border: 2px solid #ccc; background: {{ $color }};">
                        </div>
                    @endforeach
                </div>
                <input type="hidden" name="selected_color" id="selected_color">
            </div>
        @endif
        <div class="filter-group">
            <h6 class="mb-3">Rating</h6>
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="rating" id="rating4">
                <label class="form-check-label" for="rating4">
                    <i class="bi bi-star-fill text-warning"></i> 4 & above
                </label>
            </div>
            <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="rating" id="rating3">
                <label class="form-check-label" for="rating3">
                    <i class="bi bi-star-fill text-warning"></i> 3 & above
                </label>
            </div>
        </div>
        <button type="button" id="applyFilters" class="btn btn-outline-primary w-100">Apply Filters
            <span id="filterLoader" class="spinner-border spinner-border-sm text-danger ms-2" style="display: none;"
                role="status"></span>
        </button>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const priceRange = document.getElementById("price_range");
        const priceInput = document.getElementById("price_input");
        const selectedPrice = document.getElementById("selected_price");

        priceRange.addEventListener("input", function() {
            const val = this.value;
            priceInput.value = val;
            selectedPrice.value = val;
        });

        priceInput.addEventListener("input", function() {
            let val = this.value;

            if (val < 0) val = 0;
            if (val > 1000) val = 1000;

            priceRange.value = val;
            selectedPrice.value = val;
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // =======================
        // Color Selection
        // =======================
        const colorOptions = document.querySelectorAll(".color-option");
        const selectedColorInput = document.getElementById("selected_color");

        if (colorOptions && selectedColorInput) {
            colorOptions.forEach(option => {
                option.addEventListener("click", function() {
                    this.classList.toggle("selected");
                    const selectedColors = Array.from(document.querySelectorAll(
                            ".color-option.selected"))
                        .map(el => el.getAttribute("data-color"));
                    selectedColorInput.value = selectedColors.join(",");
                    console.log("Selected colors:", selectedColors);
                });
            });
        }

        // =======================
        // Price Range
        // =======================
        const priceRange = document.getElementById("price_range");
        const priceInput = document.getElementById("price_input");
        const selectedPrice = document.getElementById("selected_price");

        if (priceRange && priceInput && selectedPrice) {
            priceRange.addEventListener("input", function() {
                const val = this.value;
                priceInput.value = val;
                selectedPrice.value = val;
            });

            priceInput.addEventListener("input", function() {
                let val = this.value;
                if (val < 0) val = 0;
                if (val > 1000) val = 1000;
                priceRange.value = val;
                selectedPrice.value = val;
            });
        }

        // =======================
        // Apply Filters
        // =======================
        const applyBtn = document.getElementById("applyFilters");
        const loader = document.getElementById("filterLoader");
        if (!applyBtn) return;

        applyBtn.addEventListener("click", function() {
            // Show loader & disable button
            loader.style.display = "inline-block";
            applyBtn.disabled = true;

            // Categories
            const categories = Array.from(document.querySelectorAll('input[type="checkbox"]:checked'))
                .filter(el => el.id && !el.id.startsWith('vendor_'))
                .map(el => parseInt(el.id));

            // Vendors
            const vendors = Array.from(document.querySelectorAll('input[name="vendor_id[]"]:checked'))
                .map(el => el.value);

            // Price
            const price = selectedPrice ? selectedPrice.value : 0;

            // Colors
            const colors = selectedColorInput ? selectedColorInput.value.split(',').filter(Boolean) :
        [];

            // Rating
            const ratingEl = document.querySelector('input[name="rating"]:checked');
            const rating = ratingEl ? ratingEl.id.replace('rating', '') : null;

            // AJAX request
            fetch("{{ url(config('solimap.app.prefix', 'solimap') . '/products/filter') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        categories,
                        vendors,
                        price,
                        colors,
                        rating
                    })
                })
                .then(res => res.json())
                .then(data => {
                    const productList = document.getElementById("productList");
                    const bundleList = document.getElementById("bundleList");

                    if (productList) productList.innerHTML = "";
                    if (bundleList) bundleList.innerHTML = "";

                    // --- Products ---
                    if (data.products?.length && productList) {
                        data.products.forEach(product => {
                            const card = `
                        <div class="col-md-4">
                            <div class="product-card shadow-sm">
                                <div class="position-relative">
                                    <img src="${product.image ?? '/vendor/solimap/uploads/no_photo.png'}"
                                         class="product-image" alt="${product.name}">
                                    <span class="discount-badge">-20%</span>
                                    <button class="wishlist-btn"><i class="bi bi-heart"></i></button>
                                </div>
                                <div class="p-3">
                                    <span class="category-badge mb-2 d-inline-block">${product.category?.name ?? ''}</span>
                                    <h6 class="mb-1">${product.name}</h6>
                                    <p class="card-text">${product.description ?? ''}</p>
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
                                            <h6 class="mt-2">Price in Tokens:</h6>
                                            <ul class="mb-0">
                                                ${product.currencies?.map(c => `<li>${c.pivot.count} × ${c.name}</li>`).join('')}
                                            </ul>
                                        </div>
                                        <div>
                                            <button class="btn cart-btn mx-2"><i class="bi bi-cart-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                            productList.insertAdjacentHTML("beforeend", card);
                        });
                    } else if (productList) {
                        productList.innerHTML = "<p class='text-center'>No products found!</p>";
                    }

                    // --- Bundles ---
                    if (data.bundles?.length && bundleList) {
                        data.bundles.forEach(bundle => {
                            const card = `
                        <div class="col-md-4">
                            <div class="product-card shadow-sm">
                                <div class="position-relative">
                                    <img src="${bundle.image ?? '/vendor/solimap/uploads/no_photo.png'}"
                                         class="product-image" alt="${bundle.name}">
                                    <span class="discount-badge">-20%</span>
                                    <button class="wishlist-btn"><i class="bi bi-heart"></i></button>
                                </div>
                                <div class="p-3">
                                    <h6 class="mb-1">${bundle.name}</h6>
                                    <p class="card-text">${bundle.description ?? ''}</p>
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
                                            <h6 class="mt-2">Price: $${bundle.price ?? '0.00'}</h6>
                                        </div>
                                        <div>
                                            <a href="${'{{ config('app.bundle_url') }}'}/products/${bundle.id}" target="_blank">
                                                <button class="btn cart-btn mx-2"><i class="bi bi-cart-plus"></i></button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                            bundleList.insertAdjacentHTML("beforeend", card);
                        });
                    } else if (bundleList) {
                        bundleList.innerHTML = "<p class='text-center'>No bundles found!</p>";
                    }
                })
                .catch(err => console.error("Filter error:", err))
                .finally(() => {
                    loader.style.display = "none"; // hide loader
                    applyBtn.disabled = false; // enable button
                });
        });
    });
</script>
