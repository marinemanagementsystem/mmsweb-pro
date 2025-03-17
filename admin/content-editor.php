<?php
/**
 * MMS - Marine Management System
 * Content Editor Page
 */

// Initialize the application
require_once '../includes/init.php';

// Check if user is logged in
if (!is_admin_logged_in()) {
    redirect('index.php');
}

// Handle form submission
$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['save_content'])) {
        // Save content updates to database
        $section = sanitize_input($_POST['section']);
        $language = sanitize_input($_POST['language']);
        $content_updates = $_POST['content'];
        
        // Save content updates
        if (update_content($section, $language, $content_updates)) {
            $message = 'Content updated successfully!';
            $message_type = 'success';
        } else {
            $message = 'Error updating content. Please try again.';
            $message_type = 'error';
        }
    }
}

// Get available languages
$languages = get_available_languages();

// Get current language (default to Turkish)
$current_language = $_GET['language'] ?? 'tr';

// Get current section (default to About)
$current_section = $_GET['section'] ?? 'about';

// Get content for current section and language
$section_content = get_section_content($current_section, $current_language);

// Include header
include_once 'includes/header.php';
?>

<!-- Main Content -->
<div class="admin-content">
    <div class="content-header">
        <h1 class="page-title">Content Management</h1>
        
        <div class="content-actions">
            <select id="language-selector" class="language-select" onchange="changeLanguage(this.value)">
                <?php foreach ($languages as $code => $name): ?>
                <option value="<?php echo $code; ?>" <?php echo $current_language === $code ? 'selected' : ''; ?>>
                    <?php echo $name; ?>
                </option>
                <?php endforeach; ?>
            </select>
            
            <button class="primary-btn" id="save-all-button">
                <i class="fas fa-save btn-icon"></i>
                Save All Changes
            </button>
        </div>
    </div>
    
    <?php if (!empty($message)): ?>
    <div class="alert <?php echo $message_type; ?>">
        <i class="fas fa-<?php echo $message_type === 'success' ? 'check-circle' : 'exclamation-circle'; ?>"></i>
        <?php echo $message; ?>
        <button class="alert-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
    <?php endif; ?>
    
    <div class="section-tabs">
        <a href="?section=about&language=<?php echo $current_language; ?>" class="section-tab <?php echo $current_section === 'about' ? 'active' : ''; ?>">About Us</a>
        <a href="?section=vision&language=<?php echo $current_language; ?>" class="section-tab <?php echo $current_section === 'vision' ? 'active' : ''; ?>">Vision</a>
        <a href="?section=mission&language=<?php echo $current_language; ?>" class="section-tab <?php echo $current_section === 'mission' ? 'active' : ''; ?>">Mission</a>
        <a href="?section=promises&language=<?php echo $current_language; ?>" class="section-tab <?php echo $current_section === 'promises' ? 'active' : ''; ?>">Promises</a>
        <a href="?section=software&language=<?php echo $current_language; ?>" class="section-tab <?php echo $current_section === 'software' ? 'active' : ''; ?>">Software</a>
        <a href="?section=solutions&language=<?php echo $current_language; ?>" class="section-tab <?php echo $current_section === 'solutions' ? 'active' : ''; ?>">Solutions</a>
        <a href="?section=features&language=<?php echo $current_language; ?>" class="section-tab <?php echo $current_section === 'features' ? 'active' : ''; ?>">Features</a>
        <a href="?section=packages&language=<?php echo $current_language; ?>" class="section-tab <?php echo $current_section === 'packages' ? 'active' : ''; ?>">Packages</a>
        <a href="?section=technical&language=<?php echo $current_language; ?>" class="section-tab <?php echo $current_section === 'technical' ? 'active' : ''; ?>">Technical</a>
        <a href="?section=team&language=<?php echo $current_language; ?>" class="section-tab <?php echo $current_section === 'team' ? 'active' : ''; ?>">Team</a>
        <a href="?section=conclusion&language=<?php echo $current_language; ?>" class="section-tab <?php echo $current_section === 'conclusion' ? 'active' : ''; ?>">Conclusion</a>
    </div>
    
    <form id="content-form" method="post" action="">
        <input type="hidden" name="section" value="<?php echo $current_section; ?>">
        <input type="hidden" name="language" value="<?php echo $current_language; ?>">
        
        <div class="content-editor">
            <div class="editor-toolbar">
                <div class="toolbar-group">
                    <button type="button" class="toolbar-button" data-command="bold" title="Bold">
                        <i class="fas fa-bold"></i>
                    </button>
                    <button type="button" class="toolbar-button" data-command="italic" title="Italic">
                        <i class="fas fa-italic"></i>
                    </button>
                    <button type="button" class="toolbar-button" data-command="underline" title="Underline">
                        <i class="fas fa-underline"></i>
                    </button>
                </div>
                
                <div class="toolbar-group">
                    <button type="button" class="toolbar-button" data-command="justifyLeft" title="Align Left">
                        <i class="fas fa-align-left"></i>
                    </button>
                    <button type="button" class="toolbar-button" data-command="justifyCenter" title="Align Center">
                        <i class="fas fa-align-center"></i>
                    </button>
                    <button type="button" class="toolbar-button" data-command="justifyRight" title="Align Right">
                        <i class="fas fa-align-right"></i>
                    </button>
                </div>
                
                <div class="toolbar-group">
                    <button type="button" class="toolbar-button" data-command="insertUnorderedList" title="Bullet List">
                        <i class="fas fa-list-ul"></i>
                    </button>
                    <button type="button" class="toolbar-button" data-command="insertOrderedList" title="Numbered List">
                        <i class="fas fa-list-ol"></i>
                    </button>
                </div>
                
                <div class="toolbar-group">
                    <button type="button" class="toolbar-button" data-command="createLink" title="Insert Link">
                        <i class="fas fa-link"></i>
                    </button>
                    <button type="button" class="toolbar-button" data-command="unlink" title="Remove Link">
                        <i class="fas fa-unlink"></i>
                    </button>
                </div>
                
                <select class="toolbar-select" data-command="formatBlock">
                    <option value="">-- Format --</option>
                    <option value="h1">Heading 1</option>
                    <option value="h2">Heading 2</option>
                    <option value="h3">Heading 3</option>
                    <option value="h4">Heading 4</option>
                    <option value="p">Paragraph</option>
                    <option value="blockquote">Quote</option>
                </select>
            </div>
            
            <div class="editor-content">
                <?php if ($current_section === 'about'): ?>
                <!-- About Us Section Content -->
                <div class="content-field">
                    <label for="about_text">About Us Text</label>
                    <textarea name="content[about_text]" id="about_text" class="wysiwyg-editor"><?php echo $section_content['about_text'] ?? ''; ?></textarea>
                </div>
                
                <?php elseif ($current_section === 'vision'): ?>
                <!-- Vision Section Content -->
                <div class="content-field">
                    <label for="vision_text">Vision Text</label>
                    <textarea name="content[vision_text]" id="vision_text" class="wysiwyg-editor"><?php echo $section_content['vision_text'] ?? ''; ?></textarea>
                </div>
                
                <?php elseif ($current_section === 'mission'): ?>
                <!-- Mission Section Content -->
                <div class="content-field">
                    <label for="mission_text">Mission Text</label>
                    <textarea name="content[mission_text]" id="mission_text" class="wysiwyg-editor"><?php echo $section_content['mission_text'] ?? ''; ?></textarea>
                </div>
                
                <?php elseif ($current_section === 'promises'): ?>
                <!-- Promises Section Content -->
                <div class="content-field">
                    <label for="promises_text">Promises Text</label>
                    <textarea name="content[promises_text]" id="promises_text" class="wysiwyg-editor"><?php echo $section_content['promises_text'] ?? ''; ?></textarea>
                </div>
                
                <?php elseif ($current_section === 'software'): ?>
                <!-- Software Section Content -->
                <div class="content-field">
                    <label for="software_subtitle">Software Subtitle</label>
                    <textarea name="content[software_subtitle]" id="software_subtitle" class="wysiwyg-editor"><?php echo $section_content['software_subtitle'] ?? ''; ?></textarea>
                </div>
                
                <div class="content-field">
                    <label for="mms_nb_description">MMS NB Description</label>
                    <textarea name="content[mms_nb_description]" id="mms_nb_description" class="wysiwyg-editor"><?php echo $section_content['mms_nb_description'] ?? ''; ?></textarea>
                </div>
                
                <div class="content-field">
                    <label for="mms_srm_description">MMS SRM Description</label>
                    <textarea name="content[mms_srm_description]" id="mms_srm_description" class="wysiwyg-editor"><?php echo $section_content['mms_srm_description'] ?? ''; ?></textarea>
                </div>
                
                <div class="content-field">
                    <label for="mms_yacht_description">MMS Yacht Description</label>
                    <textarea name="content[mms_yacht_description]" id="mms_yacht_description" class="wysiwyg-editor"><?php echo $section_content['mms_yacht_description'] ?? ''; ?></textarea>
                </div>
                
                <?php elseif ($current_section === 'solutions'): ?>
                <!-- Solutions Section Content -->
                <div class="content-field">
                    <label for="solutions_subtitle">Solutions Subtitle</label>
                    <textarea name="content[solutions_subtitle]" id="solutions_subtitle" class="wysiwyg-editor"><?php echo $section_content['solutions_subtitle'] ?? ''; ?></textarea>
                </div>
                
                <!-- Solution Items -->
                <?php if (isset($section_content['solutions']) && is_array($section_content['solutions'])): ?>
                <?php foreach ($section_content['solutions'] as $index => $solution): ?>
                <div class="solution-item-editor">
                    <h3>Solution #<?php echo $index + 1; ?></h3>
                    
                    <div class="content-field">
                        <label for="solution_title_<?php echo $index; ?>">Title</label>
                        <input type="text" name="content[solutions][<?php echo $index; ?>][title]" id="solution_title_<?php echo $index; ?>" value="<?php echo $solution['title']; ?>">
                    </div>
                    
                    <div class="content-field">
                        <label for="solution_icon_<?php echo $index; ?>">Icon Class</label>
                        <input type="text" name="content[solutions][<?php echo $index; ?>][icon]" id="solution_icon_<?php echo $index; ?>" value="<?php echo $solution['icon']; ?>">
                    </div>
                    
                    <div class="content-field">
                        <label for="solution_description_<?php echo $index; ?>">Description</label>
                        <textarea name="content[solutions][<?php echo $index; ?>][description]" id="solution_description_<?php echo $index; ?>" class="wysiwyg-editor"><?php echo $solution['description']; ?></textarea>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                
                <?php elseif ($current_section === 'features'): ?>
                <!-- Features Section Content -->
                
                <!-- Feature Items -->
                <?php if (isset($section_content['features']) && is_array($section_content['features'])): ?>
                <?php foreach ($section_content['features'] as $index => $feature): ?>
                <div class="feature-item-editor">
                    <h3>Feature #<?php echo $index + 1; ?></h3>
                    
                    <div class="content-field">
                        <label for="feature_title_<?php echo $index; ?>">Title</label>
                        <input type="text" name="content[features][<?php echo $index; ?>][title]" id="feature_title_<?php echo $index; ?>" value="<?php echo $feature['title']; ?>">
                    </div>
                    
                    <div class="content-field">
                        <label for="feature_description_<?php echo $index; ?>">Description</label>
                        <textarea name="content[features][<?php echo $index; ?>][description]" id="feature_description_<?php echo $index; ?>" class="wysiwyg-editor"><?php echo $feature['description']; ?></textarea>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                
                <?php elseif ($current_section === 'packages'): ?>
                <!-- Packages Section Content -->
                
                <!-- Package Items -->
                <?php if (isset($section_content['packages']) && is_array($section_content['packages'])): ?>
                <?php foreach ($section_content['packages'] as $index => $package): ?>
                <div class="package-item-editor">
                    <h3>Package #<?php echo $index + 1; ?></h3>
                    
                    <div class="content-field">
                        <label for="package_title_<?php echo $index; ?>">Title</label>
                        <input type="text" name="content[packages][<?php echo $index; ?>][title]" id="package_title_<?php echo $index; ?>" value="<?php echo $package['title']; ?>">
                    </div>
                    
                    <div class="content-field">
                        <label for="package_monthly_price_<?php echo $index; ?>">Monthly Price</label>
                        <input type="text" name="content[packages][<?php echo $index; ?>][monthly_price]" id="package_monthly_price_<?php echo $index; ?>" value="<?php echo $package['monthly_price']; ?>">
                    </div>
                    
                    <div class="content-field">
                        <label for="package_annual_price_<?php echo $index; ?>">Annual Price</label>
                        <input type="text" name="content[packages][<?php echo $index; ?>][annual_price]" id="package_annual_price_<?php echo $index; ?>" value="<?php echo $package['annual_price']; ?>">
                    </div>
                    
                    <div class="content-field">
                        <label for="package_popular_<?php echo $index; ?>">Popular Package?</label>
                        <select name="content[packages][<?php echo $index; ?>][popular]" id="package_popular_<?php echo $index; ?>">
                            <option value="0" <?php echo !$package['popular'] ? 'selected' : ''; ?>>No</option>
                            <option value="1" <?php echo $package['popular'] ? 'selected' : ''; ?>>Yes</option>
                        </select>
                    </div>
                    
                    <div class="content-field">
                        <label for="package_features_<?php echo $index; ?>">Features (one per line)</label>
                        <textarea name="content[packages][<?php echo $index; ?>][features_text]" id="package_features_<?php echo $index; ?>" rows="6"><?php echo implode("\n", $package['features']); ?></textarea>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                
                <?php elseif ($current_section === 'technical'): ?>
                <!-- Technical Section Content -->
                
                <!-- Technical Features -->
                <?php if (isset($section_content['technical_features']) && is_array($section_content['technical_features'])): ?>
                <?php foreach ($section_content['technical_features'] as $index => $feature): ?>
                <div class="technical-item-editor">
                    <h3>Technical Feature #<?php echo $index + 1; ?></h3>
                    
                    <div class="content-field">
                        <label for="technical_title_<?php echo $index; ?>">Title</label>
                        <input type="text" name="content[technical_features][<?php echo $index; ?>][title]" id="technical_title_<?php echo $index; ?>" value="<?php echo $feature['title']; ?>">
                    </div>
                    
                    <div class="content-field">
                        <label for="technical_icon_<?php echo $index; ?>">Icon Class</label>
                        <input type="text" name="content[technical_features][<?php echo $index; ?>][icon]" id="technical_icon_<?php echo $index; ?>" value="<?php echo $feature['icon']; ?>">
                    </div>
                    
                    <div class="content-field">
                        <label for="technical_description_<?php echo $index; ?>">Description</label>
                        <textarea name="content[technical_features][<?php echo $index; ?>][description]" id="technical_description_<?php echo $index; ?>" class="wysiwyg-editor"><?php echo $feature['description']; ?></textarea>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                
                <?php elseif ($current_section === 'team'): ?>
                <!-- Team Section Content -->
                
                <!-- Team Skills -->
                <?php if (isset($section_content['team_skills']) && is_array($section_content['team_skills'])): ?>
                <?php foreach ($section_content['team_skills'] as $index => $skill): ?>
                <div class="skill-item-editor">
                    <h3>Team Skill #<?php echo $index + 1; ?></h3>
                    
                    <div class="content-field">
                        <label for="skill_name_<?php echo $index; ?>">Skill Name</label>
                        <input type="text" name="content[team_skills][<?php echo $index; ?>][name]" id="skill_name_<?php echo $index; ?>" value="<?php echo $skill['name']; ?>">
                    </div>
                    
                    <div class="content-field">
                        <label for="skill_icon_<?php echo $index; ?>">Icon Class</label>
                        <input type="text" name="content[team_skills][<?php echo $index; ?>][icon]" id="skill_icon_<?php echo $index; ?>" value="<?php echo $skill['icon']; ?>">
                    </div>
                    
                    <div class="content-field">
                        <label for="skill_percentage_<?php echo $index; ?>">Skill Percentage (0-100)</label>
                        <input type="number" name="content[team_skills][<?php echo $index; ?>][percentage]" id="skill_percentage_<?php echo $index; ?>" value="<?php echo $skill['percentage']; ?>" min="0" max="100">
                    </div>
                </div>
                <?php endforeach; ?>
                <?php endif; ?>
                
                <?php elseif ($current_section === 'conclusion'): ?>
                <!-- Conclusion Section Content -->
                <div class="content-field">
                    <label for="conclusion_text">Conclusion Text</label>
                    <textarea name="content[conclusion_text]" id="conclusion_text" class="wysiwyg-editor"><?php echo $section_content['conclusion_text'] ?? ''; ?></textarea>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="content-footer">
                <button type="button" class="outline-btn" onclick="resetForm()">
                    <i class="fas fa-undo btn-icon"></i>
                    Reset
                </button>
                <button type="submit" name="save_content" class="primary-btn">
                    <i class="fas fa-save btn-icon"></i>
                    Save Changes
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Preview Modal -->
<div id="preview-modal" class="modal">
    <div class="modal-overlay"></div>
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title">Content Preview</h3>
            <button class="modal-close" data-dismiss="modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div id="preview-content"></div>
        </div>
    </div>
