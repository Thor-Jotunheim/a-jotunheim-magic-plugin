// File: assets/js/dark-mode-toggle.js

document.addEventListener('DOMContentLoaded', () => {
    const darkModeToggle = document.getElementById('dark-mode-toggle');
    const darkModeClass = 'dark-mode';
    const pricelistSections = document.querySelectorAll('.pricelist-section'); // Adjust this to match pricelist container
    const frontPageSections = document.querySelectorAll('.front-page-section'); // Adjust for front page content
    
    // Apply dark mode if previously enabled
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add(darkModeClass);
        pricelistSections.forEach(section => section.classList.add(darkModeClass));
        frontPageSections.forEach(section => section.classList.add(darkModeClass));
    }

    // Toggle dark mode on button click
    darkModeToggle.addEventListener('click', () => {
        const isDarkMode = document.body.classList.toggle(darkModeClass);
        
        pricelistSections.forEach(section => section.classList.toggle(darkModeClass, isDarkMode));
        frontPageSections.forEach(section => section.classList.toggle(darkModeClass, isDarkMode));
        
        localStorage.setItem('darkMode', isDarkMode ? 'enabled' : 'disabled');
    });
});