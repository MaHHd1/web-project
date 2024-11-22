
document.getElementById("addProductForm").addEventListener("submit", function (e) {
    e.preventDefault();

    // Get product details from form
    const productName = document.getElementById("productName").value.trim();
    const productPrice = parseFloat(document.getElementById("productPrice").value);

    if (!productName || isNaN(productPrice) || productPrice <= 0) {
        alert("Please provide valid product details.");
        return;
    }

    // Fetch existing products from localStorage
    const products = JSON.parse(localStorage.getItem("farmnetProducts")) || [];

    // Add the new product
    products.push({ name: productName, price: productPrice, quantity: 0 }); // Default quantity is 0 for now
    localStorage.setItem("farmnetProducts", JSON.stringify(products));

    // Update the product list in the back office
    updateProductList();

    // Clear form fields
    document.getElementById("addProductForm").reset();
    alert("Product added successfully!");
});

// Function to update the product list dynamically
function updateProductList() {
    const productList = document.getElementById("products");
    const products = JSON.parse(localStorage.getItem("farmnetProducts")) || [];

    // Clear current list
    productList.innerHTML = "";

    // Add each product to the list
    products.forEach((product, index) => {
        const productItem = document.createElement("li");
        productItem.textContent = `${product.name} - $${product.price.toFixed(2)}`;
        productList.appendChild(productItem);
    });
}

// Initialize product list on page load
document.addEventListener("DOMContentLoaded", updateProductList);

document.addEventListener("DOMContentLoaded", () => {
    const productList = document.getElementById("featuredProductGrid");

    // Fetch products from localStorage
    const products = JSON.parse(localStorage.getItem("farmnetProducts")) || [];

    // Display each product
    products.forEach(product => {
        const productCard = document.createElement("div");
        productCard.classList.add("product");
        productCard.innerHTML = `
            <h3>${product.name}</h3>
            <p>Price: $${product.price.toFixed(2)}</p>
            <button>Buy Now</button>
        `;
        productList.appendChild(productCard);
    });
});
//remove product

// Function to update the product list dynamically
function updateProductList() {
    const productList = document.getElementById("products");
    const products = JSON.parse(localStorage.getItem("farmnetProducts")) || [];

    // Clear current list
    productList.innerHTML = "";

    // Add each product to the list
    products.forEach((product, index) => {
        const productItem = document.createElement("li");
        productItem.innerHTML = `
            ${product.name} - $${product.price.toFixed(2)}
            <button class="remove-btn" data-index="${index}">Remove</button>
        `;
        productList.appendChild(productItem);
    });

    // Add event listeners to remove buttons
    document.querySelectorAll(".remove-btn").forEach(button => {
        button.addEventListener("click", function () {
            const index = parseInt(this.dataset.index, 10);
            removeProduct(index);
        });
    });
}

// Function to remove a product
function removeProduct(index) {
    const products = JSON.parse(localStorage.getItem("farmnetProducts")) || [];
    products.splice(index, 1); // Remove the product at the specified index
    localStorage.setItem("farmnetProducts", JSON.stringify(products));
    updateProductList(); // Refresh the product list
    alert("Product removed successfully!");
}

// Initialize product list on page load
document.addEventListener("DOMContentLoaded", updateProductList);

document.getElementById('addProductForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent page reload on form submission

    // Get input field values
    const name = document.getElementById('productName').value;
    const price = document.getElementById('productPrice').value;
    const quantity = document.getElementById('productQuantity').value;
    const image = document.getElementById('productImage').value;

    // Validate input (ensure quantity is a positive number)
    if (quantity < 1) {
        alert("Quantity must be at least 1.");
        return;
    }

    // Create a new product card dynamically
    const productGrid = document.getElementById('product-grid'); // Assume this is where products are displayed
    const productCard = document.createElement('div');
    productCard.classList.add('product-card');
    
    productCard.innerHTML = `
        <img src="${image}" alt="${name}">
        <div class="product-info">
            <h3>${name}</h3>
            <p>Price: $${price}</p>
            <p>Quantity: ${quantity}</p>
            <button class="remove-btn">Remove</button>
        </div>
    `;

    // Append the new product to the grid
    productGrid.appendChild(productCard);

    // Clear the form fields after submission
    document.getElementById('addProductForm').reset();
});

