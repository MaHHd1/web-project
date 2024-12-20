    function confirmDelete() {
        // Ask for confirmation before deleting
        if (confirm('Are you sure you want to delete this product?')) {
            return true; // Proceed with the deletion
        }
        return false; // Cancel the deletion if the user presses "Cancel"
    }
