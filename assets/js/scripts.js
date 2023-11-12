// assets/js/scripts.js - JavaScript for the application

document.addEventListener('DOMContentLoaded', function () {
    // Responsive Navigation Menu Toggle
    const menuToggle = document.getElementById('menu-toggle');
    const navList = document.querySelector('nav ul');

    menuToggle.addEventListener('click', function () {
        navList.classList.toggle('show');
    });

    // Confirm Delete Repository
    const deleteRepoLinks = document.querySelectorAll('.delete-repo');

    deleteRepoLinks.forEach(link => {
        link.addEventListener('click', function (event) {
            const confirmDelete = confirm('Are you sure you want to delete this repository?');

            if (!confirmDelete) {
                event.preventDefault();
            }
        });
    });
});
