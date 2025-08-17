// resources/js/app.js
import './bootstrap';
import '../css/app.css';
import Swal from 'sweetalert2';
import { gsap } from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';
import { ScrollToPlugin } from 'gsap/ScrollToPlugin';

// Register GSAP plugins
gsap.registerPlugin(ScrollTrigger, ScrollToPlugin);

// Make it available globally
window.Swal = Swal;
window.gsap = gsap;
window.ScrollTrigger = ScrollTrigger;
window.ScrollToPlugin = ScrollToPlugin;

// Ensure GSAP is ready before any scripts try to use it
document.addEventListener('DOMContentLoaded', function() {
    // Double-check that GSAP is available
    if (typeof window.gsap === 'undefined') {
        console.error('GSAP not loaded properly');
        return;
    }
    
    if (typeof window.ScrollTrigger === 'undefined') {
        console.error('ScrollTrigger not loaded properly');
        return;
    }
    
    console.log('GSAP and plugins loaded successfully');
});

