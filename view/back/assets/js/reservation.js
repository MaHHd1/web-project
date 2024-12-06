document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('reservationForm');
    const formErrors = document.getElementById('formErrors');

    // Fonction pour afficher une erreur sous un champ
    function showError(input, message) {
        let errorContainer = input.parentElement.querySelector('.error-message');
        if (!errorContainer) {
            errorContainer = document.createElement('div');
            errorContainer.classList.add('error-message');
            errorContainer.style.color = 'red';
            errorContainer.style.marginTop = '5px';
            input.parentElement.appendChild(errorContainer);
        }
        errorContainer.textContent = message;
    }

    // Fonction pour effacer une erreur d'un champ
    function clearError(input) {
        const errorContainer = input.parentElement.querySelector('.error-message');
        if (errorContainer) {
            errorContainer.textContent = '';
        }
    }

    // Validation de chaque champ
    function validateForm() {
        let isValid = true;
        formErrors.textContent = ''; // Réinitialiser les erreurs générales

        // Valider le nom
        const nom = document.getElementById('nom_p');
        if (nom.value.trim().length < 3) {
            showError(nom, 'Le nom doit contenir au moins 3 caractères.');
            isValid = false;
        } else {
            clearError(nom);
        }

        // Valider le numéro de téléphone
        const numero = document.getElementById('numero');
        const phoneRegex = /^(\+?\d{1,3}[- ]?)?\d{10}$/; // Numéro à 10 chiffres avec ou sans indicatif
        if (!phoneRegex.test(numero.value.trim())) {
            showError(numero, 'Entrez un numéro de téléphone valide (10 chiffres).');
            isValid = false;
        } else {
            clearError(numero);
        }

        // Valider l'email
        const mail = document.getElementById('mail');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; // Simple vérification de format d'email
        if (!emailRegex.test(mail.value.trim())) {
            showError(mail, 'Entrez une adresse email valide.');
            isValid = false;
        } else {
            clearError(mail);
        }

        // Valider la quantité
        const quantite = document.getElementById('quantite');
        const quantiteValue = parseInt(quantite.value.trim(), 10);
        if (isNaN(quantiteValue) || quantiteValue <= 0) {
            showError(quantite, 'Entrez une quantité valide et positive.');
            isValid = false;
        } else {
            clearError(quantite);
        }

        return isValid;
    }

    // Gérer la soumission du formulaire
    form.addEventListener('submit', function (event) {
        if (!validateForm()) {
            event.preventDefault(); // Empêche la soumission si le formulaire est invalide
            formErrors.textContent = 'Veuillez corriger les erreurs avant de soumettre le formulaire.';
        }
    });
});
