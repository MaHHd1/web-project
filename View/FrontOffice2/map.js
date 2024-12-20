// Initialize the map when the DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    var map = L.map('map').setView([51.505, -0.09], 13); // Initial coordinates, adjust as needed

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Add a marker at the center coordinates
    L.marker([51.505, -0.09]).addTo(map)
        .bindPopup("You are here.")
        .openPopup();
});
