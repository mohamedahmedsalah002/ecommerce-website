<div class="container mt-5 mb-5">
    <div class="row d-flex justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm">
                <div class="row">
                    <!-- Product Image Section -->
                    <div class="col-md-6">
                        <div class="images p-3">
                            <div class="text-center p-4">
                                <img id="main-image" src="{{ asset('storage/' . $product->image) }}" class="img-fluid main-img" alt="{{ $product->name }}">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Product Details Section -->
                    <div class="col-md-6">
                        <div class="product p-4">
                            <div class="mt-4 mb-3">
                                <h5 class="text-uppercase">{{ $product->name }}</h5>
                                <div class="price d-flex flex-row align-items-center">
                                    <span class="act-price">{{ number_format($product->price, 2) }} EGP</span>
                                </div>
                            </div>

                            <div class="description mt-4 mb-3">
                                <h6 class="text-uppercase">Description</h6>
                                <p class="about">{{ $product->description }}</p>
                            </div>

                            <div class="cart mt-4">
                                <form action="{{ route('cart.addCart', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Inline CSS -->
<style>
    body { background-color: #f8f9fa; }
    .card { border: none; border-radius: 8px; }
    .main-img { max-width: 100%; border-radius: 8px; }
    .product { background-color: #ffffff; border-radius: 8px; }
    .act-price { color: #dc3545; font-weight: bold; font-size: 24px; }
    .description h6 { font-size: 18px; color: #343a40; font-weight: 600; }
    .about { font-size: 16px; color: #343a40; }
    .cart button { font-size: 16px; }
    .text-muted { color: #6c757d !important; }
</style>

<!-- JavaScript -->
<script>
    function change_image(element) {
        var mainImage = document.getElementById('main-image');
        mainImage.src = element.src;
    }
</script>

<!-- Bootstrap and Font Awesome -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
