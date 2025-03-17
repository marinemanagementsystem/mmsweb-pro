</main>
    </div>
    
    <!-- JavaScript Libraries -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
    
    <!-- Admin JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            /**
             * Sidebar Toggle
             */
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
                        e.target !== mobileSidebarToggle) {
                        adminSidebar.classList.remove('show');
                    }
                });
            }
            
            /**
             * Submenu Toggle
             */
            const menuItems = document.querySelectorAll('.menu-item');
            
            menuItems.forEach(item => {
                const menuLink = item.querySelector('.menu-link');
                const submenu = item.querySelector('.submenu');
                
                if (menuLink && submenu) {
                    menuLink.addEventListener('click', function(e) {
                        e.preventDefault();
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
            
            /**
             * Dropdown Toggle
             */
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
            
            /**
             * Alert Auto-Close
             */
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
            
            /**
             * Confirmation Modal
             */
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
            
            /**
             * Form Validation
             */
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
                    });
                    
                    if (!isValid) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
</body>
</html>