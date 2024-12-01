@include('layouts.head.head')
@include('layouts.header.header')

<div class="container mt-4">
    <h1 class="mb-4 text-center">All Products</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($products->isEmpty())
        <div class="alert alert-info" role="alert">
            No products found.
        </div>
    @else
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.category.create') }}" class="btn btn-primary me-2">
                <i class="fas fa-plus me-2"></i> Add New Category
            </a>
            <a href="{{ route('admin.product.add') }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i> Add New Product
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category</th>
                        <th>Photo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>${{ number_format($product->price, 2) }}</td>
                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                            <td>
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" width="150">
                            </td>
                            <td>
                                <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.product.destroy', $product->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this product?');">Delete</button>
                                </form>
                                
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<style>
    .table th, .table td {
        vertical-align: middle;
    }
    .img-thumbnail {
        max-height: 80px;
    }
    .btn-sm {
        font-size: 0.875rem;
    }
</style>
