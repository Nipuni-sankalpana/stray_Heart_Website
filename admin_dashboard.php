
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin_dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3>PetCare Admin</h3>
            </div>
            
            <div class="sidebar-menu">
                <div class="menu-category">Main</div>
                <a href="#" class="menu-item active">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="menu-category">Management</div>
                <a href="manage-pets.php" class="menu-item">
                    <i class="fas fa-fw fa-paw"></i>
                    <span>Pets</span>
                </a>
                <a href="admin-adoption.php" class="menu-item">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Adoptions</span>
                </a>
                <a href="admin_hospital_list.php" class="menu-item">
                    <i class="fas fa-fw fa-hospital"></i>
                    <span>Hospitals</span>
                </a>
                
                <div class="menu-category">Donations</div>
                <a href="admin_donation.php" class="menu-item">
                    <i class="fas fa-fw fa-hand-holding-heart"></i>
                    <span>All Donations</span>
                </a>
                <a href="admin_money_donations.php" class="menu-item">
                    <i class="fas fa-fw fa-money-bill-wave"></i>
                    <span>Money</span>
                </a>
                <a href="admin_food_donations.php" class="menu-item">
                    <i class="fas fa-fw fa-utensils"></i>
                    <span>Food</span>
                </a>
                <a href="admin_item_donations.php" class="menu-item">
                    <i class="fas fa-fw fa-box-open"></i>
                    <span>Items</span>
                </a>
                <a href="confirm_item_donation.php" class="menu-item">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Manage Items</span>
                </a>
                <a href="confirm_food_donation.php" class="menu-item">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>Manage Food</span>
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <div class="top-bar">
                <div class="page-title">
                    <h1>Dashboard</h1>
                </div>
                <div class="user-profile">
                    <img src="https://via.placeholder.com/40" alt="Admin">
                    <span>Admin User</span>
                </div>
            </div>
            
            <!-- Dashboard Cards -->
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-header">
                        <h3>Pets Management</h3>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <div class="card-icon pets">
                                <i class="fas fa-paw fa-2x"></i>
                            </div>
                            <div class="card-text">
                                <h4>142</h4>
                                <p>Total Pets in System</p>
                            </div>
                        </div>
                        <div class="quick-actions">
                            <a href="manage-pets.php" class="action-btn">
                                <i class="fas fa-list"></i>
                                <span>View All Pets</span>
                            </a>
                            <a href="add-pet.php" class="action-btn">
                                <i class="fas fa-plus"></i>
                                <span>Add New Pet</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3>Adoptions</h3>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <div class="card-icon adoption">
                                <i class="fas fa-home fa-2x"></i>
                            </div>
                            <div class="card-text">
                                <h4>28</h4>
                                <p>Pending Adoptions</p>
                            </div>
                        </div>
                        <div class="quick-actions">
                            <a href="admin-adoption.php" class="action-btn">
                                <i class="fas fa-tasks"></i>
                                <span>Manage Adoptions</span>
                            </a>
                            <a href="#" class="action-btn">
                                <i class="fas fa-chart-bar"></i>
                                <span>Reports</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3>Hospitals</h3>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <div class="card-icon hospital">
                                <i class="fas fa-hospital fa-2x"></i>
                            </div>
                            <div class="card-text">
                                <h4>15</h4>
                                <p>Partner Hospitals</p>
                            </div>
                        </div>
                        <div class="quick-actions">
                            <a href="admin_hospital_list.php" class="action-btn">
                                <i class="fas fa-list"></i>
                                <span>View Hospitals</span>
                            </a>
                            <a href="add_hospital.php" class="action-btn">
                                <i class="fas fa-plus"></i>
                                <span>Add Hospital</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3>Donations</h3>
                    </div>
                    <div class="card-body">
                        <div class="card-content">
                            <div class="card-icon donation">
                                <i class="fas fa-hand-holding-heart fa-2x"></i>
                            </div>
                            <div class="card-text">
                                <h4>$4,250</h4>
                                <p>Total Donations This Month</p>
                            </div>
                        </div>
                        <div class="quick-actions">
                            <a href="admin_donation.php" class="action-btn">
                                <i class="fas fa-list"></i>
                                <span>All Donations</span>
                            </a>
                            <a href="admin_money_donations.php" class="action-btn">
                                <i class="fas fa-money-bill-wave"></i>
                                <span>Money</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Quick Links Section -->
            <div class="card">
                <div class="card-header">
                    <h3>Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="quick-actions">
                        <a href="admin_food_donations.php" class="action-btn">
                            <i class="fas fa-utensils"></i>
                            <span>Food Donations</span>
                        </a>
                        <a href="admin_item_donations.php" class="action-btn">
                            <i class="fas fa-box-open"></i>
                            <span>Item Donations</span>
                        </a>
                        <a href="confirm_item_donation.php" class="action-btn">
                            <i class="fas fa-tasks"></i>
                            <span>Manage Items</span>
                        </a>
                        <a href="confirm_food_donation.php" class="action-btn">
                            <i class="fas fa-tasks"></i>
                            <span>Manage Food</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>