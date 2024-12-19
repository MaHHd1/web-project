document.addEventListener("DOMContentLoaded", () => {
    const cart = [];
    const cartModal = document.getElementById("cart-modal");
    const cartItemsContainer = document.getElementById("cart-items");
    const cartTotal = document.getElementById("cart-total");
    const closeCartModalBtn = document.getElementById("close-cart-modal");
    const cartIcon = document.getElementById("cart-icon"); // Select the Cart Icon

    // Open Cart Modal
    function openCartModal() {
        if (cartModal) {
            updateCartModal();
            cartModal.style.display = "block";
            document.body.style.overflow = "hidden"; // Disable background scrolling
        }
    }

    // Close Cart Modal
    function closeCartModal() {
        if (cartModal) {
            cartModal.style.display = "none";
            document.body.style.overflow = ""; // Restore scrolling
        }
    }

    // Add event listener for the Cart Icon
    if (cartIcon) {
        cartIcon.addEventListener("click", openCartModal);
    }

    // Add event listener for the Close button
    if (closeCartModalBtn) {
        closeCartModalBtn.addEventListener("click", closeCartModal);
    }

    // Add Product to Cart
    document.querySelectorAll(".add-to-cart-btn").forEach((button) => {
        button.addEventListener("click", () => {
            const id = button.dataset.id;
            const name = button.dataset.name;
            const price = parseFloat(button.dataset.price);
            const image = button.dataset.image;

            // Check if item is already in the cart
            const existingItem = cart.find((item) => item.id === id);
            if (existingItem) {
                existingItem.quantity++;
            } else {
                cart.push({ id, name, price, image, quantity: 1 });
            }

            // Open cart modal after adding product
            openCartModal();
        });
    });

    // Update Cart Modal
    function updateCartModal() {
        if (!cartItemsContainer || !cartTotal) return;

        cartItemsContainer.innerHTML = "";
        let total = 0;

        cart.forEach((item) => {
            total += item.price * item.quantity;
            cartItemsContainer.innerHTML += `
                <div class="cart-item">
                    <img src="${item.image}" alt="${item.name}" width="50" height="50">
                    <span>${item.name}</span>
                    <span>$${item.price}</span>
                    <span>Quantity: ${item.quantity}</span>
                </div>
            `;
        });

        cartTotal.innerHTML = `Total: $${total.toFixed(2)}`;
    }

    const openCartButton = document.getElementById('open-cart');
    if (openCartButton) {
        openCartButton.addEventListener('click', function () {
            window.location.href = 'Cart.php';
        });
    }
});
    