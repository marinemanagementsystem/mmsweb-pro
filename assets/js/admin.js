/**
 * MMS - Marine Management System
 * Admin Panel JavaScript
 */

document.addEventListener('DOMContentLoaded', function() {
    'use strict';

    /**
     * Toggle Sidebar
     */
    function initSidebar() {
        const sidebarToggle = document.getElementById('sidebarToggle');
        const mobileSidebarToggle = document.getElementById('mobileSidebarToggle');
        const adminSidebar = document.getElementById('adminSidebar');
        
        if (sidebarToggle && adminSidebar) {
            sidebarToggle.addEventListener('click', function() {
                adminSidebar.classList.toggle('collapsed');
                
                // Save sidebar state to localStorage
                const isCollapsed = adminSidebar.classList.contains('collapsed');
                localStorage.setItem('sidebar_collapsed', isCollapsed ? '1' : '0');
            });
            
            // Check saved state on load
            const savedState = localStorage.getItem('sidebar_collapsed');
            if (savedState === '1') {
                adminSidebar.classList.add('collapsed');
            }
        }
        
        if (mobileSidebarToggle && adminSidebar) {
            mobileSidebarToggle.addEventListener('click', function() {
                adminSidebar.classList.toggle('show');
            });
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(e) {
                if (window.innerWidth < 768 && 
                    adminSidebar.classList.contains('show') &&
                    !adminSidebar.contains(e.target) && 
                    e.target !== mobileSidebarToggle &&
                    !e.target.closest('#mobileSidebarToggle')) {
                    adminSidebar.classList.remove('show');
                }
            });
        }
    }

    /**
     * Toggle Menu Items
     */
    function initMenuItems() {
        const menuItems = document.querySelectorAll('.menu-item');
        
        menuItems.forEach(item => {
            const menuLink = item.querySelector('.menu-link');
            const submenu = item.querySelector('.submenu');
            
            if (menuLink && submenu) {
                menuLink.addEventListener('click', function(e) {
                    // If link has submenu, prevent navigation
                    if (submenu) {
                        e.preventDefault();
                    }
                    
                    item.classList.toggle('open');
                    
                    // Update submenu height for animation
                    if (item.classList.contains('open')) {
                        submenu.style.height = submenu.scrollHeight + 'px';
                    } else {
                        submenu.style.height = '0';
                    }
                });
                
                // Check if menu should be open (based on active submenu)
                const activeSubmenu = submenu.querySelector('.submenu-link.active');
                if (activeSubmenu) {
                    item.classList.add('open');
                    submenu.style.height = submenu.scrollHeight + 'px';
                }
            }
        });
    }

    /**
     * Dropdown Toggle
     */
    function initDropdowns() {
        const dropdowns = document.querySelectorAll('.dropdown');
        
        dropdowns.forEach(dropdown => {
            const toggle = dropdown.querySelector('.notification-icon, .user-dropdown-toggle');
            
            if (toggle) {
                toggle.addEventListener('click', function(e) {
                    e.stopPropagation();
                    
                    // Close all other dropdowns
                    dropdowns.forEach(otherDropdown => {
                        if (otherDropdown !== dropdown) {
                            otherDropdown.classList.remove('show');
                        }
                    });
                    
                    dropdown.classList.toggle('show');
                });
            }
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function() {
            dropdowns.forEach(dropdown => {
                dropdown.classList.remove('show');
            });
        });
        
        // Prevent closing when clicking inside dropdown
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    }

    /**
     * Alert Auto-Close
     */
    function initAlerts() {
        const alerts = document.querySelectorAll('.alert');
        
        alerts.forEach(alert => {
            // Auto-close after 5 seconds if it's a success message
            if (alert.classList.contains('success')) {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                }, 5000);
            }
            
            // Close button
            const closeBtn = alert.querySelector('.alert-close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function() {
                    alert.style.opacity = '0';
                    setTimeout(() => {
                        alert.style.display = 'none';
                    }, 300);
                });
            }
        });
    }

    /**
     * Modal Functionality
     */
    function initModals() {
        const modalTriggers = document.querySelectorAll('[data-toggle="modal"]');
        
        modalTriggers.forEach(trigger => {
            trigger.addEventListener('click', function(e) {
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
            item.addEventListener('click', function(e) {
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
            container.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        });
    }

    /**
     * Form Validation
     */
    function initFormValidation() {
        const forms = document.querySelectorAll('form[data-validate]');
        
        forms.forEach(form => {
            form.addEventListener('submit', function(e) {
                let isValid = true;
                
                // Check required fields
                const requiredFields = form.querySelectorAll('[required]');
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('error');
                        
                        // Add error message if not exists
                        let errorMsg = field.nextElementSibling;
                        if (!errorMsg || !errorMsg.classList.contains('error-message')) {
                            errorMsg = document.createElement('div');
                            errorMsg.className = 'error-message';
                            errorMsg.textContent = 'This field is required';
                            field.parentNode.insertBefore(errorMsg, field.nextSibling);
                        }
                    } else {
                        field.classList.remove('error');
                        
                        // Remove error message if exists
                        const errorMsg = field.nextElementSibling;
                        if (errorMsg && errorMsg.classList.contains('error-message')) {
                            errorMsg.remove();
                        }
                    }
                    
                    // Validate email field
                    if (field.type === 'email' && field.value.trim()) {
                        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailPattern.test(field.value)) {
                            isValid = false;
                            field.classList.add('error');
                            
                            // Add error message if not exists
                            let errorMsg = field.nextElementSibling;
                            if (!errorMsg || !errorMsg.classList.contains('error-message')) {
                                errorMsg = document.createElement('div');
                                errorMsg.className = 'error-message';
                                errorMsg.textContent = 'Please enter a valid email address';
                                field.parentNode.insertBefore(errorMsg, field.nextSibling);
                            } else {
                                errorMsg.textContent = 'Please enter a valid email address';
                            }
                        }
                    }
                    
                    // Validate password confirmation
                    if (field.id === 'confirm_password') {
                        const password = document.getElementById('new_password');
                        if (password && field.value !== password.value) {
                            isValid = false;
                            field.classList.add('error');
                            
                            // Add error message if not exists
                            let errorMsg = field.nextElementSibling;
                            if (!errorMsg || !errorMsg.classList.contains('error-message')) {
                                errorMsg = document.createElement('div');
                                errorMsg.className = 'error-message';
                                errorMsg.textContent = 'Passwords do not match';
                                field.parentNode.insertBefore(errorMsg, field.nextSibling);
                            } else {
                                errorMsg.textContent = 'Passwords do not match';
                            }
                        }
                    }
                });
                
                if (!isValid) {
                    e.preventDefault();
                }
            });
            
            // Real-time validation
            const fields = form.querySelectorAll('input, textarea, select');
            
            fields.forEach(field => {
                field.addEventListener('blur', function() {
                    // Required field validation
                    if (field.hasAttribute('required') && !field.value.trim()) {
                        field.classList.add('error');
                        
                        // Add error message if not exists
                        let errorMsg = field.nextElementSibling;
                        if (!errorMsg || !errorMsg.classList.contains('error-message')) {
                            errorMsg = document.createElement('div');
                            errorMsg.className = 'error-message';
                            errorMsg.textContent = 'This field is required';
                            field.parentNode.insertBefore(errorMsg, field.nextSibling);
                        }
                    } else {
                        field.classList.remove('error');
                        
                        // Remove error message if exists
                        const errorMsg = field.nextElementSibling;
                        if (errorMsg && errorMsg.classList.contains('error-message')) {
                            errorMsg.remove();
                        }
                    }
                    
                    // Email validation
                    if (field.type === 'email' && field.value.trim()) {
                        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                        if (!emailPattern.test(field.value)) {
                            field.classList.add('error');
                            
                            // Add error message if not exists
                            let errorMsg = field.nextElementSibling;
                            if (!errorMsg || !errorMsg.classList.contains('error-message')) {
                                errorMsg = document.createElement('div');
                                errorMsg.className = 'error-message';
                                errorMsg.textContent = 'Please enter a valid email address';
                                field.parentNode.insertBefore(errorMsg, field.nextSibling);
                            } else {
                                errorMsg.textContent = 'Please enter a valid email address';
                            }
                        }
                    }
                    
                    // Password confirmation validation
                    if (field.id === 'confirm_password') {
                        const password = document.getElementById('new_password');
                        if (password && field.value !== password.value) {
                            field.classList.add('error');
                            
                            // Add error message if not exists
                            let errorMsg = field.nextElementSibling;
                            if (!errorMsg || !errorMsg.classList.contains('error-message')) {
                                errorMsg = document.createElement('div');
                                errorMsg.className = 'error-message';
                                errorMsg.textContent = 'Passwords do not match';
                                field.parentNode.insertBefore(errorMsg, field.nextSibling);
                            } else {
                                errorMsg.textContent = 'Passwords do not match';
                            }
                        }
                    }
                });
            });
        });
    }

    /**
     * WYSIWYG Editor
     */
    function initWysiwygEditor() {
        // Check if there are WYSIWYG editors on the page
        const editors = document.querySelectorAll('.wysiwyg-editor');
        
        if (editors.length === 0) {
            return;
        }
        
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
        
        if (toolbarButtons.length) {
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
                    
                    // Toggle active state for bold, italic, underline, etc.
                    if (['bold', 'italic', 'underline', 'justifyLeft', 'justifyCenter', 'justifyRight'].includes(command)) {
                        this.classList.toggle('active');
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
        }
    }

    /**
     * File Upload Preview
     */
    function initFileUpload() {
        const fileInputs = document.querySelectorAll('input[type="file"]');
        
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                const fileName = this.files[0]?.name || 'No file chosen';
                const fileNameElement = this.nextElementSibling.nextElementSibling;
                
                if (fileNameElement && fileNameElement.classList.contains('file-name')) {
                    fileNameElement.textContent = fileName;
                }
                
                // If this is the logo upload, update preview
                if (this.id === 'site_logo' && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewLight = document.getElementById('logoPreviewLight');
                        const previewDark = document.getElementById('logoPreviewDark');
                        
                        if (previewLight) previewLight.src = e.target.result;
                        if (previewDark) previewDark.src = e.target.result;
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });
        });
    }

    /**
     * Data Tables
     */
    function initDataTables() {
        const tables = document.querySelectorAll('.data-table');
        
        tables.forEach(table => {
            // Check if the table has a search input
            const searchInput = table.parentElement.querySelector('.table-search');
            
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchText = this.value.toLowerCase();
                    const rows = table.querySelectorAll('tbody tr');
                    
                    rows.forEach(row => {
                        const text = row.textContent.toLowerCase();
                        row.style.display = text.includes(searchText) ? '' : 'none';
                    });
                });
            }
            
            // Check if the table has sorting functionality
            const sortableHeaders = table.querySelectorAll('th[data-sort]');
            
            sortableHeaders.forEach(header => {
                header.addEventListener('click', function() {
                    const sortBy = this.getAttribute('data-sort');
                    const sortOrder = this.getAttribute('data-order') || 'asc';
                    const rows = Array.from(table.querySelectorAll('tbody tr'));
                    
                    // Reset all headers
                    sortableHeaders.forEach(h => {
                        h.classList.remove('sort-asc', 'sort-desc');
                        h.removeAttribute('data-order');
                    });
                    
                    // Set current header sort state
                    this.classList.add(sortOrder === 'asc' ? 'sort-asc' : 'sort-desc');
                    this.setAttribute('data-order', sortOrder === 'asc' ? 'desc' : 'asc');
                    
                    // Get column index
                    const columnIndex = Array.from(this.parentNode.children).indexOf(this);
                    
                    // Sort rows
                    rows.sort((a, b) => {
                        const aValue = a.children[columnIndex].textContent.trim();
                        const bValue = b.children[columnIndex].textContent.trim();
                        
                        // Check if values are dates
                        const aDate = new Date(aValue);
                        const bDate = new Date(bValue);
                        
                        if (!isNaN(aDate) && !isNaN(bDate)) {
                            return sortOrder === 'asc' ? aDate - bDate : bDate - aDate;
                        }
                        
                        // Check if values are numbers
                        if (!isNaN(aValue) && !isNaN(bValue)) {
                            return sortOrder === 'asc' ? aValue - bValue : bValue - aValue;
                        }
                        
                        // Otherwise, sort as strings
                        return sortOrder === 'asc' 
                            ? aValue.localeCompare(bValue) 
                            : bValue.localeCompare(aValue);
                    });
                    
                    // Reorder rows in the table
                    const tbody = table.querySelector('tbody');
                    rows.forEach(row => tbody.appendChild(row));
                });
            });
        });
    }

    /**
     * Settings Tabs
     */
    function initSettingsTabs() {
        const settingsNav = document.querySelectorAll('.settings-nav a');
        const settingsSections = document.querySelectorAll('.settings-section');
        
        if (settingsNav.length === 0 || settingsSections.length === 0) {
            return;
        }
        
        settingsNav.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all links and sections
                settingsNav.forEach(item => item.classList.remove('active'));
                settingsSections.forEach(section => section.classList.remove('active'));
                
                // Add active class to clicked link
                this.classList.add('active');
                
                // Show corresponding section
                const targetSection = document.querySelector(this.getAttribute('href'));
                if (targetSection) {
                    targetSection.classList.add('active');
                }
            });
        });
    }

    /**
     * Dashboard Charts
     */
    function initDashboardCharts() {
        // Visitors Chart
        const visitorsChart = document.getElementById('visitors-chart');
        
        if (visitorsChart && typeof Chart !== 'undefined') {
            const ctx = visitorsChart.getContext('2d');
            
            new Chart(ctx, {
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
        
        if (trafficChart && typeof Chart !== 'undefined') {
            const ctx = trafficChart.getContext('2d');
            
            new Chart(ctx, {
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
        
        // Analytics Period Switch
        const analyticsPeriod = document.getElementById('analytics-period');
        
        if (analyticsPeriod) {
            analyticsPeriod.addEventListener('change', function() {
                // In a real implementation, this would update the charts with new data
                // For this example, we'll just log the selected period
                console.log('Selected period:', this.value);
            });
        }
    }

    /**
     * Current Time Display
     */
    function initCurrentTime() {
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
    }

    /**
     * Confirmation Dialog
     */
    function initConfirmDialog() {
        const confirmationBtns = document.querySelectorAll('[data-confirm]');
        
        confirmationBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                
                const message = this.getAttribute('data-confirm') || 'Are you sure you want to proceed?';
                
                if (confirm(message)) {
                    window.location.href = this.getAttribute('href');
                }
            });
        });
    }

    /**
     * Bulk Actions
     */
    function initBulkActions() {
        const bulkActionForm = document.querySelector('.bulk-action-form');
        
        if (bulkActionForm) {
            const selectAll = bulkActionForm.querySelector('.select-all');
            const itemCheckboxes = bulkActionForm.querySelectorAll('.item-checkbox');
            const bulkActionSelect = bulkActionForm.querySelector('.bulk-action-select');
            const bulkActionButton = bulkActionForm.querySelector('.bulk-action-button');
            
            // Select all checkboxes
            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    itemCheckboxes.forEach(checkbox => {
                        checkbox.checked = this.checked;
                    });
                    
                    // Update bulk action button state
                    updateBulkActionButtonState();
                });
            }
            
            // Individual checkbox change
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    // Update select all checkbox state
                    if (selectAll) {
                        selectAll.checked = Array.from(itemCheckboxes).every(cb => cb.checked);
                        selectAll.indeterminate = !selectAll.checked && Array.from(itemCheckboxes).some(cb => cb.checked);
                    }
                    
                    // Update bulk action button state
                    updateBulkActionButtonState();
                });
            });
            
            // Update bulk action button state
            function updateBulkActionButtonState() {
                const hasChecked = Array.from(itemCheckboxes).some(cb => cb.checked);
                bulkActionButton.disabled = !hasChecked || bulkActionSelect.value === '';
            }
            
            // Bulk action select change
            if (bulkActionSelect) {
                bulkActionSelect.addEventListener('change', function() {
                    updateBulkActionButtonState();
                });
            }
            
            // Bulk action form submit
            bulkActionForm.addEventListener('submit', function(e) {
                const hasChecked = Array.from(itemCheckboxes).some(cb => cb.checked);
                const action = bulkActionSelect.value;
                
                if (!hasChecked || action === '') {
                    e.preventDefault();
                    return;
                }
                
                // Confirm delete action
                if (action === 'delete' && !confirm('Are you sure you want to delete the selected items? This action cannot be undone.')) {
                    e.preventDefault();
                }
            });
        }
    }

    /**
     * Date Range Picker
     */
    function initDateRangePicker() {
        const dateRangeInputs = document.querySelectorAll('.date-range-picker');
        
        // Check if flatpickr is available
        if (dateRangeInputs.length && typeof flatpickr !== 'undefined') {
            dateRangeInputs.forEach(input => {
                flatpickr(input, {
                    mode: 'range',
                    dateFormat: 'Y-m-d',
                    altInput: true,
                    altFormat: 'F j, Y',
                    defaultDate: [
                        new Date(new Date().setDate(new Date().getDate() - 30)), 
                        new Date()
                    ]
                });
            });
        }
    }

    /**
     * Custom Select
     */
    function initCustomSelect() {
        const customSelects = document.querySelectorAll('.custom-select');
        
        customSelects.forEach(select => {
            const selectElement = select.querySelector('select');
            const selectedOption = select.querySelector('.selected-option');
            const optionsList = select.querySelector('.options-list');
            
            if (!selectElement || !selectedOption || !optionsList) {
                return;
            }
            
            // Set initial selected option
            const initialOption = selectElement.options[selectElement.selectedIndex];
            if (initialOption) {
                selectedOption.textContent = initialOption.textContent;
            }
            
            // Toggle options list
            selectedOption.addEventListener('click', function(e) {
                e.stopPropagation();
                optionsList.classList.toggle('show');
                select.classList.toggle('open');
            });
            
            // Click outside to close
            document.addEventListener('click', function() {
                optionsList.classList.remove('show');
                select.classList.remove('open');
            });
            
            // Option click
            const options = optionsList.querySelectorAll('li');
            options.forEach(option => {
                option.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    const text = this.textContent;
                    
                    // Update selected option
                    selectedOption.textContent = text;
                    
                    // Update select element
                    selectElement.value = value;
                    
                    // Trigger change event
                    const event = new Event('change', { bubbles: true });
                    selectElement.dispatchEvent(event);
                    
                    // Close options list
                    optionsList.classList.remove('show');
                    select.classList.remove('open');
                });
            });
        });
    }

    /**
     * Animation on Scroll (AOS)
     */
    function initAOS() {
        if (typeof AOS !== 'undefined') {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
        }
    }

    // Initialize all components
    initSidebar();
    initMenuItems();
    initDropdowns();
    initAlerts();
    initModals();
    initFormValidation();
    initWysiwygEditor();
    initFileUpload();
    initDataTables();
    initSettingsTabs();
    initDashboardCharts();
    initCurrentTime();
    initConfirmDialog();
    initBulkActions();
    initDateRangePicker();
    initCustomSelect();
    initAOS();
});