</div>

<script>
    // WYSIWYG Editor Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize editors
        const editors = document.querySelectorAll('.wysiwyg-editor');
        
        editors.forEach(editor => {
            // Create editable div
            const editorId = editor.getAttribute('id');
            const editorContent = editor.value;
            
            // Create container
            const editorContainer = document.createElement('div');
            editorContainer.className = 'editor-container';
            
            // Create editable div
            const editableDiv = document.createElement('div');
            editableDiv.className = 'editable-content';
            editableDiv.innerHTML = editorContent;
            editableDiv.contentEditable = true;
            editableDiv.dataset.for = editorId;
            
            // Add event listeners to update textarea
            editableDiv.addEventListener('input', function() {
                const textarea = document.getElementById(this.dataset.for);
                textarea.value = this.innerHTML;
            });
            
            // Replace textarea with editor
            editorContainer.appendChild(editableDiv);
            editor.style.display = 'none';
            editor.parentNode.insertBefore(editorContainer, editor.nextSibling);
        });
        
        // Toolbar buttons
        const toolbarButtons = document.querySelectorAll('.toolbar-button');
        
        toolbarButtons.forEach(button => {
            button.addEventListener('click', function() {
                const command = this.getAttribute('data-command');
                
                if (command === 'createLink') {
                    const url = prompt('Enter the link URL:');
                    if (url) {
                        document.execCommand(command, false, url);
                    }
                } else {
                    document.execCommand(command, false, null);
                }
                
                // Focus back on editor
                const activeEditor = document.querySelector('.editable-content:focus');
                if (activeEditor) {
                    activeEditor.focus();
                }
            });
        });
        
        // Format dropdown
        const formatSelect = document.querySelector('[data-command="formatBlock"]');
        
        if (formatSelect) {
            formatSelect.addEventListener('change', function() {
                if (this.value !== '') {
                    document.execCommand('formatBlock', false, this.value);
                    this.value = '';
                }
            });
        }
    });
    
    // Change language function
    function changeLanguage(language) {
        const currentUrl = new URL(window.location.href);
        const section = currentUrl.searchParams.get('section') || 'about';
        
        window.location.href = `?section=${section}&language=${language}`;
    }
    
    // Reset form function
    function resetForm() {
        if (confirm('Are you sure you want to reset the form? All unsaved changes will be lost.')) {
            window.location.reload();
        }
    }
    
    // Save all button
    document.getElementById('save-all-button').addEventListener('click', function() {
        document.getElementById('content-form').submit();
    });
    
    // Alert close button
    const alertCloseBtn = document.querySelector('.alert-close');
    if (alertCloseBtn) {
        alertCloseBtn.addEventListener('click', function() {
            this.parentNode.style.display = 'none';
        });
    }
</script>

<?php
// Include footer
include_once 'includes/footer.php';
?>