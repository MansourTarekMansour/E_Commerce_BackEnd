<div class="fixed-per-page-selector">
    <form method="GET" action="{{ route($route) }}">
        <label for="per_page">Items per page:</label>
        <select name="per_page" id="per_page" onchange="this.form.submit()">
            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
            <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>100</option>
        </select>
    </form>
</div>
