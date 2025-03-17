<?php
/**
 * MMS - Marine Management System
 * Language Handling Functions
 */

/**
 * Get available languages
 * 
 * @return array Available languages (code => name)
 */
function get_available_languages() {
    return [
        'tr' => 'Türkçe',
        'en' => 'English'
    ];
}

/**
 * Get translations for the current language
 * 
 * @param string $language Language code
 * @return array Translations
 */
function get_translations($language = 'tr') {
    $translations = [];
    
    if ($language === 'tr') {
        // Turkish translations
        $translations = [
            // Meta info
            'meta_description' => 'Marine Management System (MMS) - Gemi inşa sektörü için yenilikçi ERP çözümleri. Tersane yönetimi, üretim planlama, stok kontrol ve daha fazlası.',
            'innovative_erp' => 'Gemi inşa sektörü için yenilikçi ERP çözümleri',
            
            // Navigation
            'home' => 'Anasayfa',
            'about_us' => 'Hakkımızda',
            'our_vision' => 'Vizyonumuz',
            'our_mission' => 'Misyonumuz',
            'our_promises' => 'Vaatlerimiz',
            'our_software' => 'Yazılımlarımız',
            'solutions' => 'Çözümler',
            'features' => 'Özellikler',
            'advantages' => 'Avantajlar',
            'packages' => 'Paketler',
            'contact' => 'İletişim',
            'request_demo' => 'Demo İste',
            
            // Hero Section
            'hero_subtitle' => 'Gemi inşa sektörü için yenilikçi ERP çözümleri.',
            'discover' => 'Keşfet',
            
            // About Section
            'years_experience' => 'Yıllık Deneyim',
            
            // Solutions & Features
            'solutions_title' => 'MMS\'in Sunduğu Çözümler',
            'features_title' => 'MMS\'i Farklı Kılan Özellikler',
            'unique_solutions' => 'Benzersiz Çözümler',
            
            // Common terms
            'reliability' => 'Güvenilirlik',
            'reliability_text' => 'Yazılımımız, en yüksek kalite standartlarında geliştirilmiştir ve %99.9 çalışma süresi garantisi sunar.',
            'innovation' => 'İnovasyon',
            'innovation_text' => 'En son teknolojileri kullanan sürekli gelişen ve yenilenen bir platform sunuyoruz.',
            'support' => 'Destek',
            'support_text' => 'Uzman ekibimiz, 7/24 teknik destek ve danışmanlık hizmetleri ile yanınızda.',
            
            // Packages Section
            'monthly' => 'Aylık',
            'annual' => 'Yıllık',
            'save' => 'Tasarruf',
            'most_popular' => 'En Popüler',
            'get_started' => 'Başla',
            'month' => 'ay',
            'year' => 'yıl',
            
            // Technical Section
            'technical_feasibility' => 'Teknik Yapılabilirlik',
            'team_competencies' => 'Ekip Yetkinlikleri',
            'technologies_used' => 'Kullanılan Teknolojiler',
            'graduate_engineers' => 'Mezunu Mühendisler',
            
            // CTA Section
            'request_demo_title' => 'Demo Talep Edin',
            'request_demo_text' => 'ERP yazılımımızın demo versiyonunu incelemek için hemen talepte bulunun.',
            
            // Contact Section
            'our_location' => 'Konumumuz',
            'email_us' => 'E-posta',
            'call_us' => 'Bizi Arayın',
            'name' => 'Adınız',
            'surname' => 'Soyadınız',
            'email' => 'E-posta Adresiniz',
            'phone' => 'Telefon Numaranız',
            'message' => 'Mesajınız',
            'send_message' => 'Mesaj Gönder',
            
            // Footer
            'quick_links' => 'Hızlı Bağlantılar',
            'software' => 'Yazılımlar',
            'contact_us' => 'İletişim',
            'all_rights_reserved' => 'Tüm hakları saklıdır.',
            'footer_description' => 'MMS, gemi inşa sektörüne özel olarak geliştirilmiş yenilikçi ERP çözümleri sunan bir yazılım şirketidir.',
            
            // Forms & Modals
            'submit' => 'Gönder',
            'close' => 'Kapat',
            'thank_you' => 'Teşekkürler!',
            'form_success' => 'Formunuz başarıyla gönderildi. En kısa sürede size dönüş yapacağız.',
            
            // Software Modules
            'modules' => 'Modüller'
        ];
    } else {
        // English translations
        $translations = [
            // Meta info
            'meta_description' => 'Marine Management System (MMS) - Innovative ERP solutions for the shipbuilding industry. Shipyard management, production planning, inventory control, and more.',
            'innovative_erp' => 'Innovative ERP solutions for the shipbuilding industry',
            
            // Navigation
            'home' => 'Home',
            'about_us' => 'About Us',
            'our_vision' => 'Our Vision',
            'our_mission' => 'Our Mission',
            'our_promises' => 'Our Promises',
            'our_software' => 'Our Software',
            'solutions' => 'Solutions',
            'features' => 'Features',
            'advantages' => 'Advantages',
            'packages' => 'Packages',
            'contact' => 'Contact',
            'request_demo' => 'Request Demo',
            
            // Hero Section
            'hero_subtitle' => 'Innovative ERP solutions for the shipbuilding industry.',
            'discover' => 'Discover',
            
            // About Section
            'years_experience' => 'Years Experience',
            
            // Solutions & Features
            'solutions_title' => 'Solutions Offered by MMS',
            'features_title' => 'Features that Make MMS Different',
            'unique_solutions' => 'Unique Solutions',
            
            // Common terms
            'reliability' => 'Reliability',
            'reliability_text' => 'Our software is developed to the highest quality standards and offers a 99.9% uptime guarantee.',
            'innovation' => 'Innovation',
            'innovation_text' => 'We provide a continuously evolving and renewing platform using the latest technologies.',
            'support' => 'Support',
            'support_text' => 'Our expert team is by your side with 24/7 technical support and consulting services.',
            
            // Packages Section
            'monthly' => 'Monthly',
            'annual' => 'Annual',
            'save' => 'Save',
            'most_popular' => 'Most Popular',
            'get_started' => 'Get Started',
            'month' => 'month',
            'year' => 'year',
            
            // Technical Section
            'technical_feasibility' => 'Technical Feasibility',
            'team_competencies' => 'Team Competencies',
            'technologies_used' => 'Technologies Used',
            'graduate_engineers' => 'Graduate Engineers',
            
            // CTA Section
            'request_demo_title' => 'Request a Demo',
            'request_demo_text' => 'Request now to review the demo version of our ERP software.',
            
            // Contact Section
            'our_location' => 'Our Location',
            'email_us' => 'Email Us',
            'call_us' => 'Call Us',
            'name' => 'Your Name',
            'surname' => 'Your Surname',
            'email' => 'Your Email',
            'phone' => 'Your Phone',
            'message' => 'Your Message',
            'send_message' => 'Send Message',
            
            // Footer
            'quick_links' => 'Quick Links',
            'software' => 'Software',
            'contact_us' => 'Contact Us',
            'all_rights_reserved' => 'All rights reserved.',
            'footer_description' => 'MMS is a software company offering innovative ERP solutions specifically developed for the shipbuilding industry.',
            
            // Forms & Modals
            'submit' => 'Submit',
            'close' => 'Close',
            'thank_you' => 'Thank You!',
            'form_success' => 'Your form has been successfully submitted. We will get back to you as soon as possible.',
            
            // Software Modules
            'modules' => 'Modules'
        ];
    }
    
    return $translations;
}

/**
 * Translate text using current language
 * 
 * @param string $key Key to translate
 * @param string $language Language code
 * @return string Translated text
 */
function translate($key, $language = null) {
    // If language not specified, detect from URL or session
    if ($language === null) {
        $language = $_GET['lang'] ?? $_SESSION['language'] ?? 'tr';
    }
    
    // Get translations
    $translations = get_translations($language);
    
    // Return translation if exists, or key if not
    return $translations[$key] ?? $key;
}

/**
 * Output translated text (shorthand)
 * 
 * @param string $key Key to translate
 * @param string $language Language code
 * @return void
 */
function _t($key, $language = null) {
    echo translate($key, $language);
}
