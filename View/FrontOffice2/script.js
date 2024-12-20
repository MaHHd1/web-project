// DOM Elements
const navbarMenu = document.querySelector(".navbar .links");
const hamburgerBtn = document.querySelector(".hamburger-btn");
const hideMenuBtn = navbarMenu.querySelector(".close-btn");
const showPopupBtn = document.querySelector(".login-btn");
const formPopup = document.querySelector(".form-popup");
const hidePopupBtn = formPopup.querySelector(".close-btn");
const signupLoginLink = formPopup.querySelectorAll(".bottom-link a");
const loginForm = document.querySelector(".form-box.login form");
const signupForm = document.querySelector(".form-box.signup form");

// Show mobile menu
hamburgerBtn.addEventListener("click", () => {
    navbarMenu.classList.toggle("show-menu");
});

// Hide mobile menu
hideMenuBtn.addEventListener("click", () => {
    navbarMenu.classList.remove("show-menu");
});

// Show login popup
showPopupBtn.addEventListener("click", () => {
    document.body.classList.add("show-popup");
    trapFocus(formPopup);
});

// Hide login popup
hidePopupBtn.addEventListener("click", () => {
    document.body.classList.remove("show-popup");
    resetFormsAndErrors();
});

// Toggle between login and signup forms
signupLoginLink.forEach(link => {
    link.addEventListener("click", (e) => {
        e.preventDefault();
        formPopup.classList.toggle("show-signup", link.id === 'signup-link');
    });
});

// Form Validation


// Reset forms and error messages
function resetFormsAndErrors() {
    loginForm.reset();
    signupForm.reset();
    document.querySelectorAll(".error-message").forEach(message => {
        message.textContent = "";
    });
}

// Prevent duplicate submissions
function preventDoubleSubmission(form) {
    form.addEventListener("submit", () => {
        const submitButton = form.querySelector("button[type='submit']");
        submitButton.disabled = true;
        submitButton.textContent = "Submitting...";
    });
}

// Apply validation and prevent default if invalid



// Accessibility: Focus trapping
function trapFocus(popup) {
    const focusableElements = popup.querySelectorAll("button, input, a, [tabindex='0']");
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];

    popup.addEventListener("keydown", (e) => {
        if (e.key === "Tab") {
            if (e.shiftKey && document.activeElement === firstElement) {
                e.preventDefault();
                lastElement.focus();
            } else if (!e.shiftKey && document.activeElement === lastElement) {
                e.preventDefault();
                firstElement.focus();
            }
        }
    });
}

// Smooth scrolling for internal links
document.querySelectorAll("a[href^='#']").forEach(anchor => {
    anchor.addEventListener("click", (e) => {
        e.preventDefault();
        document.querySelector(anchor.getAttribute("href")).scrollIntoView({
            behavior: "smooth"
        });
    });
});