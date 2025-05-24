<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare Admin Dashboard</title>
    <style>
        :root {
            --primary: #4e73df;
            --secondary: #1cc88a;
            --danger: #e74a3b;
            --warning: #f6c23e;
            --info: #36b9cc;
            --dark: #5a5c69;
            --light: #f8f9fc;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f8f9fc;
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background: linear-gradient(180deg, var(--primary) 0%, #224abe 100%);
            color: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
            transition: all 0.3s;
            position: fixed;
            height: 100vh;
            z-index: 100;
        }
        
        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .sidebar-header h3 {
            font-weight: 600;
            font-size: 1.2rem;
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .menu-category {
            padding: 0.5rem 1.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 1rem;
        }
        
        .menu-item {
            padding: 0.75rem 1.5rem;
            display: flex;
            align-items: center;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .menu-item:hover {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .menu-item i {
            margin-right: 0.5rem;
            font-size: 1.1rem;
        }
        
        .menu-item.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 250px;
            padding: 1.5rem;
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            margin-bottom: 2rem;
        }
        
        .page-title h1 {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        .user-profile {
            display: flex;
            align-items: center;
        }
        
        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }
        
        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .card {
            background: white;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            overflow: hidden;
            transition: transform 0.3s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid #e3e6f0;
            background-color: #f8f9fc;
        }
        
        .card-header h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--dark);
        }
        
        .card-body {
            padding: 1.5rem;
        }
        
        .card-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-right: 1rem;
        }
        
        .card-icon.pets {
            background-color: rgba(78, 115, 223, 0.1);
            color: var(--primary);
        }
        
        .card-icon.hospital {
            background-color: rgba(28, 200, 138, 0.1);
            color: var(--secondary);
        }
        
        .card-icon.adoption {
            background-color: rgba(246, 194, 62, 0.1);
            color: var(--warning);
        }
        
        .card-icon.donation {
            background-color: rgba(54, 185, 204, 0.1);
            color: var(--info);
        }
        
        .card-content {
            display: flex;
            align-items: center;
        }
        
        .card-text h4 {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        
        .card-text p {
            color: var(--dark);
            opacity: 0.8;
            font-size: 0.9rem;
        }
        
        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }
        
        .action-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 1.5rem 1rem;
            background: white;
            border-radius: 0.35rem;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
            text-align: center;
            text-decoration: none;
            color: var(--dark);
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            background-color: var(--primary);
            color: white;
            transform: translateY(-3px);
        }
        
        .action-btn i {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .action-btn span {
            font-size: 0.9rem;
            font-weight: 500;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                width: 0;
                overflow: hidden;
            }
            
            .main-content {
                margin-left: 0;
            }
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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