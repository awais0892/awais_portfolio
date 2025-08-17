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
        radius: (canvas.height/120) * (canvas.width/120)
    }

    window.addEventListener('mousemove', function(event){
        mouse.x = event.x;
        mouse.y = event.y;
    });

    // create particle
    class Particle {
        constructor(x, y, directionX, directionY, size, color){
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
        let numberOfParticles = (canvas.height * canvas.width) / 9000;
        for (let i = 0; i < numberOfParticles; i++) {
            let size = (Math.random() * 2) + 1;
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
        ctx.clearRect(0,0,innerWidth, innerHeight);

        for (let i = 0; i < particlesArray.length; i++) {
            particlesArray[i].update();
        }
        connect();
    }

    // check if particles are close enough to draw line between them
    function connect(){
        let opacityValue = 1;
        for (let a = 0; a < particlesArray.length; a++) {
            for (let b = a; b < particlesArray.length; b++) {
                let distance = ((particlesArray[a].x - particlesArray[b].x) * (particlesArray[a].x - particlesArray[b].x))
                + ((particlesArray[a].y - particlesArray[b].y) * (particlesArray[a].y - particlesArray[b].y));
                if (distance < (canvas.width/7) * (canvas.height/7)) {
                    opacityValue = 1 - (distance/20000);
                    ctx.strokeStyle='rgba(0, 245, 255,' + opacityValue + ')';
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
    window.addEventListener('resize', function(){
        canvas.width = innerWidth;
        canvas.height = innerHeight;
        mouse.radius = ((canvas.height/120) * (canvas.height/120));
        init();
    });

    // mouse out event
    window.addEventListener('mouseout', function(){
        mouse.x = undefined;
        mouse.y = undefined;
    });

    init();
    animate();

    // GSAP Animations (plugins already registered in app.js)

    document.addEventListener("DOMContentLoaded", function() {
        try {
            // Cyberpunk-inspired reveal animations
            const revealElements = document.querySelectorAll(".gsap-reveal");
            
            if (revealElements.length > 0) {
                const masterTimeline = gsap.timeline();

                revealElements.forEach((el, index) => {
                    const delay = el.dataset.gsapDelay ? parseFloat(el.dataset.gsapDelay) : 0;
                    
                    // Random variations to make animations less predictable
                    const randomRotation = gsap.utils.random(-15, 15);
                    const randomScale = gsap.utils.random(0.85, 1.05);
                    
                    masterTimeline.fromTo(el, {
                        opacity: 0,
                        y: 80,
                        scale: 0.8,
                        rotation: randomRotation,
                        filter: "blur(10px)"
                    }, {
                        opacity: 1,
                        y: 0,
                        scale: randomScale,
                        rotation: 0,
                        filter: "blur(0px)",
                        duration: 0.4,
                        delay: delay,
                        ease: "back.out(1.7)",
                        scrollTrigger: {
                            trigger: el,
                            start: "top 90%",
                            toggleActions: "play none none reverse"
                        }
                    }, index * 0.1);
                });
            }

            // Skill icons with glitch effect
            const skillItems = document.querySelectorAll("#skills .gsap-reveal");
            if(skillItems.length > 0) {
                gsap.fromTo(skillItems, {
                    opacity: 0,
                    y: 50,
                    scale: 0.6,
                    rotation: -15,
                    filter: "hue-rotate(180deg) contrast(200%)"
                }, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    rotation: 0,
                    filter: "hue-rotate(0deg) contrast(100%)",
                    duration: 0.4,
                    stagger: 0.05,
                    ease: "power3.out",
                    scrollTrigger: {
                        trigger: "#skills",
                        start: "top 85%"
                    }
                });
            }

            // Hero section with aggressive cyberpunk entrance
            const heroElements = document.querySelectorAll("#home .gsap-reveal");
            if(heroElements.length > 0) {
                gsap.fromTo(heroElements, {
                    opacity: 0,
                    y: 100,
                    scale: 0.7,
                    rotation: -20,
                    filter: "blur(15px) brightness(0%)"
                }, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    rotation: 0,
                    filter: "blur(0px) brightness(100%)",
                    duration: 0.5,
                    stagger: 0.1,
                    ease: "power4.out"
                });
            }

            // Project cards with dynamic tech reveal
            const projectCards = document.querySelectorAll("#projects .gsap-reveal");
            if(projectCards.length > 0) {
                gsap.fromTo(projectCards, {
                    opacity: 0,
                    y: 80,
                    scale: 0.8,
                    rotation: 10,
                    filter: "hue-rotate(90deg) contrast(150%)"
                }, {
                    opacity: 1,
                    y: 0,
                    scale: 1,
                    rotation: 0,
                    filter: "hue-rotate(0deg) contrast(100%)",
                    duration: 0.4,
                    stagger: 0.1,
                    ease: "back.out(1.5)",
                    scrollTrigger: {
                        trigger: "#projects",
                        start: "top 85%"
                    }
                });
            }

            // Experience cards with circuit-board style animation
            const expCards = document.querySelectorAll("#experience .gsap-reveal, #education .gsap-reveal");
            if(expCards.length > 0) {
                gsap.fromTo(expCards, {
                    opacity: 0,
                    x: -80,
                    scale: 0.8,
                    rotation: -10,
                    filter: "brightness(0%) contrast(200%)"
                }, {
                    opacity: 1,
                    x: 0,
                    scale: 1,
                    rotation: 0,
                    filter: "brightness(100%) contrast(100%)",
                    duration: 0.4,
                    stagger: 0.1,
                    ease: "power3.out",
                    scrollTrigger: {
                        trigger: expCards[0].closest('section'),
                        start: "top 85%"
                    }
                });
            }

            // Floating animation for hero section
            const heroSection = document.querySelector("#home");
            if(heroSection) {
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

            // Parallax effect for background elements
            const backgroundElements = document.querySelectorAll('.glass-card');
            backgroundElements.forEach(el => {
                gsap.to(el, {
                    y: -50,
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
            if(contactForm) {
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
                    
                    if(targetElement) {
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
                if(heading.textContent.length > 20) {
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
            if(heroTitle) {
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
            if(particleCanvas) {
                // Add mouse interaction to particles
                particleCanvas.addEventListener('mousemove', (e) => {
                    const rect = particleCanvas.getBoundingClientRect();
                    const x = e.clientX - rect.left;
                    const y = e.clientY - rect.top;
                    
                    // Create ripple effect
                    gsap.to(particleCanvas, {
                        duration: 0.3,
                        scale: 1.02,
                        ease: "power2.out",
                        yoyo: true,
                        repeat: 1
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
    });

    // Mobile Menu Toggle
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');

    if(mobileMenuButton && mobileMenu) {
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
    if(contactForm) {
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
    (function(){
        const mailLink = document.querySelector('a[href^="mailto:"]');
        if(!mailLink) return;
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

    // Chatbot JS
    (function(){
        const toggleBtn = document.getElementById('chatbot-toggle');
        const chatWindow = document.getElementById('chat-window');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const chatMessages = document.getElementById('chat-messages');

        if(!toggleBtn || !chatWindow || !chatForm) return;

        function addMessage(text, sender = 'user'){
            const wrap = document.createElement('div');
            wrap.className = `chat-message ${sender}-message mb-3`;
            const p = document.createElement('p');
            p.className = (sender === 'user') ? 'bg-white/90 p-3 rounded-lg text-sm text-black' : 'bg-cyan-900/50 p-3 rounded-lg text-sm';
            p.innerText = text;
            wrap.appendChild(p);
            chatMessages.appendChild(wrap);
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        async function getAIResponse(input){
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (!csrfToken) {
                console.error('CSRF token not found');
                return "Sorry, I'm having trouble connecting right now. Please try again later.";
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
                return data.response || "Sorry, I couldn't process that request right now.";
            } catch (error) {
                console.error('Chatbot API error:', error);
                return "Sorry, I'm having trouble connecting right now. Please try again later.";
            }
        }

        toggleBtn.addEventListener('click', () => {
            chatWindow.classList.toggle('hidden');
            if(!chatWindow.classList.contains('hidden')){
                chatInput.focus();
            }
        });

        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const val = chatInput.value.trim();
            if(!val) return;
            addMessage(val, 'user');
            chatInput.value = '';
            
            // Add typing indicator
            addMessage('...', 'ai');
            
            try {
                const response = await getAIResponse(val);
                // Remove the typing indicator
                const last = chatMessages.querySelector('.chat-message.ai-message:last-child');
                if(last && last.textContent.trim() === '...') last.remove();
                addMessage(response, 'ai');
            } catch (error) {
                // Remove the typing indicator
                const last = chatMessages.querySelector('.chat-message.ai-message:last-child');
                if(last && last.textContent.trim() === '...') last.remove();
                addMessage('Sorry, I encountered an error. Please try again.', 'ai');
            }
        });
    })();
</script>