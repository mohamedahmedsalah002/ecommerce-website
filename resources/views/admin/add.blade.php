@include('layouts.head.head')

<!-- Container for Centering -->
<div class="d-flex justify-content-center align-items-center mt-5 vh-100">
    <!-- Bootstrap Form -->
    <form action="{{ route('admin.product.store') }}" enctype="multipart/form-data" method="post" class="p-5 rounded shadow-lg bg-white" style="width: 600px;">
        @csrf

        <!-- Error Message Display -->
        @if($errors->any())
            <div class="alert alert-danger">
                <strong>Error:</strong> {{$errors->first()}}
            </div>
        @endif

        <!-- Product Name -->
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control form-control-lg" value="{{ old('name') }}" placeholder="Enter product name" required>
        </div>

        <!-- Product Description -->
        <div class="mb-3">
            <label for="description" class="form-label">Product Description</label>
            <textarea name="description" id="description" class="form-control form-control-lg" rows="4" placeholder="Enter product description">{{ old('description') }}</textarea>
        </div>

        <!-- Product Price -->
        <div class="mb-3">
            <label for="price" class="form-label">Product Price</label>
            <input type="number" name="price" id="price" class="form-control form-control-lg" value="{{ old('price') }}" placeholder="Enter product price" required>
        </div>

        <!-- Photo Upload -->
        <div class="mb-3">
            <label for="photo" class="form-label">Product Photo</label>
            <input type="file" class="form-control" id="photo" name="photo" required>
        </div>

        <!-- Category Selection -->
        <div class="mb-3">
            <label for="category" class="form-label">Category</label>
            <select class="form-control form-control-lg" name="category_id" id="category" required>
                <option value="" disabled selected>Select category</option>
                @foreach ($category as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="text-end pt-3">
            <button type="submit" class="btn btn-lg btn-primary">Submit Product</button>
        </div>
    </form>
</div>

<!-- Custom Styling -->
<style>
    body {
        background-color: #f0f0f0;
        font-family: 'Poppins', sans-serif;
    }

    .vh-100 {
        height: 100vh;
    }

    .shadow-lg {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }
</style>
