/**
 * MMS - Marine Management System
 * Main JavaScript File
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    /**
     * Preloader
     */
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                preloader.classList.add('hide');
            }, 500);
        });
    }

    /**
     * Mobile Navigation Toggle
     */
    const hamburger = document.querySelector('.hamburger');
    const nav = document.querySelector('.nav');
    
    if (hamburger && nav) {
        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            nav.classList.toggle('active');
        });
    }

    /**
     * Navbar Scroll Effect
     */
    const header = document.querySelector('.header');
    
    if (header) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });

        // Check initial scroll position
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        }
    }

    /**
     * Back to Top Button
     */
    const backToTop = document.querySelector('.back-to-top');
    
    if (backToTop) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });

        backToTop.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    }

    /**
     * Smooth Scroll for Anchor Links
     */
    const anchorLinks = document.querySelectorAll('a[href^="#"]:not([data-toggle])');
    
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const target = document.querySelector(this.getAttribute('href'));
            
            if (target) {
                e.preventDefault();
                
                // Close mobile menu if open
                if (hamburger && hamburger.classList.contains('active')) {
                    hamburger.classList.remove('active');
                    nav.classList.remove('active');
                }
                
                // Scroll to target
                window.scrollTo({
                    top: target.offsetTop - 70, // Offset for fixed header
                    behavior: 'smooth'
                });
            }
        });
    });

    /**
     * Active Nav Link on Scroll
     */
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav a[href^="#"]');
    
    if (sections.length && navLinks.length) {
        window.addEventListener('scroll', () => {
            let current = '';
            
            sections.forEach(section => {
                const sectionTop = section.offsetTop;
                const sectionHeight = section.offsetHeight;
                
                if (window.scrollY >= sectionTop - 100) {
                    current = section.getAttribute('id');
                }
            });
            
            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === `#${current}`) {
                    link.classList.add('active');
                }
            });
        });
    }

    /**
     * Animation on Scroll (AOS) Initialization
     */
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 1000,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
    }

    /**
     * Initialize Particles.js
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
                    "value": "#ffffff"
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
                    "color": "#ffffff",
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
     * Software Tab Switching
     */
    const tabs = document.querySelectorAll('.tab');
    
    if (tabs.length) {
        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const tabId = tab.getAttribute('data-tab');
                
                // Remove active class from all tabs
                document.querySelectorAll('.tab').forEach(item => {
                    item.classList.remove('active');
                });
                
                // Remove active class from all tab panes
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.remove('active');
                });
                
                // Add active class to clicked tab and corresponding tab pane
                tab.classList.add('active');
                document.getElementById(`${tabId}-content`).classList.add('active');
            });
        });
    }

    /**
     * Accordion Functionality
     */
    const accordionTitles = document.querySelectorAll('.accordion-title');
    
    if (accordionTitles.length) {
        accordionTitles.forEach(title => {
            title.addEventListener('click', () => {
                title.classList.toggle('active');
                
                const content = title.nextElementSibling;
                
                if (title.classList.contains('active')) {
                    content.style.display = 'block';
                } else {
                    content.style.display = 'none';
                }
            });
        });
    }

    /**
     * Pricing Toggle
     */
    const pricingToggle = document.getElementById('pricing-toggle');
    
    if (pricingToggle) {
        pricingToggle.addEventListener('change', () => {
            const monthlyPrices = document.querySelectorAll('.price.monthly');
            const annualPrices = document.querySelectorAll('.price.annual');
            const monthlyLabel = document.querySelector('.toggle-label:first-child');
            const annualLabel = document.querySelector('.toggle-label:last-of-type');
            
            if (pricingToggle.checked) {
                // Show annual pricing
                monthlyPrices.forEach(price => price.classList.remove('active'));
                annualPrices.forEach(price => price.classList.add('active'));
                monthlyLabel.classList.remove('active');
                annualLabel.classList.add('active');
            } else {
                // Show monthly pricing
                monthlyPrices.forEach(price => price.classList.add('active'));
                annualPrices.forEach(price => price.classList.remove('active'));
                monthlyLabel.classList.add('active');
                annualLabel.classList.remove('active');
            }
        });
    }

    /**
     * Skill Progress Animation
     */
    const skillBars = document.querySelectorAll('.skill-progress');
    
    if (skillBars.length) {
        skillBars.forEach(bar => {
            const percentage = bar.getAttribute('data-percentage');
            bar.style.width = percentage + '%';
        });
    }

    /**
     * Modal Functionality
     */
    const modalTriggers = document.querySelectorAll('[data-toggle="modal"]');
    
    if (modalTriggers.length) {
        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                
                const targetModal = document.getElementById(trigger.getAttribute('data-target'));
                
                if (targetModal) {
                    targetModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                }
            });
        });
        
        // Close modal when clicking on overlay or close button
        document.querySelectorAll('.modal-overlay, .modal-close, [data-dismiss="modal"]').forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                
                const modal = e.target.closest('.modal');
                
                if (modal) {
                    modal.classList.remove('show');
                    document.body.style.overflow = '';
                }
            });
        });
        
        // Prevent modal body clicks from closing the modal
        document.querySelectorAll('.modal-container').forEach(container => {
            container.addEventListener('click', (e) => {
                e.stopPropagation();
            });
        });
    }

    /**
     * Form Validation
     */
    const forms = document.querySelectorAll('form');
    
    if (forms.length) {
        forms.forEach(form => {
            form.addEventListener('submit', (e) => {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('error');
                    } else {
                        field.classList.remove('error');
                    }
                    
                    // Email validation
                    if (field.type === 'email' && field.value.trim()) {
                        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailPattern.test(field.value)) {
                            isValid = false;
                            field.classList.add('error');
                        }
                    }
                    
                    // Phone validation
                    if (field.type === 'tel' && field.value.trim()) {
                        const phonePattern = /^[0-9+\-\s()]{8,20}$/;
                        if (!phonePattern.test(field.value)) {
                            isValid = false;
                            field.classList.add('error');
                        }
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                    alert('Please fill in all required fields correctly.');
                }
            });
        });
    }

    /**
     * Footer Link Tab Change
     */
    const footerTabLinks = document.querySelectorAll('.footer-links a[data-tab]');
    
    if (footerTabLinks.length) {
        footerTabLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                
                const tabId = link.getAttribute('data-tab');
                
                // Scroll to software section
                const softwareSection = document.getElementById('software');
                
                if (softwareSection) {
                    window.scrollTo({
                        top: softwareSection.offsetTop - 70,
                        behavior: 'smooth'
                    });
                    
                    // Set active tab
                    setTimeout(() => {
                        document.querySelectorAll('.tab').forEach(tab => {
                            tab.classList.remove('active');
                            if (tab.getAttribute('data-tab') === tabId) {
                                tab.classList.add('active');
                                tab.click();
                            }
                        });
                    }, 500);
                }
            });
        });
    }
    
    /**
     * Floating Elements Effect
     */
    const floatingElements = document.querySelectorAll('.floating-elements .element');
    
    if (floatingElements.length) {
        window.addEventListener('mousemove', (e) => {
            const mouseX = e.clientX / window.innerWidth;
            const mouseY = e.clientY / window.innerHeight;
            
            floatingElements.forEach(element => {
                const speed = element.getAttribute('data-speed');
                const x = (mouseX * 100) * speed;
                const y = (mouseY * 100) * speed;
                
                element.style.transform = `translate(${x / 10}px, ${y / 10}px)`;
            });
        });
    }
    
    /**
     * Charts Initialization (if any)
     */
    if (typeof Chart !== 'undefined') {
        // Visitor Analytics Chart
        const visitorsChart = document.getElementById('visitors-chart');
        
        if (visitorsChart) {
            new Chart(visitorsChart, {
                type: 'line',
                data: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    datasets: [{
                        label: 'Visitors',
                        data: [65, 59, 80, 81, 56, 55, 40],
                        fill: true,
                        backgroundColor: 'rgba(0, 102, 204, 0.1)',
                        borderColor: '#0066cc',
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
        
        // Traffic Sources Chart
        const trafficChart = document.getElementById('traffic-sources-chart');
        
        if (trafficChart) {
            new Chart(trafficChart, {
                type: 'doughnut',
                data: {
                    labels: ['Direct', 'Organic Search', 'Referral', 'Social Media'],
                    datasets: [{
                        data: [30, 45, 15, 10],
                        backgroundColor: ['#0066cc', '#00a0e3', '#00b8d4', '#4a5568'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    cutout: '70%'
                }
            });
        }
    }
    
    /**
     * Contact Form Submission
     */
    const contactForm = document.getElementById('contact-form');
    
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // In a real implementation, you'd have AJAX form submission here
            // For this example, we'll simulate success
            const successModal = document.getElementById('success-modal');
            
            if (successModal) {
                successModal.classList.add('show');
                document.body.style.overflow = 'hidden';
                
                // Reset the form
                contactForm.reset();
            }
        });
    }
    
    /**
     * Demo Request Form Submission
     */
    const demoForm = document.getElementById('demo-form');
    
    if (demoForm) {
        demoForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // In a real implementation, you'd have AJAX form submission here
            // For this example, we'll simulate success
            const demoModal = document.getElementById('demo-modal');
            const successModal = document.getElementById('success-modal');
            
            if (demoModal && successModal) {
                demoModal.classList.remove('show');
                
                setTimeout(() => {
                    successModal.classList.add('show');
                    document.body.style.overflow = 'hidden';
                    
                    // Reset the form
                    demoForm.reset();
                }, 300);
            }
        });
    }
});
