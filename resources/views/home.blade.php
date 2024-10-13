@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Products Card -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Products</h5>
                </div>
                <div class="card-body">
                    <h4>Total Products: {{ $totalProducts }}</h4>
                </div>
            </div>
        </div>

        <!-- Products by Category Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Products by Category</h5>
                </div>
                <div class="card-body">
                    <canvas id="productsByCategoryChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Products by Brand Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Products by Brand</h5>
                </div>
                <div class="card-body">
                    <canvas id="productsByBrandChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="col-md-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Orders</h5>
                </div>
                <div class="card-body">
                    <h4>Total Orders: {{ $totalOrders }}</h4>
                </div>
            </div>
        </div>

        <!-- Orders by Status Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Orders by Status</h5>
                </div>
                <div class="card-body">
                    <canvas id="ordersByStatusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Orders by Month Card -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5>Orders by Month</h5>
                </div>
                <div class="card-body">
                    <canvas id="ordersByMonthChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const navigateTo = (url) => {
            console.log("Navigating to: ", url); // Debugging output
            window.location.href = url;
        };

        // Products by Brand Bar Chart
        const productsByBrandData = {!! json_encode($productsByBrand) !!};
        const brandIds = {!! json_encode($brandIds) !!}; // Get brand IDs mapping
        const brandNames = Object.keys(productsByBrandData);
        const brandCounts = Object.values(productsByBrandData);

        new Chart(document.getElementById('productsByBrandChart'), {
            type: 'bar',
            data: {
                labels: brandNames,
                datasets: [{
                    label: 'Products',
                    data: brandCounts,
                    backgroundColor: '#42A5F5',
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                onClick: function (event, items) {
                    
                    const points = this.getElementsAtEventForMode(event, 'nearest', { intersect: true }, true);

                    if (points.length) {
                        const index = points[0].index; // Get the index of the clicked item
                        const brandName = this.data.labels[index]; // Get the label using the index
                        console.log("Clicked brand name: ", brandName); // Debugging output
                        console.log("Brand IDs mapping: ", brandIds); // Debugging output

                        // Check if brandName exists in brandIds
                        const brandId = brandIds[brandName]; // Get the brand ID from the mapping
                        if (brandId) {
                            console.log("Brand ID found: ", brandId); // Debugging output
                            navigateTo("{{ route('products.index') }}?brand=" + brandId);
                        } else {
                            console.error('Brand ID not found for brand:', brandName);
                        }
                    }
                }
            }
        });

        // Products by Category Bar Chart
        const productsByCategoryData = {!! json_encode($productsByCategory) !!};
        const categoryIds = {!! json_encode($categoryIds) !!}; // Get category IDs mapping
        const categoryNames = Object.keys(productsByCategoryData);
        const categoryCounts = Object.values(productsByCategoryData);

        new Chart(document.getElementById('productsByCategoryChart'), {
            type: 'bar',
            data: {
                labels: categoryNames,
                datasets: [{
                    label: 'Products',
                    data: categoryCounts,
                    backgroundColor: '#66BB6A',
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                onClick: function (event, items) {
                    const points = this.getElementsAtEventForMode(event, 'nearest', { intersect: true }, true);

                    if (points.length) {
                        const index = points[0].index; // Get the index of the clicked item
                        const categoryName = this.data.labels[index]; // Get the label using the index
                        console.log("Clicked category name: ", categoryName); // Debugging output
                        console.log("Category IDs mapping: ", categoryIds); // Debugging output

                        // Check if categoryName exists in categoryIds
                        const categoryId = categoryIds[categoryName]; // Get the category ID from the mapping
                        if (categoryId) {
                            console.log("Category ID found: ", categoryId); // Debugging output
                            navigateTo("{{ route('products.index') }}?category=" + categoryId);
                        } else {
                            console.error('Category ID not found for category:', categoryName);
                        }
                    }
                }
            }
        });

        // Orders by Status Bar Chart
        const ordersByStatusData = {!! json_encode($ordersByStatus) !!};
        const statusNames = Object.keys(ordersByStatusData);
        const statusCounts = Object.values(ordersByStatusData);

        new Chart(document.getElementById('ordersByStatusChart'), {
            type: 'bar',
            data: {
                labels: statusNames,
                datasets: [{
                    label: 'Orders',
                    data: statusCounts,
                    backgroundColor: ['#EF5350', '#FFA726', '#66BB6A'],
                }]
            },
            options: {
                plugins: {
                    legend: { display: false }
                },
                onClick: function () {
                    navigateTo("{{ route('orders.index') }}");  // Change to your orders route
                }
            }
        });

        // Orders by Month Line Chart
        const ordersByMonthData = {!! json_encode($ordersByMonth) !!};
        const monthNames = Object.keys(ordersByMonthData);
        const monthCounts = Object.values(ordersByMonthData);

        new Chart(document.getElementById('ordersByMonthChart'), {
            type: 'line',
            data: {
                labels: monthNames,
                datasets: [{
                    label: 'Orders',
                    data: monthCounts,
                    borderColor: '#AB47BC',
                    fill: false
                }]
            },
            options: {
                scales: {
                    x: { title: { display: true, text: 'Month' } },
                    y: { title: { display: true, text: 'Number of Orders' } }
                },
                onClick: function () {
                    navigateTo("{{ route('orders.index') }}");  // Change to your orders route
                }
            }
        });
    });
</script>



<script src="{{ asset('js/custom.js') }}"></script>
@endsection
