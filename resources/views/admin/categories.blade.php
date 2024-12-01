@include('layouts.head.head')

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    
                    <a href="javascript:history.back()" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="fas fa-arrow-left me-2"></i> 
                        <span>Back</span>
                    </a>
                    <h4 class="text-center mb-0 flex-grow-1">Add Category</h4>
                </div>
                <div class="card-body">
                    <!-- Add Category Form -->
                    <form action="{{ route('admin.category.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="categoryName" class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="categoryName" placeholder="Enter category name" value="{{ old('name') }}">
                            <!-- Validation error message for category name -->
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-plus"></i> Add Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
