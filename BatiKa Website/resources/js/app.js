import * as bootstrap from 'bootstrap';
window.bootstrap = bootstrap;

import '../css/app.css';

import Alpine from 'alpinejs';
import gsap from 'gsap';

window.Alpine = Alpine;
window.gsap = gsap;

// Staggered Text Hover Animation
function initTextHoverAnimation() {
    const links = document.querySelectorAll('.hover-split-text');
    
    links.forEach(link => {
        // Prepare structure
        const text = link.innerText.trim(); // Get raw text
        link.innerHTML = ''; // Clear content
        
        // Create container
        const container = document.createElement('div');
        container.style.position = 'relative';
        container.style.overflow = 'hidden'; // Ensure absolute child doesn't increase height/width flow
        container.style.display = 'inline-block';
        container.style.verticalAlign = 'top'; // Align better with icon
        container.style.lineHeight = '1.3'; // Allow even more room for descenders
        container.style.height = '1.3em'; // Match line-height
        container.style.paddingBottom = '0em'; // Remove buffer that might add height
        
        // Create two rows of spans
        const row1 = document.createElement('div');
        const row2 = document.createElement('div');
        
        row1.style.display = 'block';
        
        row2.style.display = 'block';
        row2.style.position = 'absolute';
        row2.style.top = '100%';
        row2.style.left = '0';
        row2.style.width = '100%';
        
        // Split text into spans
        const chars = text.split('');
        
        chars.forEach((char, index) => {
            const span1 = document.createElement('span');
            span1.innerText = char === ' ' ? '\u00A0' : char; // Handle space
            span1.style.display = 'inline-block';
            span1.classList.add('char-1');
            
            const span2 = document.createElement('span');
            span2.innerText = char === ' ' ? '\u00A0' : char;
            span2.style.display = 'inline-block';
            span2.classList.add('char-2');
            
            row1.appendChild(span1);
            row2.appendChild(span2);
        });
        
        container.appendChild(row1);
        container.appendChild(row2);
        link.appendChild(container);

        // Add Event Listeners
        link.addEventListener('mouseenter', () => {
            const char1s = link.querySelectorAll('.char-1');
            const char2s = link.querySelectorAll('.char-2');
            
            char1s.forEach((char1, index) => {
                const char2 = char2s[index];
                const delay = Math.random() * 0.4; // Synchronized random delay
                
                gsap.to(char1, {
                    y: '-100%',
                    duration: 0.5,
                    delay: delay,
                    ease: 'power2.out',
                    overwrite: true
                });
                
                gsap.fromTo(char2, 
                    { y: '0%' }, 
                    {
                        y: '-100%', 
                        duration: 0.5,
                        delay: delay,
                        ease: 'power2.out',
                        overwrite: true
                    }
                );
            });
        });

        link.addEventListener('mouseleave', () => {
             const char1s = link.querySelectorAll('.char-1');
             const char2s = link.querySelectorAll('.char-2');
             
             char1s.forEach((char1, index) => {
                const char2 = char2s[index];
                const delay = Math.random() * 0.4; // Synchronized random delay for exit too
                
                 // Revert
                 gsap.to(char1, {
                     y: '0%',
                     duration: 0.5,
                     delay: delay,
                     ease: 'power2.in',
                     overwrite: true
                 });
                 
                 gsap.to(char2, {
                     y: '0%',
                     duration: 0.5,
                     delay: delay,
                     ease: 'power2.in',
                     overwrite: true
                 });
             });
        });
    });
}

Alpine.start();

// Initialize animation after DOM load (or minimal delay to ensure elements exist)
document.addEventListener('DOMContentLoaded', () => {
    // Wait a tick for any Alpine renders if needed, though navbar is static mostly
    setTimeout(initTextHoverAnimation, 100);
});

// Ambil elemen navbar
    const navbar = document.querySelector('.navbar-glass');

    // Fungsi untuk cek posisi scroll
    function checkScroll() {
        const navbarCollapse = document.getElementById('navbarNav');
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
    // FIX MOBILE: Force solid background when mobile menu is open
    const navbarCollapse = document.getElementById('navbarNav');
    if (navbarCollapse) {
        // Helper to add 'scrolled' class when menu opens
        navbarCollapse.addEventListener('show.bs.collapse', function () {
            navbar.classList.add('scrolled');
        });

        navbarCollapse.addEventListener('shown.bs.collapse', checkScroll);
        navbarCollapse.addEventListener('hidden.bs.collapse', checkScroll);
        
        // Add click listener to close menu when clicking outside
        document.addEventListener('click', function(event) {
             const isClickInside = navbarCollapse.contains(event.target) || 
                                   document.querySelector('.navbar-toggler').contains(event.target);
             
             if (!isClickInside && navbarCollapse.classList.contains('show')) {
                 const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
                 if (bsCollapse) {
                     bsCollapse.hide();
                 }
             }
        });
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