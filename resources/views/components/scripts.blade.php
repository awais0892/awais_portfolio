{{-- resources/views/components/scripts.blade.php --}}
<script>
    // Particle animation script
    const canvas = document.getElementById('particle-canvas');
    const ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
    let particlesArray;

    // get mouse position
    let mouse = {
        x: null,
        y: null,
        radius: (canvas.height / 150) * (canvas.width / 150)
    }

    window.addEventListener('mousemove', function (event) {
        mouse.x = event.x;
        mouse.y = event.y;
    });

    // create particle
    class Particle {
        constructor(x, y, directionX, directionY, size, color) {
            this.x = x;
            this.y = y;
            this.directionX = directionX;
            this.directionY = directionY;
            this.size = size;
            this.color = color;
        }
        // method to draw individual particle
        draw() {
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2, false);
            ctx.fillStyle = 'rgba(0, 245, 255, 0.3)';
            ctx.fill();
        }
        // check particle position, mouse position, move the particle, draw the particle
        update() {
            if (this.x > canvas.width || this.x < 0) {
                this.directionX = -this.directionX;
            }
            if (this.y > canvas.height || this.y < 0) {
                this.directionY = -this.directionY;
            }
            this.x += this.directionX;
            this.y += this.directionY;
            this.draw();
        }
    }

    // create particle array
    function init() {
        particlesArray = [];
        // Reduce particle count for performance
        let numberOfParticles = (canvas.height * canvas.width) / 15000;
        for (let i = 0; i < numberOfParticles; i++) {
            let size = (Math.random() * 1.5) + 0.5;
            let x = (Math.random() * ((innerWidth - size * 2) - (size * 2)) + size * 2);
            let y = (Math.random() * ((innerHeight - size * 2) - (size * 2)) + size * 2);
            let directionX = (Math.random() * .4) - .2;
            let directionY = (Math.random() * .4) - .2;
            let color = 'rgba(0, 245, 255, 0.3)';
            particlesArray.push(new Particle(x, y, directionX, directionY, size, color));
        }
    }

    // animation loop
    function animate() {
        requestAnimationFrame(animate);
        ctx.clearRect(0, 0, innerWidth, innerHeight);

        for (let i = 0; i < particlesArray.length; i++) {
            particlesArray[i].update();
        }
        connect();
    }

    // Optimized connect function
    function connect() {
        let opacityValue = 1;
        const maxDistance = (canvas.width / 10) * (canvas.height / 10);
        for (let a = 0; a < particlesArray.length; a++) {
            for (let b = a + 1; b < particlesArray.length; b++) {
                let dx = particlesArray[a].x - particlesArray[b].x;
                let dy = particlesArray[a].y - particlesArray[b].y;
                let distance = (dx * dx) + (dy * dy);
                if (distance < maxDistance) {
                    opacityValue = 1 - (distance / maxDistance);
                    ctx.strokeStyle = `rgba(0, 245, 255, ${opacityValue * 0.2})`;
                    ctx.lineWidth = 1;
                    ctx.beginPath();
                    ctx.moveTo(particlesArray[a].x, particlesArray[a].y);
                    ctx.lineTo(particlesArray[b].x, particlesArray[b].y);
                    ctx.stroke();
                }
            }
        }
    }

    // resize event
    window.addEventListener('resize', function () {
        canvas.width = innerWidth;
        canvas.height = innerHeight;
        mouse.radius = ((canvas.height / 120) * (canvas.height / 120));
        init();
    });

    // mouse out event
    window.addEventListener('mouseout', function () {
        mouse.x = undefined;
        mouse.y = undefined;
    });

    init();
    animate();

    // GSAP Animations (plugins already registered in app.js)

    document.addEventListener("DOMContentLoaded", function () {
        try {
            // Cyberpunk-inspired reveal animations
            const revealElements = document.querySelectorAll(".gsap-reveal");

            if (revealElements.length > 0) {
                revealElements.forEach((el, index) => {
                    const delay = el.dataset.gsapDelay ? parseFloat(el.dataset.gsapDelay) : 0;

                    gsap.fromTo(el, {
                        opacity: 0,
                        y: 30,
                        scale: 0.95
                    }, {
                        opacity: 1,
                        y: 0,
                        scale: 1,
                        duration: 0.5,
                        delay: delay,
                        ease: "power2.out",
                        force3D: true,
                        scrollTrigger: {
                            trigger: el,
                            start: "top 92%",
                            once: true
                        }
                    });
                });
            }

            // Skill icons optimized
            const skillItems = document.querySelectorAll("#skills .gsap-reveal");
            if (skillItems.length > 0) {
                gsap.fromTo(skillItems, {
                    opacity: 0,
                    y: 20,
                    scale: 0.9
                }, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 0.4,
                    stagger: 0.03,
                    ease: "power2.out",
                    force3D: true,
                    scrollTrigger: {
                        trigger: "#skills",
                        start: "top 90%"
                    }
                });
            }

            // Hero section optimized
            const heroElements = document.querySelectorAll("#home .gsap-reveal");
            if (heroElements.length > 0) {
                gsap.fromTo(heroElements, {
                    opacity: 0,
                    y: 40,
                    scale: 0.95
                }, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 0.6,
                    stagger: 0.1,
                    ease: "power2.out",
                    force3D: true
                });
            }

            // Project cards optimized
            const projectCards = document.querySelectorAll("#projects .gsap-reveal");
            if (projectCards.length > 0) {
                gsap.fromTo(projectCards, {
                    opacity: 0,
                    y: 40,
                    scale: 0.95
                }, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    duration: 0.5,
                    stagger: 0.08,
                    ease: "power2.out",
                    force3D: true,
                    scrollTrigger: {
                        trigger: "#projects",
                        start: "top 90%"
                    }
                });
            }

            // Experience cards optimized
            const expCards = document.querySelectorAll("#experience .gsap-reveal, #education .gsap-reveal");
            if (expCards.length > 0) {
                gsap.fromTo(expCards, {
                    opacity: 0,
                    x: -30
                }, {
                    opacity: 1,
                    x: 0,
                    duration: 0.5,
                    stagger: 0.1,
                    ease: "power2.out",
                    force3D: true,
                    scrollTrigger: {
                        trigger: expCards[0].closest('section'),
                        start: "top 90%"
                    }
                });
            }

            // Floating animation for hero section
            const heroSection = document.querySelector("#home");
            if (heroSection) {
                gsap.to(heroSection, {
                    y: -20,
                    duration: 4,
                    ease: "power2.inOut",
                    yoyo: true,
                    repeat: -1
                });
            }

            // Hover animations for buttons and cards
            const interactiveElements = document.querySelectorAll('.glow-button, .glass-card, .skill-icon');
            interactiveElements.forEach(el => {
                el.addEventListener('mouseenter', () => {
                    gsap.to(el, {
                        scale: 1.05,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });

                el.addEventListener('mouseleave', () => {
                    gsap.to(el, {
                        scale: 1,
                        duration: 0.3,
                        ease: "power2.out"
                    });
                });
            });

            // Subtle parallax effect for background elements
            const backgroundElements = document.querySelectorAll('.glass-card');
            backgroundElements.forEach(el => {
                gsap.to(el, {
                    y: -10,
                    ease: "none",
                    scrollTrigger: {
                        trigger: el,
                        start: "top bottom",
                        end: "bottom top",
                        scrub: true
                    }
                });
            });

            // Contact form animations - Optimized for speed
            const contactForm = document.querySelector('#contact-form');
            if (contactForm) {
                const formInputs = contactForm.querySelectorAll('input, textarea');
                formInputs.forEach((input, index) => {
                    gsap.fromTo(input, {
                        opacity: 0,
                        x: -20
                    }, {
                        opacity: 1,
                        x: 0,
                        duration: 0.2,
                        delay: 0.02 * index,
                        ease: "power2.out",
                        scrollTrigger: {
                            trigger: input,
                            start: "top 90%",
                            once: true
                        }
                    });
                });
            }

            // Smooth scroll animations for navigation links
            const navLinks = document.querySelectorAll('a[href^="#"]');
            navLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    const targetId = link.getAttribute('href');
                    const targetElement = document.querySelector(targetId);

                    if (targetElement) {
                        gsap.to(window, {
                            duration: 1.5,
                            scrollTo: {
                                y: targetElement,
                                offsetY: 80
                            },
                            ease: "power2.inOut"
                        });
                    }
                });
            });

            // Text reveal animation for headings
            const headings = document.querySelectorAll('h1, h2, h3');
            headings.forEach(heading => {
                if (heading.textContent.length > 20) {
                    gsap.fromTo(heading, {
                        opacity: 0,
                        y: 30
                    }, {
                        opacity: 1,
                        y: 0,
                        duration: 0.8,
                        ease: "power2.out",
                        scrollTrigger: {
                            trigger: heading,
                            start: "top 85%",
                            once: true
                        }
                    });
                }
            });

            // Typing effect for hero title
            const heroTitle = document.querySelector('#home h1');
            if (heroTitle) {
                const text = heroTitle.textContent;
                heroTitle.innerHTML = '';

                // Create a span for each character
                text.split('').forEach((char, index) => {
                    const span = document.createElement('span');
                    span.textContent = char === ' ' ? '\u00A0' : char;
                    span.style.opacity = '0';
                    span.style.transform = 'translateY(20px)';
                    heroTitle.appendChild(span);

                    // Animate each character
                    gsap.to(span, {
                        opacity: 1,
                        y: 0,
                        duration: 0.1,
                        delay: 0.5 + (index * 0.05),
                        ease: "power2.out"
                    });
                });
            }

            // Enhanced particle system with GSAP
            const particleCanvas = document.getElementById('particle-canvas');
            if (particleCanvas) {
                // Add mouse interaction to particles - optimized
                particleCanvas.addEventListener('mousemove', (e) => {
                    const rect = particleCanvas.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;

                    // Simplified effect
                    gsap.to(particleCanvas, {
                        duration: 0.5,
                        scale: 1.01,
                        ease: "power1.out",
                        overwrite: "auto"
                    });
                });

                // Add scroll-based particle density
                gsap.to(particleCanvas, {
                    opacity: 0.3,
                    ease: "none",
                    scrollTrigger: {
                        trigger: "body",
                        start: "top top",
                        end: "bottom bottom",
                        scrub: true
                    }
                });
            }
        } catch (error) {
            console.error("GSAP animation error:", error);
        }

        // Initialize Choices.js immediately and with delays to counter various race conditions
        initializeChoices();
        setTimeout(initializeChoices, 100);
        setTimeout(initializeChoices, 500);
        setTimeout(initializeChoices, 1000);
        setTimeout(initializeChoices, 2000);
    });

    function initializeChoices() {
        if (typeof Choices === 'undefined') return;

        const elements = document.querySelectorAll('.js-choice');
        elements.forEach(el => {
            // Very important: check if already initialized by looking for the wrapper
            // Choices.js wraps the select in a .choices div
            if (el.closest('.choices')) return;

            try {
                new Choices(el, {
                    searchEnabled: true,
                    itemSelectText: '',
                    shouldSort: false,
                    placeholder: true,
                    allowHTML: true,
                });
            } catch (e) {
                // Silently fail if already initialized or other error
            }
        });
    }

    // Mobile Menu Toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when a link is clicked
        const mobileMenuLinks = mobileMenu.querySelectorAll('a');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });
    }

    // Form submission handling (SweetAlert2)
    const contactForm = document.getElementById('contact-form');
    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(contactForm);
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            if (!csrfToken) {
                console.error('CSRF token not found');
                return;
            }

            const payload = {
                name: formData.get('name'),
                email: formData.get('email'),
                subject: formData.get('subject'),
                message: formData.get('message'),
                _token: csrfToken
            };

            // Show loading modal
            Swal.fire({
                title: 'Sending message',
                html: 'Please wait while your message is being sent...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading(),
                showConfirmButton: false,
                background: 'rgba(23, 29, 49, 0.95)',
                color: '#E0E0E0'
            });

            try {
                const res = await fetch('{{ route("contact.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify(payload)
                });
                const data = await res.json();
                if (!res.ok || data.error) throw new Error(data.error || 'Failed');

                // Compact success modal with top border progress bar and check icon
                Swal.fire({
                    title: 'Message sent',
                    html: 'Thanks, ' + (payload.name || 'there') + '! I will get back to you soon.',
                    iconHtml: '<i class="fas fa-check-circle"></i>',
                    customClass: { popup: 'compact' },
                    showConfirmButton: false,
                    timer: 2500,
                    timerProgressBar: true,
                    background: 'rgba(23, 29, 49, 0.95)'
                });

                contactForm.reset();
            } catch (err) {
                console.error('Contact form error:', err);
                Swal.fire({
                    title: 'Failed to send',
                    html: 'Something went wrong. Please try again later.',
                    iconHtml: '<i class="fas fa-exclamation-triangle"></i>',
                    customClass: { popup: 'compact' },
                    confirmButtonText: 'OK',
                    background: 'rgba(23, 29, 49, 0.95)'
                });
            }
        });
    }

    // Mailto click: copy to clipboard and show themed toast
    (function () {
        const mailLink = document.querySelector('a[href^="mailto:"]');
        if (!mailLink) return;
        mailLink.addEventListener('click', async (e) => {
            e.preventDefault();
            const email = mailLink.getAttribute('href').replace('mailto:', '');
            try {
                await navigator.clipboard.writeText(email);
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2200,
                    timerProgressBar: true,
                    customClass: { popup: 'compact' },
                    background: 'rgba(23, 29, 49, 0.95)',
                    color: '#E0E0E0',
                    title: 'Email copied to clipboard',
                    text: email
                });
            } catch (err) {
                // fallback: open mail client
                window.location.href = 'mailto:' + email;
            }
        });
    })();

    // Chatbot JS v1.1 - Added closeBtn and improved robustness
    (function () {
        const toggleBtn = document.getElementById('chatbot-toggle');
        const chatWindow = document.getElementById('chat-window');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');
        const closeBtn = document.getElementById('chatbot-close');

        // Safety check for required elements
        if (!toggleBtn || !chatWindow || !chatForm) {
            console.warn('Chatbot components not found in DOM.');
            return;
        }

        function addMessage(text, sender = 'user') {
            if (!chatMessages) return;
            const wrap = document.createElement('div');
            wrap.className = `chat-message ${sender}-message mb-3`;
            const p = document.createElement('p');
            p.className = (sender === 'user')
                ? 'bg-white/90 p-3 rounded-lg text-sm text-black'
                : 'bg-cyan-900/50 p-3 rounded-lg text-sm';
            p.innerText = text;
            wrap.appendChild(p);
            chatMessages.appendChild(wrap);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        async function getAIResponse(input) {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (!csrfToken) {
                console.error('CSRF token not found');
                return "Sorry, I'm having trouble connecting right now.";
            }

            try {
                const response = await fetch('{{ route("api.chat") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ message: input })
                });
                const data = await response.json();
                return data.response || "Sorry, I couldn't process that request.";
            } catch (error) {
                console.error('Chatbot API error:', error);
                return "Sorry, I'm having trouble connecting right now.";
            }
        }

        // Close button functionality
        if (closeBtn) {
            closeBtn.addEventListener('click', () => {
                chatWindow.classList.add('hidden');
            });
        }

        // Toggle button functionality
        toggleBtn.addEventListener('click', () => {
            chatWindow.classList.toggle('hidden');
            if (!chatWindow.classList.contains('hidden') && chatInput) {
                chatInput.focus();
            }
        });

        // Form submission
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const val = chatInput.value.trim();
            if (!val) return;

            addMessage(val, 'user');
            chatInput.value = '';

            // Add typing indicator
            addMessage('...', 'ai');

            try {
                const response = await getAIResponse(val);
                // Remove the typing indicator
                const last = chatMessages.querySelector('.chat-message.ai-message:last-child');
                if (last && last.textContent.trim() === '...') last.remove();
                addMessage(response, 'ai');
            } catch (error) {
                const last = chatMessages.querySelector('.chat-message.ai-message:last-child');
                if (last && last.textContent.trim() === '...') last.remove();
                addMessage('Sorry, I encountered an error.', 'ai');
            }
        });
    })();
</script>