<?php
/**
 * MMS - Marine Management System
 * Admin Dashboard Page
 */

// Initialize the application
require_once '../includes/init.php';

// Check if user is logged in
if (!is_admin_logged_in()) {
    redirect('index.php');
}

// Get statistics for dashboard
$stats = [
    'demo_requests' => get_demo_requests_count(),
    'contact_submissions' => get_contact_submissions_count(),
    'visits_today' => get_visits_count('today'),
    'visits_month' => get_visits_count('month')
];

// Include header
include_once 'includes/header.php';
?>

<!-- Main Content -->
<div class="admin-content">
    <div class="dashboard-header">
        <h1 class="page-title">Dashboard</h1>
        <div class="date-time">
            <span class="date"><?php echo date('l, F j, Y'); ?></span>
            <span class="time" id="current-time"></span>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="stats-container">
        <div class="stats-card">
            <div class="stats-icon demo-icon">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="stats-info">
                <h3>Demo Requests</h3>
                <div class="stats-number"><?php echo $stats['demo_requests']; ?></div>
                <div class="stats-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>12% from last week</span>
                </div>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-icon contact-icon">
                <i class="fas fa-envelope"></i>
            </div>
            <div class="stats-info">
                <h3>Contact Messages</h3>
                <div class="stats-number"><?php echo $stats['contact_submissions']; ?></div>
                <div class="stats-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>8% from last week</span>
                </div>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-icon visits-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-info">
                <h3>Today's Visits</h3>
                <div class="stats-number"><?php echo $stats['visits_today']; ?></div>
                <div class="stats-trend down">
                    <i class="fas fa-arrow-down"></i>
                    <span>3% from yesterday</span>
                </div>
            </div>
        </div>
        
        <div class="stats-card">
            <div class="stats-icon monthly-icon">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stats-info">
                <h3>Monthly Visits</h3>
                <div class="stats-number"><?php echo $stats['visits_month']; ?></div>
                <div class="stats-trend up">
                    <i class="fas fa-arrow-up"></i>
                    <span>15% from last month</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dashboard Widgets -->
    <div class="dashboard-widgets">
        <!-- Recent Demo Requests -->
        <div class="widget large-widget">
            <div class="widget-header">
                <h2><i class="fas fa-tasks"></i> Recent Demo Requests</h2>
                <a href="demo-requests.php" class="view-all">View All</a>
            </div>
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recent_demos = get_recent_demo_requests(5);
                            foreach ($recent_demos as $demo):
                                $status_class = '';
                                $status_text = '';
                                
                                switch($demo['status']) {
                                    case 'pending':
                                        $status_class = 'pending';
                                        $status_text = 'Pending';
                                        break;
                                    case 'contacted':
                                        $status_class = 'in-progress';
                                        $status_text = 'Contacted';
                                        break;
                                    case 'completed':
                                        $status_class = 'completed';
                                        $status_text = 'Completed';
                                        break;
                                }
                            ?>
                            <tr>
                                <td><?php echo $demo['name'] . ' ' . $demo['surname']; ?></td>
                                <td><?php echo $demo['email']; ?></td>
                                <td><?php echo $demo['phone']; ?></td>
                                <td><?php echo date('M j, Y', strtotime($demo['created_at'])); ?></td>
                                <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="demo-request.php?id=<?php echo $demo['id']; ?>" class="action-btn view-btn" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="demo-request.php?id=<?php echo $demo['id']; ?>&action=edit" class="action-btn edit-btn" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#" class="action-btn delete-btn" data-id="<?php echo $demo['id']; ?>" title="Delete" data-toggle="modal" data-target="delete-confirm-modal">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if (empty($recent_demos)): ?>
                            <tr>
                                <td colspan="6" class="text-center">No demo requests found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Recent Contact Messages -->
        <div class="widget large-widget">
            <div class="widget-header">
                <h2><i class="fas fa-envelope"></i> Recent Contact Messages</h2>
                <a href="contact-messages.php" class="view-all">View All</a>
            </div>
            <div class="widget-content">
                <div class="table-responsive">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recent_messages = get_recent_contact_messages(5);
                            foreach ($recent_messages as $message):
                                $status_class = '';
                                $status_text = '';
                                
                                switch($message['status']) {
                                    case 'unread':
                                        $status_class = 'pending';
                                        $status_text = 'Unread';
                                        break;
                                    case 'read':
                                        $status_class = 'in-progress';
                                        $status_text = 'Read';
                                        break;
                                    case 'replied':
                                        $status_class = 'completed';
                                        $status_text = 'Replied';
                                        break;
                                }
                            ?>
                            <tr>
                                <td><?php echo $message['name']; ?></td>
                                <td><?php echo $message['email']; ?></td>
                                <td class="message-preview"><?php echo substr($message['message'], 0, 50) . '...'; ?></td>
                                <td><?php echo date('M j, Y', strtotime($message['created_at'])); ?></td>
                                <td><span class="status-badge <?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="message.php?id=<?php echo $message['id']; ?>" class="action-btn view-btn" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="message.php?id=<?php echo $message['id']; ?>&action=reply" class="action-btn reply-btn" title="Reply">
                                            <i class="fas fa-reply"></i>
                                        </a>
                                        <a href="#" class="action-btn delete-btn" data-id="<?php echo $message['id']; ?>" title="Delete" data-toggle="modal" data-target="delete-confirm-modal">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            
                            <?php if (empty($recent_messages)): ?>
                            <tr>
                                <td colspan="6" class="text-center">No contact messages found</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Visitor Analytics -->
        <div class="widget medium-widget">
            <div class="widget-header">
                <h2><i class="fas fa-chart-bar"></i> Visitor Analytics</h2>
                <div class="widget-actions">
                    <select id="analytics-period" class="period-select">
                        <option value="7days">Last 7 Days</option>
                        <option value="month">This Month</option>
                        <option value="year">This Year</option>
                    </select>
                </div>
            </div>
            <div class="widget-content">
                <canvas id="visitors-chart"></canvas>
            </div>
        </div>
        
        <!-- Traffic Sources -->
        <div class="widget medium-widget">
            <div class="widget-header">
                <h2><i class="fas fa-random"></i> Traffic Sources</h2>
            </div>
            <div class="widget-content">
                <canvas id="traffic-sources-chart"></canvas>
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="widget small-widget">
            <div class="widget-header">
                <h2><i class="fas fa-bolt"></i> Quick Actions</h2>
            </div>
            <div class="widget-content">
                <div class="quick-actions">
                    <a href="content-editor.php" class="quick-action-btn">
                        <i class="fas fa-edit"></i>
                        <span>Edit Content</span>
                    </a>
                    <a href="settings.php" class="quick-action-btn">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    <a href="users.php" class="quick-action-btn">
                        <i class="fas fa-user"></i>
                        <span>Manage Users</span>
                    </a>
                    <a href="#" class="quick-action-btn" data-toggle="modal" data-target="backup-modal">
                        <i class="fas fa-database"></i>
                        <span>Backup Data</span>
                    </a>
                </div>
            </div>
        </div>
        
        <!-- System Info -->
        <div class="widget small-widget">
            <div class="widget-header">
                <h2><i class="fas fa-info-circle"></i> System Info</h2>
            </div>
            <div class="widget-content">
                <div class="system-info">
                    <div class="info-item">
                        <div class="info-label">PHP Version</div>
                        <div class="info-value"><?php echo phpversion(); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Database</div>
                        <div class="info-value">MySQL <?php echo get_mysql_version(); ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Server</div>
                        <div class="info-value"><?php echo $_SERVER['SERVER_SOFTWARE']; ?></div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">MMS Version</div>
                        <div class="info-value">1.0.0</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="delete-confirm-modal" class="modal">
    <div class="modal-overlay"></div>
    <div class="modal-container small-modal">
        <div class="modal-header">
            <h3 class="modal-title">Confirm Delete</h3>
            <button class="modal-close" data-dismiss="modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body text-center">
            <div class="confirm-icon warning">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h4>Are you sure?</h4>
            <p>You are about to delete this item. This action cannot be undone.</p>
            <input type="hidden" id="delete-item-id" value="">
            <input type="hidden" id="delete-item-type" value="">
            <div class="button-group">
                <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                <button class="delete-btn" id="confirm-delete-btn">Delete</button>
            </div>
        </div>
    </div>
</div>

<!-- Backup Modal -->
<div id="backup-modal" class="modal">
    <div class="modal-overlay"></div>
    <div class="modal-container small-modal">
        <div class="modal-header">
            <h3 class="modal-title">Database Backup</h3>
            <button class="modal-close" data-dismiss="modal">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body text-center">
            <div class="confirm-icon">
                <i class="fas fa-database"></i>
            </div>
            <h4>Create Database Backup</h4>
            <p>This will generate a complete backup of your database.</p>
            <div class="button-group">
                <button class="cancel-btn" data-dismiss="modal">Cancel</button>
                <button class="primary-btn" id="create-backup-btn">Create Backup</button>
            </div>
        </div>
    </div>
</div>

<?php
// Include footer
include_once 'includes/footer.php';
?>