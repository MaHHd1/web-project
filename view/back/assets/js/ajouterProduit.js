document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector("#ajoutForm");
    // laffichage des messages d'erreur au debut de formulaire
    const errorContainer = document.createElement('div');
    errorContainer.style.color = 'red';
    form.prepend(errorContainer);
    form.addEventListener('submit', (event) => {
        const name = document.getElementById('productName').value.trim();
        const description = document.getElementById('productDescription').value.trim();
        const price = document.getElementById('productPrice').value;
        const image = document.getElementById('productImage').files[0];
        let isValid = true;
        let errorMsg = '';
        
        if (name.length < 3) {
            errorMsg += "le nom du produit doit avoir au moins 3 caractères.<br>";
            isValid = false;
        }
        if (description.length < 3) {
            errorMsg += "le description du produit doit avoir au moins 3 caractères.<br>";
            isValid = false;
        }
        //le prix soit un nombre valide et supp a 0
        if (isNaN(price) || price <= 0) {
            errorMsg += "veuillez entrer un prix valide et positif.<br>";
            isValid = false;
        }
        if (!image) {
            //verification de telechargement de photo
            errorMsg += "veuillez télécharger une image.<br>";
            isValid = false;
        } else {
            //verification de type de limage
            const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!allowedTypes.includes(image.type)) {
                errorMsg += "seules les images JPEG, PNG ou GIF sont autorisées.<br>";
                isValid = false;
            }
        }
        if (!isValid) {
            //si ilya des erreurs affixhe un message et empeche la soumission
            errorContainer.innerHTML = errorMsg;
            event.preventDefault();
        } else {
            errorContainer.innerHTML = ''; 
        }
    });
});
