@include('layouts.head.head')
@include('layouts.header.header')

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        .product-card {
            background-color: #fff;
            margin-bottom: 1.5rem;
            padding: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
        }

        .product-image {
            width: 100%;
            max-width: 100px; /* Adjust based on desired size */
            height: auto;
        }

        .product-details h5 {
            font-size: 1.25rem;
            margin-bottom: 0;
        }

        .product-price {
            font-size: 1.2rem;
            font-weight: bold;
        }

        .row.no-gutters {
            margin-right: 0;
            margin-left: 0;
        }

        .card-body {
            padding: 1rem;
        }

        .text-center {
            text-align: center;
        }

        .checkout-section {
            margin-top: 2rem;
            text-align: center;
        }

        .btn-checkout {
            background-color: #28a745;
            color: #fff;
            font-size: 1.2rem;
            padding: 0.75rem 2rem;
            border-radius: 0.3rem;
        }

        .btn-checkout:hover {
            background-color: #218838;
        }

        .total-price-section {
            background-color: #f8f9fa; /* Light background */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-top: 2rem;
            margin-bottom: 2rem;
        }

        .total-price-section h4 {
            margin-bottom: 0.5rem;
        }

        .total-price-section p {
            margin: 0;
            font-size: 2.5rem; /* Larger font for the price */
            color: #28a745; /* Green color */
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h2>Shopping Cart</h2>
    
        @foreach($products as $item)
            @include('customer.item', ['product' => $item['product'], 'quantity' => $item['quantity']])
        @endforeach
    
        <!-- Total Price Section -->

        @if($totalPrice > 0) 
            <div class="total-price-section card p-3 my-4 text-center">
                <h4>Total Price</h4>
                <p class="display-4 text-success font-weight-bold">{{ $totalPrice }}</p>
            </div>
        @endif
    
        <!-- Checkout Button Section -->
        <div class="checkout-section">
            @if($totalPrice > 0)
                <a href="{{ route('customer.create') }}" class="btn btn-checkout">Checkout</a>
            @else
                <p class="text-muted">Your cart is empty. Add items to checkout.</p>
            @endif
        </div>
    </div>
    

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
