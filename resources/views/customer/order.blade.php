@include('layouts.head.head');

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Place Your Order') }}</div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('customer.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <h5>Your Order</h5>
                            @foreach($products as $item)
                                <div class="border p-3 mb-2">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <img src="{{ asset('storage/' . $item['product']->image) }}" alt="{{ $item['product']->name }}" width="50" height="50" class="mr-2">
                                            <span>{{ $item['product']->name }} (Quantity: {{ $item['quantity'] }})</span>
                                        </div>
                                        <div>
                                            
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="form-group">
                            <label for="order_date">Order Date</label>
                            <input type="date" name="order_date" id="order_date" class="form-control" value="{{ now()->format('Y-m-d') }}" required readonly>
                        </div>

                       

                        <div class="mb-4">
                            <h5>Total Price</h5>
                          {{$totalPrice}}
                        </div>

                    
                    <button type="submit" class="btn btn-primary btn-block">Place Order</button>
                    </form>

            
                </div>
        
