// DOM Content Loaded
document.addEventListener("DOMContentLoaded", function () {
  // Add to cart functionality
  document.querySelectorAll(".add-to-cart").forEach((button) => {
    button.addEventListener("click", function () {
      const productId = this.dataset.id;
      const quantity =
        this.closest(".product-actions")?.querySelector("#quantity")?.value ||
        1;

      fetch("/cart/add.php", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ productId, quantity }),
      })
        .then((response) => response.json())
        .then((data) => {
          if (data.success) {
            // Show success animation
            const cartBtn = document.querySelector(
              ".user-actions .fa-shopping-cart"
            );
            cartBtn.classList.add("pulse");

            // Update cart count
            updateCartCount(data.cartCount);

            // Remove animation after delay
            setTimeout(() => {
              cartBtn.classList.remove("pulse");
            }, 1500);
          }
        });
    });
  });

  // Wishlist functionality
  document
    .querySelectorAll(".add-to-wishlist, .wishlist-btn")
    .forEach((button) => {
      button.addEventListener("click", function () {
        const productId = this.dataset.id;

        fetch("/wishlist/toggle.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({ productId }),
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              const icon = this.querySelector("i");
              if (icon) {
                if (data.isAdded) {
                  icon.classList.remove("far");
                  icon.classList.add("fas", "animate__heartBeat");
                } else {
                  icon.classList.remove("fas", "animate__heartBeat");
                  icon.classList.add("far");
                }
              }
            }
          });
      });
    });

  // Cart quantity controls
  document.querySelectorAll(".quantity-btn").forEach((button) => {
    button.addEventListener("click", function () {
      const input = this.parentElement.querySelector("input");
      let value = parseInt(input.value);

      if (this.classList.contains("minus")) {
        value = Math.max(1, value - 1);
      } else {
        value = value + 1;
      }

      input.value = value;

      // If it's in cart, update quantity
      if (this.closest(".cart-item")) {
        updateCartItem(this.dataset.id, value);
      }
    });
  });
});

// Update cart count in UI
function updateCartCount(count) {
  const cartCount = document.querySelector(".cart-count");
  if (cartCount) {
    cartCount.textContent = count;
  } else {
    // Create cart count if doesn't exist
    const cartIcon = document.querySelector(".fa-shopping-cart");
    if (cartIcon) {
      const countBadge = document.createElement("span");
      countBadge.className = "cart-count";
      countBadge.textContent = count;
      cartIcon.parentElement.appendChild(countBadge);
    }
  }
}

// Update cart item quantity
function updateCartItem(productId, quantity) {
  fetch("/cart/update.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ productId, quantity }),
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        // Update subtotal in UI
        const row = document.querySelector(`tr[data-id="${productId}"]`);
        if (row) {
          const price = parseFloat(row.dataset.price);
          const subtotal = price * quantity;
          row.querySelector(".subtotal").textContent = `$${subtotal.toFixed(
            2
          )}`;

          // Update total
          updateCartTotal();
        }
      }
    });
}
