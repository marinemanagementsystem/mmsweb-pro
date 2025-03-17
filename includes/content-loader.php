<?php
/**
 * MMS - Marine Management System
 * Content Loader Functions
 */

/**
 * Get site content for specified language
 * 
 * @param string $language Language code
 * @return array Site content
 */
function get_site_content($language = 'tr') {
    // Veritabanı yerine sabit içerik kullanıyoruz
    // In a real implementation, this would fetch from the database
    // For this demonstration, we'll use hardcoded content
    
    $content = [];
    
    // About section content
    $content['about_text'] = ($language === 'tr') 
        ? 'Kurucularımız, farklı disiplinlerden gelen ve kendi alanlarında 15 yıla varan deneyime sahip İstanbul Teknik Üniversitesi mezunu bir Gemi Mühendisi ile Bilgisayar ve Elektrik-Elektronik Mühendislerinden oluşmaktadır. Bu ekip, yenilikçi ve sektöre özgü bir yaklaşımla geliştirdiği ERP yazılımıyla özgün çözümler sunan bir yazılım şirketi olarak faaliyet göstermektedir. İnovasyona ve kaliteye odaklanan genç girişimcilerin bir araya gelmesiyle oluşan şirketimiz, sektördeki ihtiyaçlara yenilikçi ve etkili çözümler sunmayı hedeflemektedir.'
        : 'Our founders are a team of Istanbul Technical University graduates from various disciplines, including a Naval Architect, Computer Engineer, and Electrical-Electronics Engineer, each with up to 15 years of experience. This team operates as a software company, offering unique solutions with its innovative and industry-specific ERP software. Formed by young entrepreneurs focused on innovation and quality, our company aims to provide innovative and effective solutions to the needs of the sector.';
    
    // Vision section content
    $content['vision_text'] = ($language === 'tr')
        ? 'Müşterilerimize sektördeki en yenilikçi, özgün ve etkili ERP çözümlerini sunarak, gemi inşaat süreçlerini daha verimli, şeffaf ve sürdürülebilir hale getirmeyi amaçlıyoruz. Müşteri ihtiyaçlarına odaklanarak, gelişen teknolojiyi yakından takip ediyor ve iş süreçlerini optimize etmelerine destek oluyoruz.'
        : 'By providing our clients with the industry\'s most innovative, original, and effective ERP solutions, we strive to enhance the efficiency, transparency, and sustainability of shipbuilding processes. With a client-centric approach, we keep a close eye on emerging technologies, offering continuous support in optimizing their operational workflows.';
    
    // Mission section content
    $content['mission_text'] = ($language === 'tr')
        ? 'MMS olarak, gemi inşaat sektöründeki karmaşık iş süreçlerini basitleştirmek ve geliştirmek amacıyla yenilikçi ERP çözümleri geliştiriyoruz. Müşterilerimize en üst düzeyde hizmet sunmak için teknolojik yeteneklerimizi kullanıyor ve sektöre özgü ihtiyaçlara uygun özelleştirilebilir çözümler sunuyoruz. Müşteri memnuniyetine odaklanarak, müşterilerimizin başarısını sürekli destekliyoruz.'
        : 'At MMS, we develop innovative ERP solutions to streamline and enhance complex business processes within the shipbuilding industry. Leveraging our technological expertise, we provide top-tier services to our clients, offering customizable solutions tailored to their specific needs. With a strong focus on customer satisfaction, we continuously support our clients\' success.';
    
    // Promises section content
    $content['promises_text'] = ($language === 'tr')
        ? 'Müşterilerimizin ihtiyaçlarına en uygun çözümleri sunarak, gemi inşaat sektöründe en yüksek verimliliği sağlamayı vaat ediyoruz. Sektördeki gelişmeleri yakından takip ederek, iş süreçlerinizi optimize edecek ve projelerinizin başarısını artıracak yenilikçi yazılımlar geliştiriyoruz.'
        : 'We promise to deliver the solutions best suited to our clients\' needs, ensuring maximum efficiency in the shipbuilding industry. By staying abreast of industry advancements, we develop innovative software that optimizes your business processes and enhances project success.';
    
    // Software section content
    $content['software_subtitle'] = ($language === 'tr')
        ? 'MMS, gemi inşa sektöründe faaliyet gösteren işletmeler için özel olarak geliştirilmiş bir (ERP) yönetim sistemidir. MMS SRM (Ship Repair and Maintance), MMS NB (New Building), MMS Yacht (Yacht Building) gibi yazılımlarımız vardır.'
        : 'MMS is an ERP (Enterprise Resource Planning) management system specifically developed for businesses operating in the shipbuilding industry. We offer various software solutions such as MMS SRM (Ship Repair and Maintenance), MMS NB (New Building), and MMS Yacht (Yacht Building).';
    
    $content['mms_nb_description'] = ($language === 'tr')
        ? 'MMS NB, yeni gemi inşa süreçlerini optimize etmek ve yönetmek için geliştirilmiş kapsamlı bir ERP çözümüdür. Tasarımdan teslimata kadar tüm projeyi tek bir platformda yönetmenizi sağlar.'
        : 'MMS NB is a comprehensive ERP solution developed to optimize and manage new shipbuilding processes. It allows you to manage the entire project from design to delivery on a single platform.';
    
    $content['mms_srm_description'] = ($language === 'tr')
        ? 'MMS SRM, gemi bakım ve onarım işlemleri için özel olarak tasarlanmış bir ERP çözümüdür. Tüm bakım-onarım süreçlerini dijitalleştirerek verimlilik ve şeffaflık sağlar.'
        : 'MMS SRM is an ERP solution specifically designed for ship maintenance and repair operations. It provides efficiency and transparency by digitalizing all maintenance and repair processes.';
    
    $content['mms_yacht_description'] = ($language === 'tr')
        ? 'MMS Yacht, özel yat ve tekne üretimi yapan işletmeler için geliştirilen özelleştirilmiş bir ERP çözümüdür. Lüks yat üretiminin tüm aşamalarını yönetmenizi sağlar.'
        : 'MMS Yacht is a customized ERP solution developed for businesses producing custom yachts and boats. It allows you to manage all stages of luxury yacht production.';
    
    // Modules for each software
    $content['mms_nb_modules'] = ($language === 'tr') 
        ? [
            'REMARK MODÜLÜ',
            'GEMI INSA ÜRETİM YONETIMI',
            'DİZAYN VE DÖKÜMAN MODÜLÜ',
            'TOPLANTI MODÜLÜ',
            'PROJE YÖNETİM MODÜLÜ',
            'İMALAT MODULÜ',
            'PLANLAMA MODÜLÜ',
            'TEKNİK SATINALMA MODÜLÜ',
            'SATIŞ, GARANTİ VE SERVİS MODÜLÜ',
            'MALZEME YÖNETİMİ MODÜLÜ',
            'TAŞERON YÖNETİM MODÜLÜ',
            'TERSANE YÖNETİM MODÜLÜ',
            'SATINALMA MODÜLÜ',
            'KALİTE KONTROL MODÜLÜ',
            'İŞ SAĞLIĞI VE GÜVENLİĞİ MODÜLÜ',
            'DEPOLAMA & NAKLİYE MODÜLÜ',
            'FİNANS VE MUHASEBE MODÜLÜ',
            'İNSAN KAYNAKLARI MODÜLÜ',
            'RİSK YÖNETİMİ MODÜLÜ',
            'TEKLİF/SÖZLEŞME YÖNETİMİ',
            'RAPOR YÖNETİMİ MODÜLÜ',
            'İŞ AKIŞ YÖNETİMİ',
            'EĞİTİM MODÜLÜ'
        ]
        : [
            'REMARK MODULE',
            'SHIPBUILDING PRODUCTION MANAGEMENT',
            'DESIGN AND DOCUMENT MODULE',
            'MEETING MODULE',
            'PROJECT MANAGEMENT MODULE',
            'MANUFACTURING MODULE',
            'PLANNING MODULE',
            'TECHNICAL PURCHASING MODULE',
            'SALES, WARRANTY AND SERVICE MODULE',
            'MATERIAL MANAGEMENT MODULE',
            'SUBCONTRACTOR MANAGEMENT MODULE',
            'SHIPYARD MANAGEMENT MODULE',
            'PURCHASING MODULE',
            'QUALITY CONTROL MODULE',
            'OCCUPATIONAL HEALTH AND SAFETY MODULE',
            'STORAGE & TRANSPORTATION MODULE',
            'FINANCE AND ACCOUNTING MODULE',
            'HUMAN RESOURCES MODULE',
            'RISK MANAGEMENT MODULE',
            'PROPOSAL/CONTRACT MANAGEMENT',
            'REPORT MANAGEMENT MODULE',
            'WORKFLOW MANAGEMENT',
            'TRAINING MODULE'
        ];
    
    $content['mms_srm_modules'] = ($language === 'tr')
        ? [
            'MÜŞTERİ TAKİP MODÜLÜ',
            'PAZARLAMA, TEKLİF VE SÖZLEŞME YÖNETİMİ',
            'PLAN-KEŞİF-PROJE YÖNETİMİ',
            'TEDARİK YÖNETİMİ',
            'DEPOLAMA & NAKLİYE MODÜLÜ',
            'ATOLYE YÖNETİMİ',
            'ALT YÜKLENİCİ YÖNETİMİ',
            'ÜRETİM-İŞLETME YÖNETİMİ',
            'KALİTE- KONTROL YÖNETİMİ',
            'DİZAYN-DÖKÜMAN YÖNETİMİ',
            'FİNANS MODÜLÜ',
            'TOPLANTI MODÜLÜ',
            'MALZEME YÖNETİMİ MODÜLÜ',
            'TERSANE YÖNETİM MODÜLÜ',
            'RİSK YÖNETİMİ MODÜLÜ',
            'RAPOR YÖNETİMİ MODÜLÜ',
            'İŞ AKIŞ YÖNETİMİ',
            'İNSAN KAYNAKLARI MODÜLÜ',
            'İŞ SAĞLIĞI VE GÜVENLİĞİ MODÜLÜ',
            'EĞİTİM MODÜLÜ'
        ]
        : [
            'CUSTOMER TRACKING MODULE',
            'MARKETING, PROPOSAL AND CONTRACT MANAGEMENT',
            'PLAN-SURVEY-PROJECT MANAGEMENT',
            'SUPPLY MANAGEMENT',
            'STORAGE & TRANSPORTATION MODULE',
            'WORKSHOP MANAGEMENT',
            'SUBCONTRACTOR MANAGEMENT',
            'PRODUCTION-OPERATION MANAGEMENT',
            'QUALITY-CONTROL MANAGEMENT',
            'DESIGN-DOCUMENT MANAGEMENT',
            'FINANCE MODULE',
            'MEETING MODULE',
            'MATERIAL MANAGEMENT MODULE',
            'SHIPYARD MANAGEMENT MODULE',
            'RISK MANAGEMENT MODULE',
            'REPORT MANAGEMENT MODULE',
            'WORKFLOW MANAGEMENT',
            'HUMAN RESOURCES MODULE',
            'OCCUPATIONAL HEALTH AND SAFETY MODULE',
            'TRAINING MODULE'
        ];
    
    $content['mms_yacht_modules'] = ($language === 'tr')
        ? [
            'MÜŞTERİ İLİŞKİLERİ YÖNETİMİ',
            'TEKLİF/SÖZLEŞME YÖNETİMİ',
            'YAT MİMARİ TAKİP MODÜLÜ',
            'PROJE YÖNETİM MODÜLÜ',
            'TASARIM VE MÜHENDİSLİK MODÜLÜ',
            'YAT ÜRETİM YÖNETİMİ',
            'ATOLYE YÖNETİMİ',
            'KALİTE- KONTROL YÖNETİMİ',
            'TEDARİK YÖNETİMİ',
            'DEPOLAMA YÖNETİMİ',
            'TERSANE YÖNETİM MODÜLÜ',
            'ALT YÜKLENİCİ YÖNETİMİ',
            'TOPLANTI MODÜLÜ',
            'İŞ SAĞLIĞI VE GÜVENLİĞİ MODÜLÜ',
            'İNSAN KAYNAKLARI MODÜLÜ',
            'FİNANS MODÜLÜ',
            'MALZEME YÖNETİMİ MODÜLÜ',
            'İŞ AKIŞ YÖNETİMİ',
            'RAPOR YÖNETİMİ MODÜLÜ',
            'EĞİTİM MODÜLÜ'
        ]
        : [
            'CUSTOMER RELATIONSHIP MANAGEMENT',
            'PROPOSAL/CONTRACT MANAGEMENT',
            'YACHT ARCHITECTURAL TRACKING MODULE',
            'PROJECT MANAGEMENT MODULE',
            'DESIGN AND ENGINEERING MODULE',
            'YACHT PRODUCTION MANAGEMENT',
            'WORKSHOP MANAGEMENT',
            'QUALITY-CONTROL MANAGEMENT',
            'SUPPLY MANAGEMENT',
            'STORAGE MANAGEMENT',
            'SHIPYARD MANAGEMENT MODULE',
            'SUBCONTRACTOR MANAGEMENT',
            'MEETING MODULE',
            'OCCUPATIONAL HEALTH AND SAFETY MODULE',
            'HUMAN RESOURCES MODULE',
            'FINANCE MODULE',
            'MATERIAL MANAGEMENT MODULE',
            'WORKFLOW MANAGEMENT',
            'REPORT MANAGEMENT MODULE',
            'TRAINING MODULE'
        ];
    
    // Solutions section
    $content['solutions_subtitle'] = ($language === 'tr')
        ? 'Gemi inşa sektörüne özgü çözümler sunan MMS, projelerin daha verimli, kontrollü ve karlı bir şekilde yönetilmesini sağlar.'
        : 'MMS offers specific solutions for the shipbuilding industry, enabling more efficient, controlled, and profitable project management.';
    
    $content['solutions'] = [
        [
            'title' => ($language === 'tr') ? 'Entegre Süreç Yönetimi' : 'Integrated Process Management',
            'icon' => 'fas fa-tasks fa-2x',
            'description' => ($language === 'tr')
                ? 'Gemi inşa sürecinin farklı aşamalarını ve bileşenlerini entegre bir platformda birleştirerek koordinasyonu sağlar ve operasyonel hataları minimize eder.'
                : 'Integrates different stages and components of the shipbuilding process on a single platform, ensuring coordination and minimizing operational errors.'
        ],
        [
            'title' => ($language === 'tr') ? 'Otomasyon ve Dijitalleşme' : 'Automation and Digitalization',
            'icon' => 'fas fa-robot fa-2x',
            'description' => ($language === 'tr')
                ? 'Manuel süreçleri otomatikleştirerek ve dijitalleştirerek zaman kayıplarını önler ve verimliliği artırır.'
                : 'Automates and digitalizes manual processes, preventing time loss and increasing efficiency.'
        ],
        [
            'title' => ($language === 'tr') ? 'Maliyet Kontrolü' : 'Cost Control',
            'icon' => 'fas fa-chart-line fa-2x',
            'description' => ($language === 'tr')
                ? 'Maliyetlerin etkin takibi ve yönetimi ile gereksiz harcamaların önüne geçerek karlılığı artırır.'
                : 'Increases profitability by preventing unnecessary expenses with effective cost tracking and management.'
        ],
        [
            'title' => ($language === 'tr') ? 'Rekabet Gücü ve İnovasyon' : 'Competitive Power and Innovation',
            'icon' => 'fas fa-rocket fa-2x',
            'description' => ($language === 'tr')
                ? 'Kullanıcı dostu arayüzü, gelişmiş özellikleri ve sürekli güncellenen yapısıyla işletmelere rekabet avantajı sağlar.'
                : 'Provides businesses with a competitive advantage through its user-friendly interface, advanced features and continuously updated structure.'
        ],
        [
            'title' => ($language === 'tr') ? 'Bilgi ve Veri Yönetimi' : 'Information and Data Management',
            'icon' => 'fas fa-database fa-2x',
            'description' => ($language === 'tr')
                ? 'Toplanan verilerin etkili yönetimi ve analizi ile stratejik karar alma süreçlerini destekler.'
                : 'Supports strategic decision-making processes through effective management and analysis of collected data.'
        ]
    ];
    
    // Features section
    $content['features'] = [
        [
            'title' => ($language === 'tr') ? 'Sektöre Özgü Çözümler' : 'Industry-Specific Solutions',
            'description' => ($language === 'tr')
                ? 'Gemi inşa süreçlerine ve terminolojisine tam uyumlu, sektöre özel modüller ve iş akışları sunar.'
                : 'Offers industry-specific modules and workflows fully compatible with shipbuilding processes and terminology.'
        ],
        [
            'title' => ($language === 'tr') ? 'Yerli Üretim' : 'Domestic Production',
            'description' => ($language === 'tr')
                ? 'Türkiye\'deki gemi inşa sektörünün ihtiyaçlarına ve dinamiklerine göre geliştirilmiş, Türkçe dil desteği sağlayan bir yazılımdır.'
                : 'Developed according to the needs and dynamics of the Turkish shipbuilding industry, it is software that provides Turkish language support.'
        ],
        [
            'title' => ($language === 'tr') ? 'Esneklik ve Ölçeklenebilirlik' : 'Flexibility and Scalability',
            'description' => ($language === 'tr')
                ? 'Modüler yapısı sayesinde işletmelerin ihtiyaçlarına göre özelleştirilebilir ve ölçeklenebilir.'
                : 'Customizable and scalable according to the needs of businesses thanks to its modular structure.'
        ],
        [
            'title' => ($language === 'tr') ? 'Kullanıcı Dostu Arayüz' : 'User-Friendly Interface',
            'description' => ($language === 'tr')
                ? 'Gemi inşa sektöründeki kullanıcıların iş yapış şekillerine uygun, basit ve anlaşılır bir arayüze sahiptir.'
                : 'It has a simple and understandable interface suitable for the working methods of users in the shipbuilding industry.'
        ],
        [
            'title' => ($language === 'tr') ? 'Rekabetçi Fiyatlandırma' : 'Competitive Pricing',
            'description' => ($language === 'tr')
                ? 'Yüksek maliyetli yabancı rakiplerine kıyasla rekabetçi fiyatlandırma modeliyle öne çıkar.'
                : 'Stands out with its competitive pricing model compared to its expensive foreign competitors.'
        ]
    ];
    
    // Packages section
    $content['packages'] = [
        [
            'title' => 'MMS Starter',
            'monthly_price' => '299',
            'annual_price' => '2,990',
            'popular' => false,
            'features' => ($language === 'tr')
                ? [
                    'Temel işlevler',
                    '5 modül',
                    '3 kullanıcı',
                    'E-posta desteği',
                    'Yıllık güncelleme'
                ]
                : [
                    'Basic functions',
                    '5 modules',
                    '3 users',
                    'Email support',
                    'Annual updates'
                ]
        ],
        [
            'title' => 'MMS Professional',
            'monthly_price' => '599',
            'annual_price' => '5,990',
            'popular' => true,
            'features' => ($language === 'tr')
                ? [
                    'İleri düzey çözümler',
                    '12 modül',
                    '10 kullanıcı',
                    '7/24 teknik destek',
                    'Aylık güncelleme',
                    'Özelleştirme seçenekleri'
                ]
                : [
                    'Advanced solutions',
                    '12 modules',
                    '10 users',
                    '24/7 technical support',
                    'Monthly updates',
                    'Customization options'
                ]
        ],
        [
            'title' => 'MMS Enterprise',
            'monthly_price' => '999',
            'annual_price' => '9,990',
            'popular' => false,
            'features' => ($language === 'tr')
                ? [
                    'En kapsamlı çözümler',
                    '20+ modül',
                    'Sınırsız kullanıcı',
                    'Öncelikli 7/24 destek',
                    'Özel eğitim oturumları',
                    'Tam özelleştirme',
                    'API entegrasyonu'
                ]
                : [
                    'Most comprehensive solutions',
                    '20+ modules',
                    'Unlimited users',
                    'Priority 24/7 support',
                    'Custom training sessions',
                    'Full customization',
                    'API integration'
                ]
        ]
    ];
    
    // Technical section
    $content['technical_features'] = [
        [
            'title' => ($language === 'tr') ? 'Kullanılan Teknolojiler' : 'Technologies Used',
            'icon' => 'fas fa-code',
            'description' => ($language === 'tr')
                ? 'Modern ve yaygın olarak kullanılan yazılım geliştirme teknolojileri ve araçları (Java, Python, JavaScript, MySQL, PostgreSQL, AWS, Azure, Google Cloud, Git, Jira, Confluence) kullanılarak geliştirilecektir.'
                : 'Will be developed using modern and commonly used software development technologies and tools (Java, Python, JavaScript, MySQL, PostgreSQL, AWS, Azure, Google Cloud, Git, Jira, Confluence).'
        ],
        [
            'title' => ($language === 'tr') ? 'Mevcut Altyapı Uyumluluğu' : 'Existing Infrastructure Compatibility',
            'icon' => 'fas fa-cloud',
            'description' => ($language === 'tr')
                ? 'Bulut tabanlı yapısı sayesinde işletmelerin karmaşık ve maliyetli donanım yatırımları yapmalarına gerek yoktur.'
                : 'Thanks to its cloud-based structure, businesses do not need to make complex and costly hardware investments.'
        ],
        [
            'title' => ($language === 'tr') ? 'Entegrasyon' : 'Integration',
            'icon' => 'fas fa-link',
            'description' => ($language === 'tr')
                ? 'Diğer yazılımlarla (muhasebe, CRM, tedarik zinciri vb.) entegre olabilecek şekilde tasarlanmıştır.'
                : 'Designed to be integrated with other software (accounting, CRM, supply chain, etc.).'
        ]
    ];
    
    // Team section
    $content['team_skills'] = [
        [
            'name' => ($language === 'tr') ? 'Yazılım Geliştirme' : 'Software Development',
            'icon' => 'fas fa-code',
            'percentage' => 95
        ],
        [
            'name' => ($language === 'tr') ? 'Gemi İnşa Sektörü Bilgisi' : 'Shipbuilding Industry Knowledge',
            'icon' => 'fas fa-ship',
            'percentage' => 90
        ],
        [
            'name' => ($language === 'tr') ? 'Veritabanı Yönetimi' : 'Database Management',
            'icon' => 'fas fa-database',
            'percentage' => 85
        ],
        [
            'name' => ($language === 'tr') ? 'Bulut Teknolojileri' : 'Cloud Technologies',
            'icon' => 'fas fa-cloud',
            'percentage' => 80
        ],
        [
            'name' => ($language === 'tr') ? 'Proje Yönetimi' : 'Project Management',
            'icon' => 'fas fa-tasks',
            'percentage' => 92
        ]
    ];
    
    // Conclusion section
    $content['conclusion_text'] = ($language === 'tr')
        ? 'MMS, gemi inşa sektörünün dinamiklerine uygun olarak geliştirilmiş, bulut tabanlı yapısıyla esneklik ve ölçeklenebilirlik sunan yenilikçi bir ERP çözümüdür. Sektördeki yerleşik yazılımların aksine, kullanıcı dostu arayüzü, gelişmiş raporlama ve analiz özellikleriyle öne çıkar. Yerli üretim olması, sektöre özel özelleştirilmiş başka yerli alternatiflerinin olmaması ve sürekli güncellenebilir yapısı, MMS\'i rakiplerinden ayıran ve Türk gemi inşa sektörüne rekabet avantajı sağlayan önemli unsurlardır.'
        : 'MMS is an innovative, cloud-based ERP solution developed in line with the dynamics of the shipbuilding industry, offering flexibility and scalability. Unlike established software in the sector, it stands out with its user-friendly interface and advanced reporting and analysis features. Being domestically produced, lacking other customized local alternatives specific to the sector, and its continuously updatable structure are important factors that distinguish MMS from its competitors and provide a competitive advantage to the Turkish shipbuilding industry.';
    
    return $content;
}

