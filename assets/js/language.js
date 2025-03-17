/**
 * MMS - Marine Management System
 * Language Switching Functionality
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    /**
     * Get current language from URL or localStorage
     */
    const getCurrentLanguage = () => {
        // Check URL parameter first
        const urlParams = new URLSearchParams(window.location.search);
        let lang = urlParams.get('lang');
        
        // If not in URL, check localStorage
        if (!lang) {
            lang = localStorage.getItem('mms_language');
        }
        
        // Default to Turkish if not set
        if (!lang || !['tr', 'en'].includes(lang)) {
            lang = 'tr';
        }
        
        return lang;
    };

    /**
     * Set language in localStorage and update URL
     */
    const setLanguage = (lang) => {
        // Save to localStorage
        localStorage.setItem('mms_language', lang);
        
        // Update URL
        const url = new URL(window.location.href);
        url.searchParams.set('lang', lang);
        window.history.replaceState({}, '', url);
        
        // Update UI
        updateLanguageUI(lang);
    };

    /**
     * Update UI elements based on language
     */
    const updateLanguageUI = (lang) => {
        // Update dropdown indicator
        const languageDropdown = document.getElementById('language-dropdown');
        if (languageDropdown) {
            languageDropdown.value = lang;
        }
        
        // Update language selector display
        const currentLanguage = document.querySelector('.current-language');
        if (currentLanguage) {
            const img = currentLanguage.querySelector('img');
            const span = currentLanguage.querySelector('span');
            
            if (img) {
                img.src = `assets/images/flags/${lang}.png`;
                img.alt = lang === 'tr' ? 'Türkçe' : 'English';
            }
            
            if (span) {
                span.textContent = lang === 'tr' ? 'Türkçe' : 'English';
            }
        }
        
        // Mark active language in dropdown
        const languageLinks = document.querySelectorAll('.language-dropdown a');
        if (languageLinks.length) {
            languageLinks.forEach(link => {
                if (link.getAttribute('href').includes(`lang=${lang}`)) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        }
    };

    /**
     * Initialize language setup
     */
    const initLanguage = () => {
        const currentLang = getCurrentLanguage();
        updateLanguageUI(currentLang);
        
        // Add event listeners for language switching
        const languageDropdown = document.getElementById('language-dropdown');
        if (languageDropdown) {
            languageDropdown.addEventListener('change', (e) => {
                const newLang = e.target.value;
                setLanguage(newLang);
                
                // Reload page to apply language change
                window.location.href = `?lang=${newLang}`;
            });
        }
        
        // Language links in dropdown
        const languageLinks = document.querySelectorAll('.language-dropdown a');
        if (languageLinks.length) {
            languageLinks.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    
                    const href = link.getAttribute('href');
                    const langMatch = href.match(/lang=([a-z]{2})/);
                    
                    if (langMatch && langMatch[1]) {
                        const newLang = langMatch[1];
                        setLanguage(newLang);
                        
                        // Reload page to apply language change
                        window.location.href = `?lang=${newLang}`;
                    }
                });
            });
        }
    };
    
    // Initialize language handling
    initLanguage();

    /**
     * Helper function to translate a string
     * In a real implementation, this would use a translation dictionary
     */
    window.translate = (key, lang) => {
        const currentLang = lang || getCurrentLanguage();
        
        // This is a simplified example. In a real application,
        // you would load translations from a JSON file or API
        const translations = {
            tr: {
                home: 'Anasayfa',
                about_us: 'Hakkımızda',
                our_promises: 'Vaatlerimiz',
                our_software: 'Yazılımlarımız',
                packages: 'Paketler',
                contact: 'İletişim',
                request_demo: 'Demo İste',
                // Add more translations as needed
            },
            en: {
                home: 'Home',
                about_us: 'About Us',
                our_promises: 'Our Promises',
                our_software: 'Our Software',
                packages: 'Packages',
                contact: 'Contact',
                request_demo: 'Request Demo',
                // Add more translations as needed
            }
        };
        
        return translations[currentLang][key] || key;
    };

    /**
     * Dynamic content translation API
     * This can be used by other scripts to translate dynamic content
     */
    window.MMS = window.MMS || {};
    window.MMS.Language = {
        getCurrentLanguage,
        setLanguage,
        translate: window.translate
    };
});
