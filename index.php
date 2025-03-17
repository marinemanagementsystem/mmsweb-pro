<?php
/**
 * MMS - Marine Management System
 * Main index file for the single-page application
 */

// Initialize the application
require_once 'includes/init.php';

// Get the current language
$language = isset($_GET['lang']) ? $_GET['lang'] : 'tr';
$translations = get_translations($language);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['demo_request'])) {
        handle_demo_request($_POST);
    } elseif (isset($_POST['contact_form'])) {
        handle_contact_form($_POST);
    }
}

// Get content from the database
$content = get_site_content($language);
?>
<!DOCTYPE html>
<html lang="<?php echo $language; ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marine Management System (MMS) - <?php echo $translations['innovative_erp']; ?></title>
    
    <!-- Meta tags -->
    <meta name="description" content="<?php echo $translations['meta_description']; ?>">
    <meta name="keywords" content="MMS, Marine Management System, ERP, Shipbuilding, Gemi İnşa">
    
    <!-- Favicon -->
    <link rel="icon" href="assets/images/favicon.ico" type="image/x-icon">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Preloader -->
    <div class="preloader">
        <div class="loader">
            <img src="assets/images/logo.png" alt="MMS Logo" width="120">
            <div class="loading-bar"></div>
        </div>
    </div>
    
    <!-- Particles Background -->
    <div id="particles-js"></div>
    
    <!-- Main Navigation -->
    <header class="header">
        <div class="container">
            <a href="#hero" class="logo">
                <img src="assets/images/logo.png" alt="Marine Management System Logo">
            </a>
            
            <nav class="nav">
                <ul>
                    <li><a href="#hero" data-section="hero"><?php echo $translations['home']; ?></a></li>
                    <li><a href="#about" data-section="about"><?php echo $translations['about_us']; ?></a></li>
                    <li><a href="#promises" data-section="promises"><?php echo $translations['our_promises']; ?></a></li>
                    <li><a href="#software" data-section="software"><?php echo $translations['our_software']; ?></a></li>
                    <li><a href="#packages" data-section="packages"><?php echo $translations['packages']; ?></a></li>
                    <li><a href="#contact" data-section="contact"><?php echo $translations['contact']; ?></a></li>
                    <li><a href="#" class="demo-btn" data-toggle="modal" data-target="demo-modal"><?php echo $translations['request_demo']; ?></a></li>
                </ul>
            </nav>
            
            <div class="language-selector">
                <div class="current-language">
                    <img src="assets/images/flags/<?php echo $language; ?>.png" alt="<?php echo $language; ?>">
                    <span><?php echo $language === 'tr' ? 'Türkçe' : 'English'; ?></span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <div class="language-dropdown">
                    <a href="?lang=tr" class="<?php echo $language === 'tr' ? 'active' : ''; ?>">
                        <img src="assets/images/flags/tr.png" alt="Türkçe">
                        <span>Türkçe</span>
                    </a>
                    <a href="?lang=en" class="<?php echo $language === 'en' ? 'active' : ''; ?>">
                        <img src="assets/images/flags/en.png" alt="English">
                        <span>English</span>
                    </a>
                </div>
            </div>
            
            <div class="mobile-nav-toggle">
                <div class="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Hero Section -->
    <section id="hero" class="hero-section">
        <div class="container">
            <div class="hero-content" data-aos="fade-up">
                <h1 class="main-title">Marine Management System</h1>
                <p class="hero-text"><?php echo $translations['hero_subtitle']; ?></p>
                <div class="hero-buttons">
                    <a href="#software" class="primary-btn"><?php echo $translations['discover']; ?></a>
                    <a href="#" class="secondary-btn" data-toggle="modal" data-target="demo-modal"><?php echo $translations['request_demo']; ?></a>
                </div>
            </div>
            
            <div class="hero-image" data-aos="fade-left" data-aos-delay="300">
                <img src="assets/images/ship-digital.png" alt="Digital Ship Management">
                <div class="floating-elements">
                    <div class="element" data-speed="1.2">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="element" data-speed="1.5">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="element" data-speed="1.1">
                        <i class="fas fa-database"></i>
                    </div>
                    <div class="element" data-speed="1.4">
                        <i class="fas fa-ship"></i>
                    </div>
                </div>
            </div>
            
            <div class="scroll-indicator">
                <div class="mouse">
                    <div class="wheel"></div>
                </div>
                <div class="arrows">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>
        </div>
        
        <div class="hero-waves">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#ffffff" fill-opacity="1" d="M0,192L48,181.3C96,171,192,149,288,154.7C384,160,480,192,576,202.7C672,213,768,203,864,170.7C960,139,1056,85,1152,64C1248,43,1344,53,1392,58.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>
    
    <!-- About Us Section -->
    <section id="about" class="section about-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title"><?php echo $translations['about_us']; ?></h2>
                <div class="title-underline"></div>
            </div>
            
            <div class="section-content">
                <div class="row">
                    <div class="col" data-aos="fade-right">
                        <div class="about-text">
                            <p><?php echo $content['about_text']; ?></p>
                        </div>
                    </div>
                    
                    <div class="col" data-aos="fade-left" data-aos-delay="200">
                        <div class="about-image">
                            <img src="assets/images/shipbuilding.jpg" alt="Shipbuilding Industry" class="rounded-image">
                            <div class="experience-badge">
                                <span class="years">15+</span>
                                <span class="text"><?php echo $translations['years_experience']; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Vision & Mission Cards -->
            <div class="vision-mission-cards">
                <div class="card" data-aos="zoom-in" data-aos-delay="100">
                    <div class="card-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h3 class="card-title"><?php echo $translations['our_vision']; ?></h3>
                    <p class="card-text"><?php echo $content['vision_text']; ?></p>
                </div>
                
                <div class="card" data-aos="zoom-in" data-aos-delay="200">
                    <div class="card-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h3 class="card-title"><?php echo $translations['our_mission']; ?></h3>
                    <p class="card-text"><?php echo $content['mission_text']; ?></p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Our Promises Section -->
    <section id="promises" class="section promises-section">
        <div class="section-background">
            <div class="bg-shape"></div>
            <div class="bg-dots"></div>
        </div>
        
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title"><?php echo $translations['our_promises']; ?></h2>
                <div class="title-underline"></div>
            </div>
            
            <div class="section-content">
                <div class="row reverse-row">
                    <div class="col" data-aos="fade-right">
                        <div class="promises-image">
                            <img src="assets/images/promises.jpg" alt="Our Promises" class="rounded-image">
                            <div class="image-overlay">
                                <div class="overlay-icon">
                                    <i class="fas fa-handshake"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col" data-aos="fade-left" data-aos-delay="200">
                        <div class="promises-text">
                            <p><?php echo $content['promises_text']; ?></p>
                            
                            <div class="promises-list">
                                <div class="promise-item">
                                    <div class="promise-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="promise-content">
                                        <h4><?php echo $translations['reliability']; ?></h4>
                                        <p><?php echo $translations['reliability_text']; ?></p>
                                    </div>
                                </div>
                                
                                <div class="promise-item">
                                    <div class="promise-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="promise-content">
                                        <h4><?php echo $translations['innovation']; ?></h4>
                                        <p><?php echo $translations['innovation_text']; ?></p>
                                    </div>
                                </div>
                                
                                <div class="promise-item">
                                    <div class="promise-icon">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                    <div class="promise-content">
                                        <h4><?php echo $translations['support']; ?></h4>
                                        <p><?php echo $translations['support_text']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Our Software Section -->
    <section id="software" class="section software-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title"><?php echo $translations['our_software']; ?></h2>
                <div class="title-underline"></div>
                <p class="section-subtitle"><?php echo $content['software_subtitle']; ?></p>
            </div>
            
            <div class="software-types" data-aos="fade-up" data-aos-delay="200">
                <div class="tabs">
                    <div class="tab active" data-tab="nb">
                        <i class="fas fa-ship"></i>
                        <span>MMS NB</span>
                    </div>
                    <div class="tab" data-tab="srm">
                        <i class="fas fa-tools"></i>
                        <span>MMS SRM</span>
                    </div>
                    <div class="tab" data-tab="yacht">
                        <i class="fas fa-anchor"></i>
                        <span>MMS Yacht</span>
                    </div>
                </div>
                
                <div class="tab-content">
                    <div class="tab-pane active" id="nb-content">
                        <div class="software-image">
                            <img src="assets/images/mms-nb.jpg" alt="MMS New Building">
                        </div>
                        <div class="software-description">
                            <h3>MMS NB (New Building)</h3>
                            <p><?php echo $content['mms_nb_description']; ?></p>
                            
                            <div class="module-accordion">
                                <h4 class="accordion-title">
                                    <i class="fas fa-cubes"></i>
                                    <?php echo $translations['modules']; ?>
                                    <i class="fas fa-chevron-down toggle-icon"></i>
                                </h4>
                                <div class="accordion-content">
                                    <div class="modules-grid">
                                        <?php foreach ($content['mms_nb_modules'] as $module): ?>
                                        <div class="module-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo $module; ?></span>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="srm-content">
                        <div class="software-image">
                            <img src="assets/images/mms-srm.jpg" alt="MMS Ship Repair and Maintenance">
                        </div>
                        <div class="software-description">
                            <h3>MMS SRM (Ship Repair and Maintenance)</h3>
                            <p><?php echo $content['mms_srm_description']; ?></p>
                            
                            <div class="module-accordion">
                                <h4 class="accordion-title">
                                    <i class="fas fa-cubes"></i>
                                    <?php echo $translations['modules']; ?>
                                    <i class="fas fa-chevron-down toggle-icon"></i>
                                </h4>
                                <div class="accordion-content">
                                    <div class="modules-grid">
                                        <?php foreach ($content['mms_srm_modules'] as $module): ?>
                                        <div class="module-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo $module; ?></span>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="yacht-content">
                        <div class="software-image">
                            <img src="assets/images/mms-yacht.jpg" alt="MMS Yacht Building">
                        </div>
                        <div class="software-description">
                            <h3>MMS Yacht (Yacht Building)</h3>
                            <p><?php echo $content['mms_yacht_description']; ?></p>
                            
                            <div class="module-accordion">
                                <h4 class="accordion-title">
                                    <i class="fas fa-cubes"></i>
                                    <?php echo $translations['modules']; ?>
                                    <i class="fas fa-chevron-down toggle-icon"></i>
                                </h4>
                                <div class="accordion-content">
                                    <div class="modules-grid">
                                        <?php foreach ($content['mms_yacht_modules'] as $module): ?>
                                        <div class="module-item">
                                            <i class="fas fa-check"></i>
                                            <span><?php echo $module; ?></span>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Solutions & Features Section -->
    <section id="solutions" class="section solutions-section">
        <div class="section-background">
            <div class="bg-shape-alt"></div>
        </div>
        
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title"><?php echo $translations['solutions_title']; ?></h2>
                <div class="title-underline"></div>
                <p class="section-subtitle"><?php echo $content['solutions_subtitle']; ?></p>
            </div>
            
            <div class="solutions-grid">
                <?php foreach ($content['solutions'] as $index => $solution): ?>
                <div class="solution-item" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <div class="solution-icon">
                        <i class="<?php echo $solution['icon']; ?>"></i>
                    </div>
                    <h3 class="solution-title"><?php echo $solution['title']; ?></h3>
                    <p class="solution-text"><?php echo $solution['description']; ?></p>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="divider"></div>
            
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title"><?php echo $translations['features_title']; ?></h2>
                <div class="title-underline"></div>
            </div>
            
            <div class="features-container">
                <div class="features-image" data-aos="fade-right">
                    <img src="assets/images/features.jpg" alt="MMS Features">
                    <div class="floating-badge">
                        <span class="badge-icon"><i class="fas fa-star"></i></span>
                        <span class="badge-text"><?php echo $translations['unique_solutions']; ?></span>
                    </div>
                </div>
                
                <div class="features-content" data-aos="fade-left">
                    <div class="features-list">
                        <?php foreach ($content['features'] as $feature): ?>
                        <div class="feature-item">
                            <div class="feature-icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="feature-text">
                                <h4><?php echo $feature['title']; ?></h4>
                                <p><?php echo $feature['description']; ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Packages Section -->
    <section id="packages" class="section packages-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title"><?php echo $translations['packages']; ?></h2>
                <div class="title-underline"></div>
            </div>
            
            <div class="packages-toggle" data-aos="fade-up">
                <span class="toggle-label active"><?php echo $translations['monthly']; ?></span>
                <label class="switch">
                    <input type="checkbox" id="pricing-toggle">
                    <span class="slider round"></span>
                </label>
                <span class="toggle-label"><?php echo $translations['annual']; ?></span>
                <span class="discount-badge"><?php echo $translations['save']; ?> 20%</span>
            </div>
            
            <div class="packages-container">
                <?php foreach ($content['packages'] as $index => $package): ?>
                <div class="package-card" data-aos="fade-up" data-aos-delay="<?php echo $index * 100; ?>">
                    <?php if ($package['popular']): ?>
                    <div class="popular-badge"><?php echo $translations['most_popular']; ?></div>
                    <?php endif; ?>
                    
                    <div class="package-header">
                        <h3 class="package-title"><?php echo $package['title']; ?></h3>
                        <div class="package-price">
                            <div class="price monthly active">
                                <span class="currency">$</span>
                                <span class="amount"><?php echo $package['monthly_price']; ?></span>
                                <span class="period">/<?php echo $translations['month']; ?></span>
                            </div>
                            <div class="price annual">
                                <span class="currency">$</span>
                                <span class="amount"><?php echo $package['annual_price']; ?></span>
                                <span class="period">/<?php echo $translations['year']; ?></span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="package-features">
                        <ul>
                            <?php foreach ($package['features'] as $feature): ?>
                            <li>
                                <i class="fas fa-check"></i>
                                <span><?php echo $feature; ?></span>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    
                    <div class="package-footer">
                        <a href="#" class="package-btn <?php echo $package['popular'] ? 'primary-btn' : 'outline-btn'; ?>" data-toggle="modal" data-target="demo-modal">
                            <?php echo $translations['get_started']; ?>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Technical & Team Section -->
    <section id="technical" class="section technical-section">
        <div class="section-background">
            <div class="bg-shape"></div>
            <div class="bg-dots"></div>
        </div>
        
        <div class="container">
            <div class="row">
                <div class="col" data-aos="fade-right">
                    <div class="content-block technical-block">
                        <h2 class="block-title"><?php echo $translations['technical_feasibility']; ?></h2>
                        <div class="title-underline left-align"></div>
                        
                        <div class="tech-list">
                            <?php foreach ($content['technical_features'] as $feature): ?>
                            <div class="tech-item">
                                <div class="tech-icon">
                                    <i class="<?php echo $feature['icon']; ?>"></i>
                                </div>
                                <div class="tech-content">
                                    <h4><?php echo $feature['title']; ?></h4>
                                    <p><?php echo $feature['description']; ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="technologies-used">
                            <h4><?php echo $translations['technologies_used']; ?></h4>
                            <div class="tech-logos">
                                <span class="tech-logo"><i class="fab fa-java"></i></span>
                                <span class="tech-logo"><i class="fab fa-python"></i></span>
                                <span class="tech-logo"><i class="fab fa-js"></i></span>
                                <span class="tech-logo"><i class="fab fa-html5"></i></span>
                                <span class="tech-logo"><i class="fab fa-css3-alt"></i></span>
                                <span class="tech-logo"><i class="fab fa-aws"></i></span>
                                <span class="tech-logo"><i class="fab fa-docker"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col" data-aos="fade-left">
                    <div class="content-block team-block">
                        <h2 class="block-title"><?php echo $translations['team_competencies']; ?></h2>
                        <div class="title-underline left-align"></div>
                        
                        <div class="team-skills">
                            <?php foreach ($content['team_skills'] as $skill): ?>
                            <div class="skill">
                                <div class="skill-name">
                                    <i class="<?php echo $skill['icon']; ?>"></i>
                                    <span><?php echo $skill['name']; ?></span>
                                </div>
                                <div class="skill-bar">
                                    <div class="skill-progress" data-percentage="<?php echo $skill['percentage']; ?>"></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class="team-info">
                            <div class="team-stat">
                                <div class="stat-number">15+</div>
                                <div class="stat-text"><?php echo $translations['years_experience']; ?></div>
                            </div>
                            <div class="team-stat">
                                <div class="stat-number">ITU</div>
                                <div class="stat-text"><?php echo $translations['graduate_engineers']; ?></div>
                            </div>
                            <div class="team-stat">
                                <div class="stat-number">24/7</div>
                                <div class="stat-text"><?php echo $translations['support']; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Call to Action Section -->
    <section id="cta" class="section cta-section">
        <div class="container">
            <div class="cta-content" data-aos="fade-up">
                <h2 class="cta-title"><?php echo $translations['request_demo_title']; ?></h2>
                <p class="cta-text"><?php echo $translations['request_demo_text']; ?></p>
                <a href="#" class="cta-btn primary-btn pulse-btn" data-toggle="modal" data-target="demo-modal">
                    <?php echo $translations['request_demo']; ?>
                </a>
            </div>
        </div>
        
        <div class="cta-waves">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#ffffff" fill-opacity="1" d="M0,96L48,128C96,160,192,224,288,218.7C384,213,480,139,576,128C672,117,768,171,864,197.3C960,224,1056,224,1152,197.3C1248,171,1344,117,1392,90.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>
    
    <!-- Contact Section -->
    <section id="contact" class="section contact-section">
        <div class="container">
            <div class="section-header" data-aos="fade-up">
                <h2 class="section-title"><?php echo $translations['contact']; ?></h2>
                <div class="title-underline"></div>
            </div>
            
            <div class="contact-container">
                <div class="contact-info" data-aos="fade-right">
                    <div class="info-card">
                        <div class="card-header">
                            <i class="fas fa-map-marker-alt"></i>
                            <h3><?php echo $translations['our_location']; ?></h3>
                        </div>
                        <p>Bilişim Vadisi - Kocaeli</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="card-header">
                            <i class="fas fa-envelope"></i>
                            <h3><?php echo $translations['email_us']; ?></h3>
                        </div>
                        <p>info@marinemanagementsystem.com</p>
                    </div>
                    
                    <div class="info-card">
                        <div class="card-header">
                            <i class="fas fa-phone-alt"></i>
                            <h3><?php echo $translations['call_us']; ?></h3>
                        </div>
                        <p>+90 507 574 2666</p>
                    </div>
                    
                    <div class="social-links">
                        <a href="https://www.instagram.com/marinemanagementsystem/" target="_blank" class="social-link instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="https://www.linkedin.com/company/mms-erp" target="_blank" class="social-link linkedin">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://www.facebook.com/profile.php?id=61560348505866" target="_blank" class="social-link facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://wa.me/+905075742666" target="_blank" class="social-link whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
                
                <div class="contact-form-container" data-aos="fade-left">
                    <form id="contact-form" class="contact-form" action="process_form.php" method="post">
                        <input type="hidden" name="contact_form" value="1">
                        
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input type="text" name="name" id="name" placeholder="<?php echo $translations['name']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <input type="email" name="email" id="email" placeholder="<?php echo $translations['email']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fas fa-phone-alt"></i>
                                </div>
                                <input type="tel" name="phone" id="phone" placeholder="<?php echo $translations['phone']; ?>" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-icon">
                                    <i class="fas fa-edit"></i>
                                </div>
                                <textarea name="message" id="message" placeholder="<?php echo $translations['message']; ?>" required></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="submit-btn primary-btn">
                                <i class="fas fa-paper-plane"></i>
                                <?php echo $translations['send_message']; ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="map-container" data-aos="fade-up">
                <div id="contact-map"></div>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="footer-widgets">
                    <div class="footer-widget">
                        <div class="footer-logo">
                            <img src="assets/images/logo.png" alt="MMS Logo">
                        </div>
                        <p class="footer-description"><?php echo $translations['footer_description']; ?></p>
                    </div>
                    
                    <div class="footer-widget">
                        <h3 class="widget-title"><?php echo $translations['quick_links']; ?></h3>
                        <ul class="footer-links">
                            <li><a href="#hero"><?php echo $translations['home']; ?></a></li>
                            <li><a href="#about"><?php echo $translations['about_us']; ?></a></li>
                            <li><a href="#software"><?php echo $translations['our_software']; ?></a></li>
                            <li><a href="#packages"><?php echo $translations['packages']; ?></a></li>
                            <li><a href="#contact"><?php echo $translations['contact']; ?></a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-widget">
                        <h3 class="widget-title"><?php echo $translations['software']; ?></h3>
                        <ul class="footer-links">
                            <li><a href="#software" data-tab="nb">MMS NB</a></li>
                            <li><a href="#software" data-tab="srm">MMS SRM</a></li>
                            <li><a href="#software" data-tab="yacht">MMS Yacht</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-widget">
                        <h3 class="widget-title"><?php echo $translations['contact_us']; ?></h3>
                        <ul class="footer-contact">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Bilişim Vadisi - Kocaeli</span>
                            </li>
                            <li>
                                <i class="fas fa-phone-alt"></i>
                                <span>+90 507 574 2666</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>info@marinemanagementsystem.com</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="container">
                <div class="copyright">
                    <p>&copy; <?php echo date('Y'); ?> Marine Management System (MMS). <?php echo $translations['all_rights_reserved']; ?></p>
                    <a href="admin/" class="admin-link" style="font-size: 10px; color: #999; text-decoration: none; display: inline-block; margin-top: 5px;">admin</a>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Back to Top Button -->
    <a href="#" class="back-to-top">
        <i class="fas fa-chevron-up"></i>
    </a>
    
    <!-- Demo Request Modal -->
    <div id="demo-modal" class="modal">
        <div class="modal-overlay"></div>
        <div class="modal-container">
            <div class="modal-header">
                <h3 class="modal-title"><?php echo $translations['request_demo']; ?></h3>
                <button class="modal-close" data-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body">
                <form id="demo-form" class="demo-form" action="process_form.php" method="post">
                    <input type="hidden" name="demo_request" value="1">
                    
                    <div class="form-group">
                        <label for="demo-name"><?php echo $translations['name']; ?></label>
                        <input type="text" name="name" id="demo-name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="demo-surname"><?php echo $translations['surname']; ?></label>
                        <input type="text" name="surname" id="demo-surname" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="demo-email"><?php echo $translations['email']; ?></label>
                        <input type="email" name="email" id="demo-email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="demo-phone"><?php echo $translations['phone']; ?></label>
                        <input type="tel" name="phone" id="demo-phone" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="demo-message"><?php echo $translations['message']; ?></label>
                        <textarea name="message" id="demo-message" rows="4" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="primary-btn">
                            <?php echo $translations['submit']; ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Success Message Modal -->
    <div id="success-modal" class="modal">
        <div class="modal-overlay"></div>
        <div class="modal-container small-modal">
            <div class="modal-header">
                <button class="modal-close" data-dismiss="modal">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="modal-body text-center">
                <div class="success-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="success-title"><?php echo $translations['thank_you']; ?></h3>
                <p class="success-message"><?php echo $translations['form_success']; ?></p>
                <button class="primary-btn" data-dismiss="modal">
                    <?php echo $translations['close']; ?>
                </button>
            </div>
        </div>
    </div>
    
    <!-- JS Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    
    <!-- Custom JS -->
    <script src="assets/js/main.js"></script>
    <script src="assets/js/animations.js"></script>
    <script src="assets/js/language.js"></script>
    
    <script>
        // Initialize map
        var map = L.map('contact-map').setView([40.78062044878368, 29.503669767558726], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        var marker = L.marker([40.78062044878368, 29.503669767558726]).addTo(map)
            .bindPopup("<b>MMS</b><br>Bilişim Vadisi, Kocaeli").openPopup();
        
        // Form submission handlers
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // In a real implementation, you'd handle the AJAX form submission here
                // For this example, we'll just show the success modal
                document.getElementById('success-modal').classList.add('show');
                
                // Reset the form
                form.reset();
                
                // If it's the demo form modal, close it
                if (form.id === 'demo-form') {
                    document.getElementById('demo-modal').classList.remove('show');
                }
            });
        });
        
        // Show success message if there's a form submission success
        <?php if (isset($_GET['success'])): ?>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('success-modal').classList.add('show');
        });
        <?php endif; ?>
    </script>
</body>
</html>