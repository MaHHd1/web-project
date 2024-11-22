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
hideMenuBtn.addEventListener("click", () => hamburgerBtn.click());

// Show login popup
showPopupBtn.addEventListener("click", () => {
    document.body.classList.toggle("show-popup");
    trapFocus(formPopup);
});

// Hide login popup
hidePopupBtn.addEventListener("click", () => {
    showPopupBtn.click();
    loginForm.reset();
    signupForm.reset();
    clearErrorMessages();
});

// Show or hide signup form
signupLoginLink.forEach(link => {
    link.addEventListener("click", (e) => {
        e.preventDefault();
        formPopup.classList[link.id === 'signup-link' ? 'add' : 'remove']("show-signup");
    });
});

// Form Validation
function validateForm(form) {
    const email = form.querySelector("input[name='email']").value.trim();
    const password = form.querySelector("input[name='password']").value.trim();
    const errorMessage = form.querySelector(".error-message");

    // Simple validation checks
    if (!email || !password) {
        if (errorMessage) errorMessage.textContent = "All fields are required.";
        return false;
    }
    if (!/\S+@\S+\.\S+/.test(email)) {
        if (errorMessage) errorMessage.textContent = "Invalid email format.";
        return false;
    }
    if (password.length < 6) {
        if (errorMessage) errorMessage.textContent = "Password must be at least 6 characters.";
        return false;
    }
    if (errorMessage) errorMessage.textContent = ""; // Clear errors if valid
    return true;
}

// Prevent double submissions
function preventDoubleSubmission(form) {
    form.addEventListener("submit", () => {
        const submitButton = form.querySelector("button[type='submit']");
        submitButton.disabled = true;
        submitButton.textContent = "Submitting...";
    });
}

// Clear error messages
function clearErrorMessages() {
    document.querySelectorAll(".error-message").forEach(message => {
        message.textContent = "";
    });
}

// Apply validation and submission protection
loginForm.addEventListener("submit", (e) => {
    if (!validateForm(loginForm)) e.preventDefault();
});
signupForm.addEventListener("submit", (e) => {
    if (!validateForm(signupForm)) e.preventDefault();
});

preventDoubleSubmission(loginForm);
preventDoubleSubmission(signupForm);

// Accessibility: Focus Trapping
function trapFocus(popup) {
    const focusableElements = popup.querySelectorAll("button, input, a, [tabindex='0']");
    const firstElement = focusableElements[0];
    const lastElement = focusableElements[focusableElements.length - 1];

    popup.addEventListener("keydown", (e) => {
        if (e.key === "Tab") {
            if (e.shiftKey) { // Shift + Tab
                if (document.activeElement === firstElement) {
                    e.preventDefault();
                    lastElement.focus();
                }
            } else { // Tab
                if (document.activeElement === lastElement) {
                    e.preventDefault();
                    firstElement.focus();
                }
            }
        }
    });
}

// Clear inputs and error messages when popup is hidden
hidePopupBtn.addEventListener("click", () => {
    loginForm.reset();
    signupForm.reset();
    clearErrorMessages();
});

// Smooth Scrolling for Internal Links
document.querySelectorAll("a[href^='#']").forEach(anchor => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute("href")).scrollIntoView({
            behavior: "smooth"
        });
    });
});
