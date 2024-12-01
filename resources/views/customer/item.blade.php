<div class="card mb-3 product-card">
    <div class="row no-gutters align-items-center">
        <!-- Product Image -->
        <div class="col-md-2">
            <img src="{{ asset('storage/' . $item['product']->image) }}" class="img-fluid product-image" alt="Product Image">
        </div>

        <!-- Product Info (Name, Quantity, Price) -->
        <div class="col-md-6 text-center">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">Quantity: {{ $quantity }}</p>
                <p class="card-text">Total: &euro; {{ $product->price * $quantity  }}</p>
            </div>
        </div>

        <!-- Price and Buttons -->
        <div class="col-md-4 text-center">
            <div class="product-actions">
                <h5 class="product-price">&euro; {{ $product->price }}</h5>

                <!-- Add Item Form -->
                <form action="{{ route('cart.item.add', $product->id) }}" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm">+</button>
                </form>

                <!-- Remove Item Form -->
                <form action="{{ route('cart.item.remove', $product->id) }}" method="post" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-warning btn-sm">-</button>
                </form>

                <!-- Delete Item Form -->
                <form action="{{ route('cart.item.delete', $product->id) }}" method="post" class="d-inline">
                    @csrf
                    @method('delete')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
