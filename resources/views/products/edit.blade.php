@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h2 class="text-center">Update Product</h2>
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- This will send a PUT request -->

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $product->name }}" required oninput="updatePreview()">
            </div>
            <div class="col-md-6">
                <label for="price" class="form-label">Price</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" value="{{ $product->price }}" required oninput="updatePreview()">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3" required oninput="updatePreview()">{{ $product->description }}</textarea>
            </div>
            <div class="col-md-6">
                <label for="discount_price" class="form-label">Discount Price</label>
                <input type="number" class="form-control" id="discount_price" name="discount_price" step="0.01" value="{{ $product->discount_price }}" oninput="updatePreview()">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="images" class="form-label">Upload Images</label>
                <input type="file" class="form-control" id="images" name="images[]" accept="image/*" multiple onchange="handleImageUpload()">
                <div class="form-text">You can upload multiple images. Leave empty to keep existing images.</div>
                <div id="imagePreview" class="mt-2"></div> <!-- Place to display the uploaded images -->
            </div>
            <div class="col-md-6">
                <label for="quantity_in_stock" class="form-label">Quantity in Stock</label>
                <input type="number" class="form-control" id="quantity_in_stock" name="quantity_in_stock" value="{{ $product->quantity_in_stock }}" required oninput="updatePreview()">
            </div>
        </div>

        <div class="mb-3">
            <label for="uploaded_images" class="form-label">Uploaded Images</label>
            <div id="uploaded_images" class="d-flex flex-wrap">
                @foreach($product->files as $file)
                <div class="image-container position-relative me-2 mb-2" data-id="{{ $file->id }}" style="padding: 5px;">
                    <img src="{{ $product->getImageUrl($file->url) }}" alt="Product Image" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        style="cursor: pointer;"
                        onclick="deleteImage({{ $file->id }})">×
                    </span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- <div class="mb-3">
            <label for="new_uploaded_images" class="form-label">New Uploaded Images</label>
            <div id="new_uploaded_images" class="d-flex flex-wrap"></div>
        </div> -->


        <div class="row mb-3">
            <!-- Category and Add New Button Inline -->
            <div class="col-md-6">
                <div class="mb-3 d-flex align-items-center me-2">
                    <label for="category_id" class="form-label ">Select Category </label>
                    <select class="form-select me-2" id="category_id" name="category_id" required onchange="updatePreview()">
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-secondary" id="toggleCategoryButton" onclick="toggleCategoryForm()">+</button>
                </div>

                <!-- New Category Form -->
                <div id="newCategoryForm" class="mb-3" style="display: none;">
                    <label for="new_category_name" class="form-label">New Category Name</label>
                    <input type="text" class="form-control" id="new_category_name" name="new_category_name">
                    <button type="button" class="btn btn-primary mt-2" onclick="addCategory()">Add Category</button>
                </div>
            </div>


            <!-- Brand and Add New Button Inline -->
            <div class="col-md-6">
                <div class="mb-3 d-flex align-items-center">
                    <label for="brand_id" class="form-label">Select Brand </label>
                    <select class="form-select me-2" id="brand_id" name="brand_id" required onchange="updatePreview()">
                        <option value="">Select a brand</option>
                        @foreach($brands as $brand)
                        <option value="{{ $brand->id }}" {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                            {{ $brand->name }}
                        </option>
                        @endforeach
                    </select>
                    <button type="button" class="btn btn-secondary" id="toggleBrandButton" onclick="toggleBrandForm()">+</button>
                </div>

                <!-- New Brand Form -->
                <div id="newBrandForm" class="mb-3" style="display: none;">
                    <label for="new_brand_name" class="form-label">New Brand Name</label>
                    <input type="text" class="form-control" id="new_brand_name" name="new_brand_name">
                    <button type="button" class="btn btn-primary mt-2" onclick="addBrand()">Add Brand</button>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-main">Update Product</button>
    </form>
</div>

<script>
    function toggleCategoryForm() {
        const form = document.getElementById('newCategoryForm');
        const button = document.getElementById('toggleCategoryButton');

        // Toggle form visibility
        form.style.display = form.style.display === 'none' ? 'block' : 'none';

        // Change button text from '+' to 'x' and vice versa
        button.textContent = form.style.display === 'none' ? '+' : 'x';
    }

    function toggleBrandForm() {
        const form = document.getElementById('newBrandForm');
        const button = document.getElementById('toggleBrandButton');

        // Toggle form visibility
        form.style.display = form.style.display === 'none' ? 'block' : 'none';

        // Change button text from '+' to 'x' and vice versa
        button.textContent = form.style.display === 'none' ? '+' : 'x';
    }

    function addCategory() {
        let newCategoryName = document.getElementById('new_category_name').value;

        if (newCategoryName) {
            // Send the new category to the server via AJAX
            fetch("{{ route('categories.storeAjax') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: newCategoryName
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Add the new category to the category dropdown
                    let categorySelect = document.getElementById('category_id');
                    let newOption = new Option(data.name, data.id);
                    categorySelect.add(newOption, undefined);
                    categorySelect.value = data.id; // Set the new category as selected

                    // Hide the new category form and reset the input
                    document.getElementById('newCategoryForm').style.display = 'none';
                    document.getElementById('new_category_name').value = '';

                    // Reset the button text
                    document.getElementById('toggleCategoryButton').textContent = '+';

                    // Success message
                    alert('Category added successfully!'); // You can also replace this with a nicer UI notification
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to add category. Please try again.');
                });
        } else {
            alert('Please enter a category name.');
        }
    }

    function addBrand() {
        let newBrandName = document.getElementById('new_brand_name').value;

        if (newBrandName) {
            // Send the new brand to the server via AJAX
            fetch("{{ route('brands.storeAjax') }}", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        name: newBrandName
                    })
                })
                .then(response => response.json())
                .then(data => {
                    // Add the new brand to the brand dropdown
                    let brandSelect = document.getElementById('brand_id');
                    let newOption = new Option(data.name, data.id);
                    brandSelect.add(newOption, undefined);
                    brandSelect.value = data.id; // Set the new brand as selected

                    // Hide the new brand form and reset the input
                    document.getElementById('newBrandForm').style.display = 'none';
                    document.getElementById('new_brand_name').value = '';

                    // Reset the button text
                    document.getElementById('toggleBrandButton').textContent = '+';

                    // Success message
                    alert('Brand added successfully!'); // You can also replace this with a nicer UI notification
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to add brand. Please try again.');
                });
        } else {
            alert('Please enter a brand name.');
        }
    }

    function previewImages() {
        const newImagePreview = document.getElementById('new_uploaded_images');
        newImagePreview.innerHTML = ''; // Clear previous new images
        const files = document.getElementById('images').files;

        Array.from(files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgContainer = document.createElement('div');
                imgContainer.classList.add('image-container', 'position-relative', 'me-2', 'mb-2');
                imgContainer.style.padding = '5px';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('img-thumbnail');
                img.style.width = '100px';
                img.style.height = '100px';
                img.style.objectFit = 'cover';

                const closeButton = document.createElement('span');
                closeButton.classList.add('position-absolute', 'top-0', 'start-100', 'translate-middle', 'badge', 'rounded-pill', 'bg-danger');
                closeButton.style.cursor = 'pointer';
                closeButton.textContent = '×';
                closeButton.onclick = function() {
                    imgContainer.remove(); // Remove the preview image
                };

                imgContainer.appendChild(img);
                imgContainer.appendChild(closeButton);
                newImagePreview.appendChild(imgContainer); // Append to the new image preview container
            };
            reader.readAsDataURL(file);
        });
    }

    function handleImageUpload() {
        const fileInput = document.getElementById('images');
        const files = fileInput.files;
        const imagePreview = document.getElementById('imagePreview');
        imagePreview.innerHTML = ''; // Clear previous previews

        Array.from(files).forEach(file => {

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = file.name;
                img.classList.add('img-thumbnail', 'me-2', 'my-2'); // Add Bootstrap classes for styling
                img.style.width = '100px'; // Set a fixed width for the preview
                imagePreview.appendChild(img); // Add image to the preview div
            };
            reader.readAsDataURL(file); // Read the file as a data URL
        });
    }

    function deleteImage(fileId) {
        if (confirm('Are you sure you want to delete this image?')) {
            fetch(`{{ route('products.files.destroy', '') }}/${fileId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        const imageContainer = document.querySelector(`.image-container[data-id='${fileId}']`);
                        imageContainer.remove();
                        alert('Image deleted successfully!');
                    } else {
                        alert('Failed to delete the image. Please try again.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred. Please try again.');
                });
        }
    }
</script>

@endsection