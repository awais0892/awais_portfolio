
class FuturisticAdminUI {
    constructor() {
        this.init();
    }

    init() {
        this.setupGSAP();
        this.initializeAnimations();
        this.setupEventListeners();
        this.createParticleSystem();
    }

    setupGSAP() {
        gsap.registerPlugin(ScrollTrigger, TextPlugin, MorphSVGPlugin);
        gsap.defaults({ ease: "power2.out" });
    }

    initializeAnimations() {
        this.animatePageLoad();
        this.animateButtons();
        this.animateCards();
        this.animateTables();
        this.animateForms();
        this.animateNavigation();
    }

    animatePageLoad() {
        // Master timeline for page load
        const pageLoadTL = gsap.timeline();
        
        // Animate background elements
        pageLoadTL.fromTo("body", 
            { backgroundColor: "#000000" },
            { backgroundColor: "#0a0a0f", duration: 1.5, ease: "power2.inOut" }
        );

        // Animate header elements with stagger
        pageLoadTL.fromTo(".page-header, .section-header", 
            { 
                y: -50, 
                opacity: 0, 
                scale: 0.9,
                rotationX: -15
            },
            { 
                y: 0, 
                opacity: 1, 
                scale: 1,
                rotationX: 0,
                duration: 1.2,
                stagger: 0.2,
                ease: "back.out(1.7)"
            },
            "-=0.5"
        );

        // Animate content cards with advanced effects
        pageLoadTL.fromTo(".card-futuristic, .glass-card", 
            { 
                y: 100, 
                opacity: 0, 
                scale: 0.8,
                rotationY: -20,
                filter: "blur(10px)"
            },
            { 
                y: 0, 
                opacity: 1, 
                scale: 1,
                rotationY: 0,
                filter: "blur(0px)",
                duration: 1.5,
                stagger: 0.15,
                ease: "power3.out"
            },
            "-=0.8"
        );

        // Animate buttons with neon effect
        pageLoadTL.fromTo(".btn-futuristic", 
            { 
                scale: 0, 
                rotation: 180,
                opacity: 0
            },
            { 
                scale: 1, 
                rotation: 0,
                opacity: 1,
                duration: 1,
                stagger: 0.1,
                ease: "elastic.out(1, 0.5)"
            },
            "-=0.5"
        );

        // Add floating animation to specific elements
        this.addFloatingAnimation();
    }

    animateButtons() {
        // Advanced button hover animations
        const buttons = document.querySelectorAll('.btn-futuristic');
        
        buttons.forEach(button => {
            // Create hover timeline
            const hoverTL = gsap.timeline({ paused: true });
            
            // Scale and glow effect
            hoverTL.to(button, {
                scale: 1.05,
                duration: 0.3,
                ease: "power2.out"
            });
            
            // Add neon glow
            hoverTL.to(button, {
                boxShadow: "0 0 30px rgba(0, 245, 255, 0.6), 0 0 60px rgba(0, 245, 255, 0.4)",
                duration: 0.3,
                ease: "power2.out"
            }, "-=0.3");

            // Add click animation
            const clickTL = gsap.timeline({ paused: true });
            clickTL.to(button, {
                scale: 0.95,
                duration: 0.1,
                ease: "power2.in"
            });
            clickTL.to(button, {
                scale: 1,
                duration: 0.2,
                ease: "elastic.out(1, 0.5)"
            });

            // Event listeners
            button.addEventListener('mouseenter', () => hoverTL.play());
            button.addEventListener('mouseleave', () => hoverTL.reverse());
            button.addEventListener('click', () => clickTL.play());
        });
    }

