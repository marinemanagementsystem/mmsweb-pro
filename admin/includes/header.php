<?php
/**
 * MMS - Marine Management System
 * Admin Header File
 */

// Get current page
$current_page = basename($_SERVER['PHP_SELF']);

// Get admin user information
$admin_user = get_admin_user();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MMS Admin - <?php echo get_page_title(); ?></title>
    
    <!-- Favicon -->
    <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <img src="../assets/images/logo.png" alt="MMS Logo">
                    <h2 class="sidebar-title">MMS Admin</h2>
                </div>
                <button class="sidebar-toggle" id="sidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <div class="sidebar-menu">
                <span class="menu-label">Navigation</span>
                
                <div class="menu-item">
                    <a href="dashboard.php" class="menu-link <?php echo $current_page === 'dashboard.php' ? 'active' : ''; ?>">
                        <span class="menu-icon"><i class="fas fa-tachometer-alt"></i></span>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="content-editor.php" class="menu-link <?php echo $current_page === 'content-editor.php' ? 'active' : ''; ?>">
                        <span class="menu-icon"><i class="fas fa-edit"></i></span>
                        <span class="menu-text">Content Management</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="#" class="menu-link <?php echo in_array($current_page, ['demo-requests.php', 'demo-request.php']) ? 'active' : ''; ?>">
                        <span class="menu-icon"><i class="fas fa-tasks"></i></span>
                        <span class="menu-text">Demo Requests</span>
                        <span class="menu-arrow"><i class="fas fa-chevron-down"></i></span>
                    </a>
                    <div class="submenu">
                        <a href="demo-requests.php" class="submenu-link <?php echo $current_page === 'demo-requests.php' ? 'active' : ''; ?>">All Requests</a>
                        <a href="demo-requests.php?status=pending" class="submenu-link">Pending</a>
                        <a href="demo-requests.php?status=contacted" class="submenu-link">Contacted</a>
                        <a href="demo-requests.php?status=completed" class="submenu-link">Completed</a>
                    </div>
                </div>
                
                <div class="menu-item">
                    <a href="#" class="menu-link <?php echo in_array($current_page, ['contact-messages.php', 'message.php']) ? 'active' : ''; ?>">
                        <span class="menu-icon"><i class="fas fa-envelope"></i></span>
                        <span class="menu-text">Contact Messages</span>
                        <span class="menu-arrow"><i class="fas fa-chevron-down"></i></span>
                    </a>
                    <div class="submenu">
                        <a href="contact-messages.php" class="submenu-link <?php echo $current_page === 'contact-messages.php' ? 'active' : ''; ?>">All Messages</a>
                        <a href="contact-messages.php?status=unread" class="submenu-link">Unread</a>
                        <a href="contact-messages.php?status=read" class="submenu-link">Read</a>
                        <a href="contact-messages.php?status=replied" class="submenu-link">Replied</a>
                    </div>
                </div>
                
                <span class="menu-label">Settings</span>
                
                <div class="menu-item">
                    <a href="settings.php" class="menu-link <?php echo $current_page === 'settings.php' ? 'active' : ''; ?>">
                        <span class="menu-icon"><i class="fas fa-cog"></i></span>
                        <span class="menu-text">Site Settings</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="users.php" class="menu-link <?php echo $current_page === 'users.php' ? 'active' : ''; ?>">
                        <span class="menu-icon"><i class="fas fa-users"></i></span>
                        <span class="menu-text">User Management</span>
                    </a>
                </div>
                
                <div class="menu-item">
                    <a href="#" class="menu-link">
                        <span class="menu-icon"><i class="fas fa-database"></i></span>
                        <span class="menu-text">Backup & Restore</span>
                    </a>
                </div>
            </div>
            
            <div class="sidebar-footer">
                <div class="user-info">
                    <div class="user-avatar">
                        <?php echo strtoupper(substr($admin_user['username'] ?? 'A', 0, 1)); ?>
                    </div>
                    <div class="user-details">
                        <h4 class="user-name"><?php echo $admin_user['full_name'] ?? 'Admin User'; ?></h4>
                        <p class="user-role">Administrator</p>
                    </div>
                </div>
            </div>
        </aside>
        
        <!-- Main Content Area -->
        <main class="admin-main">
            <!-- Header -->
            <header class="admin-header">
                <div class="header-left">
                    <button class="mobile-sidebar-toggle" id="mobileSidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <h1 class="page-title"><?php echo get_page_title(); ?></h1>
                    
                    <ul class="breadcrumb">
                        <li><a href="dashboard.php">Dashboard</a></li>
                        <?php if ($current_page !== 'dashboard.php'): ?>
                        <li><a href="<?php echo $current_page; ?>"><?php echo get_page_title(); ?></a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <div class="header-right">
                    <div class="header-action dropdown">
                        <div class="notification-icon">
                            <i class="fas fa-bell"></i>
                            <?php $unread_notifications = get_unread_notifications_count(); ?>
                            <?php if ($unread_notifications > 0): ?>
                            <span class="badge"><?php echo $unread_notifications; ?></span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="dropdown-menu">
                            <div class="dropdown-header">
                                <h3 class="dropdown-title">Notifications</h3>
                            </div>
                            
                            <div class="dropdown-body">
                                <?php $notifications = get_recent_notifications(5); ?>
                                
                                <?php if (empty($notifications)): ?>
                                <div class="dropdown-item">
                                    <p>No notifications</p>
                                </div>
                                <?php else: ?>
                                    <?php foreach ($notifications as $notification): ?>
                                    <div class="dropdown-item">
                                        <a href="<?php echo $notification['link']; ?>" class="dropdown-link">
                                            <div class="dropdown-icon">
                                                <i class="<?php echo $notification['icon']; ?>"></i>
                                            </div>
                                            <div class="dropdown-content">
                                                <h4><?php echo $notification['title']; ?></h4>
                                                <p><?php echo $notification['message']; ?></p>
                                            </div>
                                        </a>
                                    </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                            
                            <div class="dropdown-footer">
                                <a href="notifications.php">View All Notifications</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="header-action dropdown">
                        <div class="user-dropdown-toggle">
                            <div class="user-avatar">
                                <?php echo strtoupper(substr($admin_user['username'] ?? 'A', 0, 1)); ?>
                            </div>
                        </div>
                        
                        <div class="dropdown-menu">
                            <div class="dropdown-header">
                                <h3 class="dropdown-title"><?php echo $admin_user['full_name'] ?? 'Admin User'; ?></h3>
                            </div>
                            
                            <div class="dropdown-body">
                                <div class="dropdown-item">
                                    <a href="profile.php" class="dropdown-link">
                                        <div class="dropdown-icon">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div class="dropdown-content">
                                            <h4>My Profile</h4>
                                            <p>View and edit your profile</p>
                                        </div>
                                    </a>
                                </div>
                                
                                <div class="dropdown-item">
                                    <a href="settings.php" class="dropdown-link">
                                        <div class="dropdown-icon">
                                            <i class="fas fa-cog"></i>
                                        </div>
                                        <div class="dropdown-content">
                                            <h4>Settings</h4>
                                            <p>Manage system settings</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="dropdown-footer">
                                <a href="logout.php">
                                    <i class="fas fa-sign-out-alt"></i>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
