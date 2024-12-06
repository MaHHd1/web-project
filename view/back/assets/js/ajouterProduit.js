document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector("#ajoutForm");

    // Fonction pour créer un conteneur d'erreur sous le champ
    function createErrorContainer(inputElement) {
        let errorContainer = inputElement.parentElement.querySelector('.error-message');
        if (!errorContainer) {
            errorContainer = document.createElement('div');
            errorContainer.classList.add('error-message');
            errorContainer.style.color = 'red';
            errorContainer.style.marginTop = '5px'; // Espacement entre le champ et l'erreur
            inputElement.parentElement.appendChild(errorContainer); // Ajouter le conteneur juste après le champ
        }
        return errorContainer;
    }

    // Fonction pour ajouter une erreur à un champ spécifique
    function addError(inputElement, message) {
        const errorContainer = createErrorContainer(inputElement);
        errorContainer.innerHTML = message;
    }

    // Fonction pour enlever l'erreur d'un champ spécifique
    function clearError(inputElement) {
        const errorContainer = inputElement.parentElement.querySelector('.error-message');
        if (errorContainer) {
            errorContainer.innerHTML = ''; // Supprimer l'erreur
        }
    }

    form.addEventListener('submit', (event) => {
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
            addError(document.getElementById('productName'), "Le nom de l'événement doit avoir au moins 3 caractères.");
            isValid = false;
        } else {
            clearError(document.getElementById('productName'));
        }

        // Validation de la description
        if (description.length < 3) {
            addError(document.getElementById('productDescription'), "La description de l'événement doit avoir au moins 3 caractères.");
            isValid = false;
        } else {
            clearError(document.getElementById('productDescription'));
        }

        // Validation du prix/pass
        if (isNaN(pass) || pass <= 0) {
            addError(document.getElementById('productPass'), "Veuillez entrer un pass valide et positif.");
            isValid = false;
        } else {
            clearError(document.getElementById('productPass'));
        }

        // Validation du lieu
        if (lieu.length < 3) {
            addError(document.getElementById('productLieu'), "Le lieu de l'événement doit avoir au moins 3 caractères.");
            isValid = false;
        } else {
            clearError(document.getElementById('productLieu'));
        }

        // Validation de l'image
        if (!image) {
            addError(document.getElementById('productImage'), "Veuillez télécharger une image.");
            isValid = false;
        } else {
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(image.type)) {
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
            addError(document.getElementById('productDate'), "Veuillez entrer une date de début.");
            isValid = false;
        } else if (startDate < today) {
            addError(document.getElementById('productDate'), "La date de début doit être aujourd'hui ou ultérieure.");
            isValid = false;
        } else {
            clearError(document.getElementById('productDate'));
        }

        // Vérification de la date de fin
        if (!datef) {
            addError(document.getElementById('productDatef'), "Veuillez entrer une date de fin.");
            isValid = false;
        } else if (endDate <= startDate) {
            addError(document.getElementById('productDatef'), "La date de fin doit être postérieure à la date de début.");
            isValid = false;
        } else {
            clearError(document.getElementById('productDatef'));
        }

        // Empêcher la soumission du formulaire si des erreurs existent
        if (!isValid) {
            event.preventDefault();
        }
    });
});
