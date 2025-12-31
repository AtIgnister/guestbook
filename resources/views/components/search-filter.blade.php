<form method="GET" class="mb-4 flex items-center space-x-2 mt-2">
    <input type="text" name="search" placeholder="Search entries..."
    value="{{ request('search') }}"
    class="border rounded px-2 py-1 w-60">
    <button type="submit" class="px-3 py-1 rounded">
        Search
    </button>

    <label for="per_page" class="text-sm font-medium">Items per page:</label>
    <input type="number" name="per_page" id="per_page" min="1" max="50"
           value="{{ request('per_page', 10) }}"
           class="border rounded px-2 py-1 w-20">
    <button type="submit" class="px-3 py-1 rounded">
        Apply
    </button>
</form>