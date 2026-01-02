<form method="GET" class="mb-4 space-y-4 md:flex items-center mt-2 md:space-y-0 md:space-x-3">
    
<section class="flex space-x-2 md:w-1/2">
      <input type="text" name="search" placeholder="Search entries..."
    value="{{ request('search') }}"
    class="border rounded px-2 py-1 w-full">
    <button type="submit" class="px-3 py-1 rounded w-20">
        Search
    </button> 
</section>
 
<section class="flex space-x-2 md:w-1/2">
    <label for="per_page" class="font-medium ml-auto ">Items per page:</label>
    <input type="number" name="per_page" id="per_page" min="1" max="50"
           value="{{ request('per_page', 10) }}"
           class="border rounded px-2 py-1 w-20">
    <button type="submit" class="px-3 py-1 rounded w-17">
        Apply
    </button>
</section>
 
</form>