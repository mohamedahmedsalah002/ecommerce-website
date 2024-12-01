@include('layouts.head.head')
@include('layouts.header.header')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 text-center pb-5">
            <h3>Featured Products</h3>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success text-center" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-4">
        @foreach($products as $product)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card card-custom h-100 shadow-lg border-light rounded-3">
                    <div class="d-flex justify-content-center align-items-center overflow-hidden" style="padding-top: 20px;">
                        <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top custom-img" alt="{{ $product->name }}">
                    </div>
                    <div class="card-body d-flex flex-column align-items-center text-center">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text mb-4">${{ $product->price }}</p>
                        <div class="d-flex flex-column w-100">
                            <a href="{{ route('productShow', $product->id) }}" class="btn btn-primary mb-2">Details</a>
                            <form action="{{ route('cart.addCart', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                    <div class="card-footer bg-light text-center">
                        <small class="text-muted">Free Shipping</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <style>
    /* Custom styles for e-commerce card */
    .custom-img {
        max-width: 150px; /* Set a fixed maximum width for the image */
        height: auto; /* Maintain aspect ratio */
        object-fit: cover; /* Ensure image covers the area */
    }
    
    .card-custom {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card-custom:hover {
        transform: scale(1.02); /* Slightly zoom the card on hover */
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Add shadow on hover */
    }
    </style>
</div>
