document.addEventListener("DOMContentLoaded", () => {
    const productForm = document.getElementById("addProductForm");
    const productList = document.getElementById("products");

    // Function to render products
    function renderProducts(products) {
        productList.innerHTML = ""; // Clear existing list
        products.forEach((product, index) => {
            const li = document.createElement("li");
            li.innerHTML = `
                ${product.name} - $${product.price.toFixed(2)}
                <button class="delete-btn" data-index="${index}">Remove</button>
            `;
            productList.appendChild(li);
        });
    }

    // Load products from model
    let products = JSON.parse(localStorage.getItem("product-form")) || [];

    // Render products on load
    renderProducts(products);

    // Add a new product
    productForm.addEventListener("submit", (event) => {
        event.preventDefault();

        const name = document.getElementById("productName").value;
        const price = parseFloat(document.getElementById("productPrice").value);

        if (name && price) {
            products.push({ name, price });
            localStorage.setItem("farmnetProducts", JSON.stringify(products));
            renderProducts(products);

            // Clear form
            productForm.reset();
        }
    });

    // Remove a product
    productList.addEventListener("click", (event) => {
        if (event.target.classList.contains("delete-btn")) {
            const index = event.target.dataset.index;
            products.splice(index, 1);
            localStorage.setItem("farmnetProducts", JSON.stringify(products));
            renderProducts(products);
        }
    });
});
document.addEventListener("DOMContentLoaded", () => {
    // Mock data: Replace with dynamic fetch from your backend or local storage
    const products = JSON.parse(localStorage.getItem("farmnetProducts")) || [
        { name: "Tomatoes", price: 2.5, quantity: 100 },
        { name: "Carrots", price: 1.2, quantity: 200 },
        { name: "Apples", price: 3.0, quantity: 150 },
    ];

    // Calculate statistics
    const totalProducts = products.length;
    const topProduct = products.reduce((a, b) => (a.quantity > b.quantity ? a : b), {}).name || "-";
    const totalRevenue = products.reduce((sum, product) => sum + product.price * product.quantity, 0);

    // Update statistics in the UI
    document.getElementById("totalProducts").textContent = totalProducts;
    document.getElementById("topProduct").textContent = topProduct;
    document.getElementById("totalRevenue").textContent = totalRevenue.toFixed(2);

    // Prepare data for the chart
    const productLabels = products.map(product => product.name);
    const productQuantities = products.map(product => product.quantity);

    // Render the chart
    const ctx = document.getElementById("productChart").getContext("2d");
    new Chart(ctx, {
        type: "bar",
        data: {
            labels: productLabels,
            datasets: [
                {
                    label: "Product Quantities",
                    data: productQuantities,
                    backgroundColor: "#28a745",
                    borderColor: "#1e7e34",
                    borderWidth: 1,
                },
            ],
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                },
            },
        },
    });
});

// Export data functionality
function exportData() {
    const products = JSON.parse(localStorage.getItem("farmnetProducts")) || [];
    const dataStr = JSON.stringify(products, null, 2);
    const blob = new Blob([dataStr], { type: "application/json" });
    const url = URL.createObjectURL(blob);

    const a = document.createElement("a");
    a.href = url;
    a.download = "farmnet_products.json";
    a.click();
    URL.revokeObjectURL(url);
}
