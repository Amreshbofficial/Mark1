<?php
$pageTitle = "Shopping Cart";
require_once 'includes/config.php';
require_once 'includes/header.php';
require_login();
?>

<section class="cart-section">
    <h1>Your Shopping Cart</h1>
    <?php if (empty($_SESSION['cart'])) : ?>
        <div class="empty-cart">
            <i class="fas fa-shopping-cart"></i>
            <h3>Your cart is empty</h3>
            <p>Browse our products and add items to your cart</p>
            <a href="index.php" class="btn-primary">Continue Shopping</a>
        </div>
    <?php else : ?>
        <div class="cart-items">
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0;
                    foreach ($_SESSION['cart'] as $id => $item) : 
                        $subtotal = $item['price'] * $item['quantity'];
                        $total += $subtotal;
                    ?>
                    <tr>
                        <td class="product-info">
                            <img src="/assets/images/products/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                            <div>
                                <h4><?= htmlspecialchars($item['name']) ?></h4>
                                <p>SKU: <?= htmlspecialchars($item['sku']) ?></p>
                            </div>
                        </td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td>
                            <div class="quantity-selector">
                                <button class="quantity-btn minus" data-id="<?= htmlspecialchars($id) ?>">-</button>
                                <input type="number" value="<?= (int)$item['quantity'] ?>" min="1" class="cart-quantity" data-id="<?= htmlspecialchars($id) ?>">
                                <button class="quantity-btn plus" data-id="<?= htmlspecialchars($id) ?>">+</button>
                            </div>
                        </td>
                        <td>$<?= number_format($subtotal, 2) ?></td>
                        <td>
                            <button class="remove-item" data-id="<?= htmlspecialchars($id) ?>">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="cart-summary">
            <div class="summary-card">
                <h3>Order Summary</h3>
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>$<?= number_format($total, 2) ?></span>
                </div>
                <div class="summary-row">
                    <span>Shipping</span>
                    <span>$<?= number_format(($total > 50 ? 0 : 5.99), 2) ?></span>
                </div>
                <div class="summary-row total">
                    <span>Total</span>
                    <span>$<?= number_format($total + ($total > 50 ? 0 : 5.99), 2) ?></span>
                </div>
                <a href="checkout.php" class="btn-primary checkout-btn">Proceed to Checkout</a>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php require_once 'includes/footer.php'; ?>