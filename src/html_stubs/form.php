

<form action="" method="post">
    <div class="mb-3">
        <label for="vendor" class="form-label">Vendor name</label>
        <input type="text" class="form-control field" id="vendor" aria-describedby="vendor" name="vendor">
        <div id="vendor" class="form-text">Enter the name of the vendor your receipt is from.</div>
    </div>

    <div class="mb-3">
        <label for="item" class="form-label">Item name</label>
        <input type="text" class="form-control field" id="item" aria-describedby="item" name="item">
        <div id="item" class="form-text">Enter the name of the item from your receipt.</div>
    </div>

    <div class="mb-3">
        <label for="category" class="form-label">Category</label>
            <select class="form-select field" aria-label="category">
                <option selected>Open this select menu</option>
                <option value="1">Produce</option>
                <option value="2">Meat</option>
                <option value="3">Seafood</option>
                <option value="4">Deli</option>
                <option value="5">Bakery</option>
                <option value="6">Seafood</option>
                <option value="7">Household</option>
                <option value="8">Alcohol</option>
                <option value="9">Weed</option>
                <option value="10">Snacks</option>
                <option value="11">Utilities</option>
                <option value="12">Maintenance</option>
                <option value="13">Auto</option>
                <option value="14">Clothing</option>
                <option value="15">Toys</option>
                <option value="16">Entertainment</option>
                <option value="17">Medical</option>
            </select>
        <div id="category" class="form-text">Enter the category of the receipt.</div>
    </div>

    <div class="mb-3">
        <label for="subtotal" class="form-label">Subtotal</label>
        <input type="number" step="0.01" min="0.00" class="form-control field" id="subtotal" aria-describedby="subtotal">
        <div id="subtotal" class="form-text">Receipt subtotal.</div>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="number" step="0.01" min="0.00" class="form-control field" id="price" aria-describedby="price">
        <div id="price" class="form-text">Receipt Price.</div>
    </div>

    <div class="mb-3">
        <label for="date" class="form-label">Date</label>
        <input type="date"  class="form-control field" id="date" aria-describedby="date">
        <div id="date" class="form-date">Receipt Date.</div>
    </div>

    <button type="submit" class="btn btn-success">Add Receipt</button>
</form>