/**
 * Get section content for admin editor
 * 
 * @param string $section Section name
 * @param string $language Language code
 * @return array Section content
 */
function get_section_content($section, $language = 'tr') {
    // Get all content
    $all_content = get_site_content($language);
    
    // Filter content based on section
    $section_content = [];
    
    switch ($section) {
        case 'about':
            $section_content = [
                'about_text' => $all_content['about_text'] ?? ''
            ];
            break;
            
        case 'vision':
            $section_content = [
                'vision_text' => $all_content['vision_text'] ?? ''
            ];
            break;
            
        case 'mission':
            $section_content = [
                'mission_text' => $all_content['mission_text'] ?? ''
            ];
            break;
            
        case 'promises':
            $section_content = [
                'promises_text' => $all_content['promises_text'] ?? ''
            ];
            break;
            
        case 'software':
            $section_content = [
                'software_subtitle' => $all_content['software_subtitle'] ?? '',
                'mms_nb_description' => $all_content['mms_nb_description'] ?? '',
                'mms_srm_description' => $all_content['mms_srm_description'] ?? '',
                'mms_yacht_description' => $all_content['mms_yacht_description'] ?? '',
                'mms_nb_modules' => $all_content['mms_nb_modules'] ?? [],
                'mms_srm_modules' => $all_content['mms_srm_modules'] ?? [],
                'mms_yacht_modules' => $all_content['mms_yacht_modules'] ?? []
            ];
            break;
            
        case 'solutions':
            $section_content = [
                'solutions_subtitle' => $all_content['solutions_subtitle'] ?? '',
                'solutions' => $all_content['solutions'] ?? []
            ];
            break;
            
        case 'features':
            $section_content = [
                'features' => $all_content['features'] ?? []
            ];
            break;
            
        case 'packages':
            $section_content = [
                'packages' => $all_content['packages'] ?? []
            ];
            break;
            
        case 'technical':
            $section_content = [
                'technical_features' => $all_content['technical_features'] ?? []
            ];
            break;
            
        case 'team':
            $section_content = [
                'team_skills' => $all_content['team_skills'] ?? []
            ];
            break;
            
        case 'conclusion':
            $section_content = [
                'conclusion_text' => $all_content['conclusion_text'] ?? ''
            ];
            break;
            
        default:
            // Return all content if section not found
            $section_content = $all_content;
            break;
    }
    
    return $section_content;
}

/**
 * Update content in the database
 * 
 * @param string $section Section name
 * @param string $language Language code
 * @param array $content Content to update
 * @return bool Success status
 */
function update_content($section, $language, $content) {
    // In a real implementation, this would update the database
    
    // For demonstration purposes, log the update
    error_log('Content update request for section: ' . $section . ', language: ' . $language);
    error_log('Content data: ' . json_encode($content));
    
    return true;
}
