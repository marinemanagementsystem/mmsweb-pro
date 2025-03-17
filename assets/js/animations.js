/**
 * MMS - Marine Management System
 * Animation Effects
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    /**
     * Particles.js Configuration
     */
    if (typeof particlesJS !== 'undefined' && document.getElementById('particles-js')) {
        particlesJS('particles-js', {
            "particles": {
                "number": {
                    "value": 80,
                    "density": {
                        "enable": true,
                        "value_area": 800
                    }
                },
                "color": {
                    "value": "#0066cc"
                },
                "shape": {
                    "type": "circle",
                    "stroke": {
                        "width": 0,
                        "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    }
                },
                "opacity": {
                    "value": 0.5,
                    "random": false,
                    "anim": {
                        "enable": false,
                        "speed": 1,
                        "opacity_min": 0.1,
                        "sync": false
                    }
                },
                "size": {
                    "value": 3,
                    "random": true,
                    "anim": {
                        "enable": false,
                        "speed": 40,
                        "size_min": 0.1,
                        "sync": false
                    }
                },
                "line_linked": {
                    "enable": true,
                    "distance": 150,
                    "color": "#0066cc",
                    "opacity": 0.4,
                    "width": 1
                },
                "move": {
                    "enable": true,
                    "speed": 2,
                    "direction": "none",
                    "random": false,
                    "straight": false,
                    "out_mode": "out",
                    "bounce": false,
                    "attract": {
                        "enable": false,
                        "rotateX": 600,
                        "rotateY": 1200
                    }
                }
            },
            "interactivity": {
                "detect_on": "canvas",
                "events": {
                    "onhover": {
                        "enable": true,
                        "mode": "grab"
                    },
                    "onclick": {
                        "enable": true,
                        "mode": "push"
                    },
                    "resize": true
                },
                "modes": {
                    "grab": {
                        "distance": 140,
                        "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 400,
                        "size": 40,
                        "duration": 2,
                        "opacity": 8,
                        "speed": 3
                    },
                    "repulse": {
                        "distance": 200,
                        "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect": true
        });
    }

    /**
     * Parallax Effect for Hero Section
     */
    const heroSection = document.querySelector('.hero-section');
    
    if (heroSection) {
        window.addEventListener('scroll', () => {
            const scrollPos = window.scrollY;
            
            if (scrollPos < window.innerHeight) {
                // Apply parallax effect to hero background
                heroSection.style.backgroundPosition = `50% ${scrollPos * 0.4}px`;
                
                // Apply parallax effect to hero content
                const heroContent = document.querySelector('.hero-content');
                const heroImage = document.querySelector('.hero-image');
                
                if (heroContent && heroImage) {
                    heroContent.style.transform = `translateY(${scrollPos * 0.2}px)`;
                    heroImage.style.transform = `translateY(${scrollPos * 0.1}px)`;
                }
            }
        });
    }

    /**
     * Animate Numbers on Scroll
     */
    const animateNumbers = () => {
        const numberElements = document.querySelectorAll('.stats-number, .experience-badge .years, .stat-number');
        
        numberElements.forEach(element => {
            const target = parseInt(element.textContent, 10);
            const increment = target / 30;
            let current = 0;
            
            const updateValue = () => {
                if (current < target) {
                    current += increment;
                    if (current > target) current = target;
                    element.textContent = Math.ceil(current).toLocaleString();
                    requestAnimationFrame(updateValue);
                } else {
                    element.textContent = target.toLocaleString();
                }
            };
            
            // Start animation
            updateValue();
        });
    };

    /**
     * Initialize Intersection Observer for Counting Animation
     */
    const initCountingObserver = () => {
        const options = {
            threshold: 0.5
        };
        
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateNumbers();
                    observer.unobserve(entry.target);
                }
            });
        }, options);
        
        // Observe elements
        const statsSection = document.querySelector('.stats-container, .experience-badge, .team-info');
        if (statsSection) {
            observer.observe(statsSection);
        }
    };
    
    initCountingObserver();

    /**
     * Tilt Effect for Cards
     */
    const cards = document.querySelectorAll('.card, .package-card, .solution-item');
    
    if (cards.length) {
        cards.forEach(card => {
            card.addEventListener('mousemove', (e) => {
                const cardRect = card.getBoundingClientRect();
                const cardX = e.clientX - cardRect.left;
                const cardY = e.clientY - cardRect.top;
                
                const centerX = cardRect.width / 2;
                const centerY = cardRect.height / 2;
                
                const rotateY = (cardX - centerX) / 20;
                const rotateX = (centerY - cardY) / 20;
                
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
            });
            
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
            });
        });
    }

    /**
     * Typewriter Effect for Hero Text
     */
    const heroText = document.querySelector('.hero-text');
    
    if (heroText && heroText.textContent.trim() !== '') {
        const text = heroText.textContent;
        heroText.textContent = '';
        
        let i = 0;
        const typeWriter = () => {
            if (i < text.length) {
                heroText.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 50);
            }
        };
        
        setTimeout(typeWriter, 1000);
    }

    /**
     * Smooth Reveal for Sections
     */
    const revealSections = () => {
        const sections = document.querySelectorAll('section');
        
        sections.forEach(section => {
            const sectionTop = section.getBoundingClientRect().top;
            const windowHeight = window.innerHeight;
            
            if (sectionTop < windowHeight * 0.75) {
                section.classList.add('reveal');
            }
        });
    };
    
    window.addEventListener('scroll', revealSections);
    revealSections();

    /**
     * Particle Waves Animation
     */
    const generateWaves = () => {
        const wavesSections = document.querySelectorAll('.hero-waves, .cta-waves');
        
        if (wavesSections.length === 0) return;
        
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        
        const waves = [];
        const waveColors = ['rgba(255, 255, 255, 0.2)', 'rgba(255, 255, 255, 0.3)', 'rgba(255, 255, 255, 0.4)'];
        
        const resize = () => {
            canvas.width = window.innerWidth;
            canvas.height = 150;
            
            // Reset waves
            waves.length = 0;
            
            // Create waves
            for (let i = 0; i < 3; i++) {
                waves.push({
                    y: canvas.height / 2 + (i * 30),
                    amplitude: 20 - (i * 5),
                    frequency: 0.01 + (i * 0.005),
                    speed: 0.05 + (i * 0.02),
                    offset: 0,
                    color: waveColors[i]
                });
            }
        };
        
        const draw = () => {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Draw each wave
            waves.forEach(wave => {
                ctx.beginPath();
                ctx.moveTo(0, wave.y);
                
                // Draw wave path
                for (let x = 0; x < canvas.width; x++) {
                    const y = wave.y + Math.sin(x * wave.frequency + wave.offset) * wave.amplitude;
                    ctx.lineTo(x, y);
                }
                
                // Complete the wave
                ctx.lineTo(canvas.width, canvas.height);
                ctx.lineTo(0, canvas.height);
                ctx.closePath();
                
                // Fill the wave
                ctx.fillStyle = wave.color;
                ctx.fill();
                
                // Update offset for animation
                wave.offset += wave.speed;
            });
            
            requestAnimationFrame(draw);
        };
        
        // Initialize
        resize();
        window.addEventListener('resize', resize);
        draw();
        
        // Add canvas to wave sections
        wavesSections.forEach(section => {
            section.appendChild(canvas.cloneNode(true));
        });
    };
    
    generateWaves();

    /**
     * ScrollSpy Effect for Navigation
     */
    const scrollSpy = () => {
        const sections = document.querySelectorAll('section[id]');
        
        window.addEventListener('scroll', () => {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                
                if (window.pageYOffset >= sectionTop - 100) {
                    current = section.getAttribute('id');
                }
            });
            
            // Add 'active' class to corresponding navigation link
            const navLinks = document.querySelectorAll('.nav a[href^="#"]');
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
    };
    
    scrollSpy();

    /**
     * 3D Depth Effect for Hover
     */
    const depthElements = document.querySelectorAll('.about-image, .promises-image, .features-image');
    
    if (depthElements.length) {
        depthElements.forEach(element => {
            element.addEventListener('mousemove', (e) => {
                const rect = element.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                const xPercent = x / rect.width;
                const yPercent = y / rect.height;
                
                const maxRotation = 5;
                const rotateY = (xPercent - 0.5) * maxRotation * 2;
                const rotateX = (0.5 - yPercent) * maxRotation * 2;
                
                element.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.05, 1.05, 1.05)`;
                element.style.transition = 'transform 0.1s linear';
                
                // Add shadow effect
                element.style.boxShadow = `
                    ${-rotateY * 0.5}px ${rotateX * 0.5}px 20px rgba(0, 0, 0, 0.2),
                    ${-rotateY}px ${rotateX}px 30px rgba(0, 0, 0, 0.1)
                `;
            });
            
            element.addEventListener('mouseleave', () => {
                element.style.transform = 'perspective(1000px) rotateX(0) rotateY(0) scale3d(1, 1, 1)';
                element.style.transition = 'transform 0.5s ease, box-shadow 0.5s ease';
                element.style.boxShadow = 'none';
            });
        });
    }

    /**
     * Gradient Button Hover Effect
     */
    const gradientButtons = document.querySelectorAll('.primary-btn');
    
    if (gradientButtons.length) {
        gradientButtons.forEach(button => {
            button.addEventListener('mousemove', (e) => {
                const rect = button.getBoundingClientRect();
                const x = e.clientX - rect.left;
                const y = e.clientY - rect.top;
                
                button.style.setProperty('--x', `${x}px`);
                button.style.setProperty('--y', `${y}px`);
            });
        });
    }

    /**
     * Animate Progress Bars
     */
    const progressBars = document.querySelectorAll('.skill-progress');
    
    if (progressBars.length) {
        const animateProgressBars = () => {
            progressBars.forEach(bar => {
                const percentage = bar.getAttribute('data-percentage');
                bar.style.width = '0%';
                
                setTimeout(() => {
                    bar.style.width = percentage + '%';
                    bar.style.transition = 'width 1.5s ease-in-out';
                }, 300);
            });
        };
        
        // Create observer for progress bars
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateProgressBars();
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });
        
        // Observe the parent element containing progress bars
        const skillsSection = document.querySelector('.team-skills');
        if (skillsSection) {
            observer.observe(skillsSection);
        }
    }

    /**
     * Floating Icons Animation
     */
    const floatingIcons = document.querySelectorAll('.floating-elements .element');
    
    if (floatingIcons.length) {
        floatingIcons.forEach(icon => {
            // Random initial position
            const randomX = Math.random() * 40 - 20;
            const randomY = Math.random() * 40 - 20;
            
            icon.style.transform = `translate(${randomX}px, ${randomY}px)`;
            
            // Random animation duration
            const randomDuration = 3 + Math.random() * 4;
            icon.style.animationDuration = `${randomDuration}s`;
        });
    }

    /**
     * Dynamic Current Time in Admin Dashboard
     */
    const currentTimeElement = document.getElementById('current-time');
    
    if (currentTimeElement) {
        const updateTime = () => {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            currentTimeElement.textContent = `${hours}:${minutes}:${seconds}`;
        };
        
        // Update time every second
        setInterval(updateTime, 1000);
        updateTime();
    }
});
