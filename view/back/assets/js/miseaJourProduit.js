document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector("#updateFrom");
    const errorContainer = document.createElement('div');
    errorContainer.style.color = 'red';
    form.prepend(errorContainer);
    form.addEventListener('submit', (event) => {
        const name = document.getElementById('productName').value.trim();
        const description = document.getElementById('productDescription').value.trim();
        const pass = document.getElementById('productPass').value;
        const lieu = document.getElementById('productLieu').value;
        let isValid = true;
        let errorMsg = '';
        
        if (name.length < 3) {
            errorMsg += "le nom de l'evenement  doit avoir au moins 3 caractères.<br>";
            isValid = false;
        }
        if (description.length < 3) {
            errorMsg += "le description de l'evenement doit avoir au moins 3 caractères.<br>";
            isValid = false;
        }
        if (isNaN(pass) || pass <= 0) {
            errorMsg += "veuillez entrer un pass valide et positif.<br>";
            isValid = false;
        }
        if (lieu.length < 3) {
            errorMsg += "le lieu de l'evenement  doit avoir au moins 3 caractères.<br>";
            isValid = false;
        }
        if (!isValid) {
            errorContainer.innerHTML = errorMsg;
            event.preventDefault();
        } else {
            errorContainer.innerHTML = ''; 
        }
    });
});
