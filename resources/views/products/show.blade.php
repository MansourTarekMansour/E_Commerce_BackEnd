@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Show Product</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary btn-sm" href="{{ route('products.index') }}"><i class="fa fa-arrow-left"></i> Back</a>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <h4>{{ $product->name }}</h4>

        <div class="form-group">
            <strong>Price:</strong> ${{ number_format($product->price, 2) }}
        </div>

        <div class="form-group">
            <strong>Discount Price:</strong> ${{ number_format($product->discount_price, 2) }}
        </div>

        <div class="form-group">
            <strong>Quantity in Stock:</strong> {{ $product->quantity_in_stock }}
        </div>

        <div class="form-group">
            <strong>Quantity Sold:</strong> {{ $product->quantity_sold }}
        </div>

        <div class="form-group">
            <strong>Available:</strong> {{ $product->is_available ? 'Yes' : 'No' }}
        </div>

        <div class="form-group">
            <strong>Rating:</strong> {{ $product->rating ?? 'Not rated' }}
        </div>

        <div class="form-group">
            <strong>Category:</strong> {{ $product->category ? $product->category->name : 'N/A' }}
        </div>

        <div class="form-group">
            <strong>Brand:</strong> {{ $product->brand ? $product->brand->name : 'N/A' }}
        </div>

        <div class="form-group">
            <strong>Description:</strong>
            <p>{{ $product->description ?? 'No description available' }}</p>
        </div>

        <div class="form-group">
            <strong>Created At:</strong> {{ $product->created_at->format('d M, Y H:i') }}
        </div>

        <div class="form-group">
            <strong>Updated At:</strong> {{ $product->updated_at->format('d M, Y H:i') }}
        </div>
    </div>

    <!-- Image Carousel with Thumbnails -->
    <div class="col-md-6">
        <h4>Product Images</h4>

        @if($product->files->isNotEmpty())
            <!-- Thumbnail Gallery -->
            <div class="row mb-3 thumbnail-row">
                @foreach($product->files as $key => $file)
                    @if($file->file_type == 'image')
                        <div class="col-2"> <!-- Reduced padding -->
                            <img src="{{ asset('storage/' . $file->url) }}" class="img-thumbnail img-fluid thumb mb-2" data-bs-target="#productCarousel" data-bs-slide-to="{{ $key }}" style="cursor: pointer; height: 95px; width: 110px; object-fit: cover;"> <!-- Fixed thumbnail size -->
                        </div>
                    @endif
                @endforeach
            </div>

            <!-- Main Carousel -->
            <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($product->files as $key => $file)
                        @if($file->file_type == 'image')
                            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                <img src="{{ asset('storage/' . $file->url) }}" class="d-block w-100 img-fluid img-thumbnail" alt="Product Image" style="object-fit: contain; width: 100%; height: 500px;"> <!-- Fixed main image size -->
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Custom black scroll buttons -->
                <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: black;"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: black;"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        @else
            <p>No images available for this product.</p>
        @endif
    </div>
</div>

@endsection
