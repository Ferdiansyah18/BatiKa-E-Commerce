import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import '../css/app.css';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// Ambil elemen navbar
    const navbar = document.querySelector('.navbar-glass');

    // Fungsi untuk cek posisi scroll
    function checkScroll() {
        const navbarCollapse = document.getElementById('navbarText');
        const isMenuOpen = navbarCollapse && navbarCollapse.classList.contains('show');

        if (window.scrollY > 50 || isMenuOpen) { 
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }

    // Jalankan saat halaman di-scroll
    window.addEventListener('scroll', checkScroll);
    
    // Jalankan juga saat halaman pertama kali dimuat (antisipasi jika di-refresh saat posisi bawah)
    document.addEventListener('DOMContentLoaded', checkScroll);

    // FIX MOBILE: Force solid background when mobile menu is open
    const navbarCollapse = document.getElementById('navbarText');
    if (navbarCollapse) {
        navbarCollapse.addEventListener('show.bs.collapse', function () {
            // Need a slight delay or just add class directly to be safe, 
            // but checkScroll logic now handles the 'show' class check.
            // However, the 'show' class is added during transition, so we might want to force it immediately.
            navbar.classList.add('scrolled'); 
        });

        navbarCollapse.addEventListener('shown.bs.collapse', checkScroll); // Re-check after animation
        navbarCollapse.addEventListener('hidden.bs.collapse', checkScroll); // Re-check after close
    }

// Quantity Selector

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.quantity-selector').forEach(function (wrapper) {
        const input = wrapper.querySelector('.qty-input');
        const btnPlus = wrapper.querySelector('.btn-increase');
        const btnMinus = wrapper.querySelector('.btn-decrease');

        const min = parseInt(wrapper.dataset.min);
        const max = parseInt(wrapper.dataset.max);

        function clamp(value) {
            return Math.max(min, Math.min(max, value));
        }

        btnPlus.addEventListener('click', function () {
            input.value = clamp(parseInt(input.value || min) + 1);
        });

        btnMinus.addEventListener('click', function () {
            input.value = clamp(parseInt(input.value || min) - 1);
        });

        input.addEventListener('change', function () {
            input.value = clamp(parseInt(input.value || min));
        });
    });
});