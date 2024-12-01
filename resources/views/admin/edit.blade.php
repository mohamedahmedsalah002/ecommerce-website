@include('layouts.head.head')
<div class="container mt-4">
    <h2 class="mb-4">Edit Product</h2>

    <!-- Display any validation errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Display the success message -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Update form -->
    <form action="{{ route('admin.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-12">
                <!-- Product Name -->
                <div class="form-group">
                    <label for="name">Product Name:</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <!-- Product Description -->
                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <!-- Category Selection -->
                <div class="form-group">
                    <label for="category">Category:</label>
                    <select class="form-control" name="category_id" id="category" required>
                        <option value="" disabled selected>Select category</option>
                        @foreach ($category as $c)
                            <option value="{{ $c->id }}" @if ($product->category_id == $c->id) selected @endif>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <!-- Product Price -->
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" value="{{ old('price', $product->price) }}" required>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-12">
                <!-- New Product Image -->
                <div class="form-group">
                    <label for="image">Update Photo:</label>
                    <input type="file" class="form-control-file" id="image" name="image">
                </div>
            </div>
        </div>

        <!-- Existing Product Image -->
        @if ($product->image)
            <div class="row mb-3">
                <div class="col-md-12">
                    <label>Current Photo:</label><br>
                    <img src="{{ asset('storage/' . $product->image) }}" alt="Product Photo" class="img-thumbnail" style="width: 150px;">
                </div>
            </div>
        @endif

        <!-- Submit Button -->
        <div class="row">
            <div class="col-md-12 d-flex justify-content-end align-items-center">
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>
        </div>
        
    </form>
</div>
