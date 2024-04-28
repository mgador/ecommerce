<?php include('partials/__header.php'); ?>
<?php include('middleware/userAuth.php'); ?>

<?php $items = $customer->view_cart($_GET['id']); ?>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Select</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 0;
        foreach($items as $item) : ?>
        <?php $stock_qty = $product->view_product_details($item['product_id']) ?>
            <tr>
                <td><?= ++$count; ?></td>
                <td><?= $item['item_name']; ?></td>
                <td>
                    <?php if($stock_qty['quantity'] == 0): ?>
                        <input type="number" min="1" max="<?= $stock_qty['quantity'] ?>" value="<?= $item['qty'] ?>" disabled>
                    <?php else: ?>
                        <input type="number" min="1" max="<?= $stock_qty['quantity'] ?>" value="<?= $item['qty'] ?>" data-stock-price="<?= $stock_qty['price'] ?>" class="quantity-input">
                    <?php endif; ?>
                </td>
                <td class="price-column"><?= number_format($item['price'], 2) ?></td>
                <td>
                    <input type="checkbox" name="selected_items[]" value="<?= $item['item_name'] ?>" data-item-price="<?= $item['price'] ?>" checked>
                </td>
                <td>
                    <form action="" method="post">
                        <button>delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<br><br>
<label for="mode_of_payment">Mode of Payment</label>
<select name="mop" id="mop">
    <option value="">Cash on Delivery</option>
    <option value="">Paypal</option>
</select>

<div id="total">Overall Total: $0.00</div>

<?php include('partials/__footer.php'); ?>

<script>
    const selectItems = document.querySelectorAll('input[name="selected_items[]"]');
const selectPayment = document.getElementById('mop');
const totalPriceDisplay = document.getElementById('total');
const quantityInputs = document.querySelectorAll('.quantity-input');

let overallTotal = 0;

// Function to calculate overall total
function calculateOverallTotal() {
    overallTotal = 0;
    selectItems.forEach(item => {
        if(item.checked) {
            const itemPrice = parseFloat(item.dataset.itemPrice);
            const quantityInput = item.closest('tr').querySelector('.quantity-input');
            const quantity = parseInt(quantityInput.value);
            overallTotal += itemPrice * quantity;
        }
    });

    // Display overall total
    totalPriceDisplay.textContent = `Overall Total: $${overallTotal.toFixed(2)}`;
}

// Add event listener to each checkbox
selectItems.forEach(item => {
    item.addEventListener('change', function() {
        // Recalculate overall total when checkbox selection changes
        calculateOverallTotal();
    });
});

// Add event listener to each quantity input
quantityInputs.forEach(input => {
    input.addEventListener('input', function() {
        // Recalculate overall total when quantity changes
        calculateOverallTotal();
        
        // Update price cell with new total price
        const quantity = parseInt(this.value);
        const stockPrice = parseFloat(this.dataset.stockPrice);
        const priceCell = this.parentNode.nextElementSibling;

        // Update price cell with new total price
        const totalPrice = (quantity * stockPrice).toFixed(2);
        priceCell.textContent = totalPrice;
    });
});

// Add event listener to select element
selectPayment.addEventListener('change', function() {
    const selectedPayment = this.value;

    // Perform actions based on selected payment mode (if needed)
});

// Initial calculation of overall total
calculateOverallTotal();

</script>
