<div class="filters">
    <h4>Filters</h4>
    <form id="filter-form">
        <div class="filter-category">
            <h5>Category</h5>
            <select name="category" id="category">
                <option value="">All</option>
                <option value="electronics">Electronics</option>
                <option value="clothing">Clothing</option>
                <option value="home">Home</option>
            </select>
        </div>
        <div class="filter-price">
            <h5>Price Range</h5>
            <input type="number" name="min_price" id="min_price" placeholder="Min" />
            <input type="number" name="max_price" id="max_price" placeholder="Max" />
        </div>
        <button type="button" id="apply-filters" class="btn btn-primary">Apply Filters</button>
    </form>
</div>

<script>
    document.getElementById('apply-filters').addEventListener('click', function() {
    const search = document.querySelector('input[name="search"]').value;
    const category = document.getElementById('category').value;
    const minPrice = document.getElementById('min_price').value;
    const maxPrice = document.getElementById('max_price').value;

    // Δημιουργία του query string για την αναζήτηση
    const query = new URLSearchParams({
        search: search,
        category: category,
        min_price: minPrice,
        max_price: maxPrice,
        filter: true
    });

    // Αποστολή του query στο server
    fetch(`search.php?${query.toString()}`)
        .then(response => response.text())
        .then(data => {
            document.querySelector('#search .container-lg').innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
});
</script>