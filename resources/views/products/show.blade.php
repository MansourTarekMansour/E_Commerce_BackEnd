@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Show Product</h2>
        </div>
        <div class="form-group">
            <strong>Created By:</strong>
            <a href="{{ route('users.show', $product->user->id) }}">
                {{ $product->user->name }}
            </a>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <h7 class="card-title">ID: {{ $product->id }}</h7>

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
            <strong>Created At:</strong>
            {{ $product->created_at->format('d M, Y H:i') }}
            ({{ $product->created_at->format('l') }}, {{ $product->created_at->diffForHumans() }})
        </div>

        <div class="form-group">
            <strong>Updated At:</strong>
            {{ $product->updated_at->format('d M, Y H:i') }}
            ({{ $product->updated_at->format('l') }}, {{ $product->updated_at->diffForHumans() }})
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
            <div class="col-2">
                <img src="{{ $product->getImageUrl($file->url) }}" class="img-thumbnail img-fluid thumb mb-2" data-bs-target="#productCarousel" data-bs-slide-to="{{ $key }}" style="cursor: pointer; height: 95px; width: 110px; object-fit: cover;">
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
                    <img src="{{ $product->getImageUrl($file->url) }}" class="d-block w-100 img-fluid img-thumbnail" alt="Product Image" style="object-fit: contain; width: 100%; height: 500px;">
                </div>
                @endif
                @endforeach
            </div>

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

<!-- Comments Section -->
<div class="row mt-5">
    <div class="col-lg-12">
        <h4>Comments</h4>

        @if($product->comments->isEmpty())
        <p>No comments available for this product.</p>
        @else
        @foreach($product->comments->whereNull('parent_id') as $comment)
        <div class="card mb-3">
            <div class="card-body">
                <strong>
                    @if ($comment->user)
                    {{ $comment->user->name }} (Admin):
                    @elseif ($comment->customer)
                    {{ $comment->customer->name }} (Customer):
                    @else
                    Unknown User:
                    @endif
                </strong>
                <p>{{ $comment->content }}</p>
                <small class="text-muted">
                    {{ $comment->created_at->format('d M, Y H:i') }}
                    ({{ $comment->created_at->format('l') }}, {{ $comment->created_at->diffForHumans() }})
                </small>

                <!-- Reply Button -->
                <button class="btn btn-link p-0 mt-2" data-bs-toggle="collapse"
                    data-bs-target="#replyForm-{{ $comment->id }}">
                    Reply
                </button>

                <!-- Replies -->
                <div class="mt-3">
                    @foreach($comment->replies as $reply)
                    <div class="card mb-2 ms-4">
                        <div class="card-body">
                            <strong>{{ $reply->user->name }}:</strong>
                            <p>{{ $reply->content }}</p>
                            <small class="text-muted">
                                {{ $reply->created_at->format('d M, Y H:i') }}
                                ({{ $reply->created_at->diffForHumans() }})
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Reply Form (Collapsible) -->
                <div class="collapse mt-2" id="replyForm-{{ $comment->id }}">
                    <form action="{{ route('comments.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div class="form-group">
                            <textarea name="content" class="form-control"
                                placeholder="Write a reply..." rows="2" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Submit Reply</button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
        @endif

        <!-- Add New Comment Form -->
        <form action="{{ route('comments.store') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="parent_id" value="">
            <div class="form-group">
                <textarea name="content" class="form-control" placeholder="Add a comment..." rows="3" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Submit Comment</button>
        </form>
    </div>
</div>


@endsection