    animateCards() {
        // Advanced card animations with 3D effects
        const cards = document.querySelectorAll('.card-futuristic, .glass-card');
        
        cards.forEach((card, index) => {
            // Add 3D perspective
            gsap.set(card, { 
                transformStyle: "preserve-3d",
                transformPerspective: 1000
            });

            // Hover animation
            card.addEventListener('mouseenter', () => {
                gsap.to(card, {
                    rotationY: 5,
                    rotationX: 2,
                    scale: 1.02,
                    duration: 0.6,
                    ease: "power2.out"
                });
            });

            card.addEventListener('mouseleave', () => {
                gsap.to(card, {
                    rotationY: 0,
                    rotationX: 0,
                    scale: 1,
                    duration: 0.6,
                    ease: "power2.out"
                });
            });

            // Add entrance animation delay
            gsap.set(card, { 
                opacity: 0, 
                y: 50,
                scale: 0.9
            });

            gsap.to(card, {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 1,
                delay: index * 0.1,
                ease: "back.out(1.7)"
            });
        });
    }

    animateTables() {
        // Advanced table row animations
        const tableRows = document.querySelectorAll('tbody tr');
        
        tableRows.forEach((row, index) => {
            // Set initial state
            gsap.set(row, { 
                opacity: 0, 
                x: -50,
                scale: 0.95
            });

            // Animate in with stagger
            gsap.to(row, {
                opacity: 1,
                x: 0,
                scale: 1,
                duration: 0.8,
                delay: index * 0.05,
                ease: "power2.out"
            });

            // Hover effect
            row.addEventListener('mouseenter', () => {
                gsap.to(row, {
                    backgroundColor: "rgba(0, 245, 255, 0.1)",
                    scale: 1.01,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });

            row.addEventListener('mouseleave', () => {
                gsap.to(row, {
                    backgroundColor: "transparent",
                    scale: 1,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });
        });
    }

    animateForms() {
        // Advanced form animations
        const formInputs = document.querySelectorAll('.input-futuristic, input, textarea, select');
        
        formInputs.forEach((input, index) => {
            // Set initial state
            gsap.set(input, { 
                opacity: 0, 
                y: 20,
                scale: 0.95
            });

            // Animate in
            gsap.to(input, {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 0.6,
                delay: index * 0.1,
                ease: "back.out(1.7)"
            });

            // Focus animation
            input.addEventListener('focus', () => {
                gsap.to(input, {
                    scale: 1.02,
                    boxShadow: "0 0 25px rgba(0, 245, 255, 0.4)",
                    duration: 0.3,
                    ease: "power2.out"
                });
            });

            input.addEventListener('blur', () => {
                gsap.to(input, {
                    scale: 1,
                    boxShadow: "0 0 20px rgba(0, 245, 255, 0.2)",
                    duration: 0.3,
                    ease: "power2.out"
                });
            });
        });
    }

    animateNavigation() {
        // Advanced navigation animations
        const navItems = document.querySelectorAll('.nav-link-futuristic, nav a');
        
        navItems.forEach((item, index) => {
            // Set initial state
            gsap.set(item, { 
                opacity: 0, 
                y: -20,
                scale: 0.9
            });

            // Animate in with stagger
            gsap.to(item, {
                opacity: 1,
                y: 0,
                scale: 1,
                duration: 0.8,
                delay: index * 0.1,
                ease: "back.out(1.7)"
            });

            // Hover effect
            item.addEventListener('mouseenter', () => {
                gsap.to(item, {
                    y: -5,
                    scale: 1.05,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });

            item.addEventListener('mouseleave', () => {
                gsap.to(item, {
                    y: 0,
                    scale: 1,
                    duration: 0.3,
                    ease: "power2.out"
                });
            });
        });
    }

    addFloatingAnimation() {
        // Add floating animation to specific elements
        const floatingElements = document.querySelectorAll('.floating-element, .animate-float');
        
        floatingElements.forEach(element => {
            gsap.to(element, {
                y: -10,
                duration: 2,
                ease: "power1.inOut",
                yoyo: true,
                repeat: -1
            });
        });
    }

    createParticleSystem() {
        // Create futuristic particle system
        this.createParticles();
        this.animateParticles();
    }

    createParticles() {
        const particleContainer = document.createElement('div');
        particleContainer.className = 'particle-container';
        particleContainer.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -1;
            overflow: hidden;
        `;
        document.body.appendChild(particleContainer);

        // Create particles
        for (let i = 0; i < 50; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.cssText = `
                position: absolute;
                width: 2px;
                height: 2px;
                background: rgba(0, 245, 255, 0.6);
                border-radius: 50%;
                pointer-events: none;
            `;
            particleContainer.appendChild(particle);
        }
    }

    animateParticles() {
        const particles = document.querySelectorAll('.particle');
        
        particles.forEach((particle, index) => {
            // Random starting position
            const startX = Math.random() * window.innerWidth;
            const startY = Math.random() * window.innerHeight;
            
            gsap.set(particle, { x: startX, y: startY });
            
            // Animate particle
            gsap.to(particle, {
                x: startX + (Math.random() - 0.5) * 200,
                y: startY + (Math.random() - 0.5) * 200,
                opacity: 0,
                duration: 3 + Math.random() * 2,
                delay: index * 0.1,
                ease: "power1.out",
                repeat: -1,
                yoyo: true
            });
        });
    }

    setupEventListeners() {
        // Scroll-triggered animations
        this.setupScrollAnimations();
        
        // Resize handler
        window.addEventListener('resize', () => {
            this.handleResize();
        });
    }

    setupScrollAnimations() {
        // Advanced scroll animations
        gsap.utils.toArray('.scroll-animate').forEach(element => {
            gsap.fromTo(element, 
                { 
                    y: 100, 
                    opacity: 0,
                    scale: 0.9,
                    rotationX: -15
                },
                {
                    y: 0,
                    opacity: 1,
                    scale: 1,
                    rotationX: 0,
                    duration: 1.2,
                    ease: "power3.out",
                    scrollTrigger: {
                        trigger: element,
                        start: "top 80%",
                        end: "bottom 20%",
                        toggleActions: "play none none reverse"
                    }
                }
            );
        });
    }

    handleResize() {
        // Handle window resize
        ScrollTrigger.refresh();
    }

    // Advanced button click effects
    static createRippleEffect(event) {
        const button = event.currentTarget;
        const ripple = document.createElement('span');
        const rect = button.getBoundingClientRect();
        const size = Math.max(rect.width, rect.height);
        const x = event.clientX - rect.left - size / 2;
        const y = event.clientY - rect.top - size / 2;

        ripple.style.cssText = `
            position: absolute;
            width: ${size}px;
            height: ${size}px;
            left: ${x}px;
            top: ${y}px;
            background: radial-gradient(circle, rgba(0, 245, 255, 0.6) 0%, transparent 70%);
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            pointer-events: none;
        `;

        button.appendChild(ripple);

        // Remove ripple after animation
        setTimeout(() => {
            ripple.remove();
        }, 600);
    }

    // Advanced loading animations
    static showLoadingAnimation(element) {
        gsap.to(element, {
            opacity: 0.7,
            scale: 0.98,
            duration: 0.3,
            ease: "power2.out"
        });

        // Add loading class
        element.classList.add('loading-futuristic');
    }

    static hideLoadingAnimation(element) {
        gsap.to(element, {
            opacity: 1,
            scale: 1,
            duration: 0.3,
            ease: "power2.out"
        });

        // Remove loading class
        element.classList.remove('loading-futuristic');
    }

    // Advanced success/error animations
    static showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification-futuristic notification-${type}`;
        notification.innerHTML = `
            <div class="notification-content">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-triangle'}"></i>
                <span>${message}</span>
            </div>
        `;

        document.body.appendChild(notification);

        // Animate in
        gsap.fromTo(notification, 
            { 
                x: 300, 
                opacity: 0,
                scale: 0.8
            },
            {
                x: 0,
                opacity: 1,
                scale: 1,
                duration: 0.6,
                ease: "back.out(1.7)"
            }
        );

        // Auto remove
        setTimeout(() => {
            gsap.to(notification, {
                x: 300,
                opacity: 0,
                scale: 0.8,
                duration: 0.4,
                ease: "power2.in",
                onComplete: () => notification.remove()
            });
        }, 3000);
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    new FuturisticAdminUI();
});

// Add ripple effect to all buttons
document.addEventListener('click', (e) => {
    if (e.target.classList.contains('btn-futuristic')) {
        FuturisticAdminUI.createRippleEffect(e);
    }
});

// Export for use in other modules
window.FuturisticAdminUI = FuturisticAdminUI;
