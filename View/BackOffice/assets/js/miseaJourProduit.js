form.addEventListener('submit', (event) => {
    console.log('Form submission triggered');
    
    const name = document.getElementById('productName').value.trim();
    const description = document.getElementById('productDescription').value.trim();
    const pass = parseFloat(document.getElementById('productPass').value.trim());
    const lieu = document.getElementById('productLieu').value;
    const image = document.getElementById('productImage').files[0];
    const date = document.getElementById('productDate').value; // Date de début
    const datef = document.getElementById('productDatef').value; // Date de fin

    let isValid = true;

    // Validation du nom
    if (name.length < 3) {
        console.log('Nom trop court');
        addError(document.getElementById('productName'), "Le nom de l'événement doit avoir au moins 3 caractères.");
        isValid = false;
    } else {
        clearError(document.getElementById('productName'));
    }

    // Validation de la description
    if (description.length < 3) {
        console.log('Description trop courte');
        addError(document.getElementById('productDescription'), "La description de l'événement doit avoir au moins 3 caractères.");
        isValid = false;
    } else {
        clearError(document.getElementById('productDescription'));
    }

    // Validation du prix/pass
    if (isNaN(pass) || pass <= 0) {
        console.log('Pass non valide');
        addError(document.getElementById('productPass'), "Veuillez entrer un pass valide et positif.");
        isValid = false;
    } else {
        clearError(document.getElementById('productPass'));
    }

    // Validation du lieu
    if (lieu.length < 3) {
        console.log('Lieu trop court');
        addError(document.getElementById('productLieu'), "Le lieu de l'événement doit avoir au moins 3 caractères.");
        isValid = false;
    } else {
        clearError(document.getElementById('productLieu'));
    }

    // Validation de l'image
    if (!image) {
        console.log('Aucune image téléchargée');
        addError(document.getElementById('productImage'), "Veuillez télécharger une image.");
        isValid = false;
    } else {
        const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!allowedTypes.includes(image.type)) {
            console.log('Image de type incorrect');
            addError(document.getElementById('productImage'), "Seules les images JPEG, PNG ou GIF sont autorisées.");
            isValid = false;
        } else {
            clearError(document.getElementById('productImage'));
        }
    }

    // Validation des dates
    const today = new Date();
    today.setHours(0, 0, 0, 0); // Réinitialiser l'heure à 00:00:00 pour la comparaison

    // Convertir les dates (input[type="date"]) en objets Date
    const startDate = new Date(date);
    const endDate = new Date(datef);

    // Vérification de la date de début
    if (!date) {
        console.log('Date de début manquante');
        addError(document.getElementById('productDate'), "Veuillez entrer une date de début.");
        isValid = false;
    } else if (startDate < today) {
        console.log('Date de début trop ancienne');
        addError(document.getElementById('productDate'), "La date de début doit être aujourd'hui ou ultérieure.");
        isValid = false;
    } else {
        clearError(document.getElementById('productDate'));
    }

    // Vérification de la date de fin
    if (!datef) {
        console.log('Date de fin manquante');
        addError(document.getElementById('productDatef'), "Veuillez entrer une date de fin.");
        isValid = false;
    } else if (endDate <= startDate) {
        console.log('Date de fin trop proche');
        addError(document.getElementById('productDatef'), "La date de fin doit être postérieure à la date de début.");
        isValid = false;
    } else {
        clearError(document.getElementById('productDatef'));
    }

    // Empêcher la soumission du formulaire si des erreurs existent
    if (!isValid) {
        console.log('Formulaire non soumis');
        event.preventDefault();
    }
});
