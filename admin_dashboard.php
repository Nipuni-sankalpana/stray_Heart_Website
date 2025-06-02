<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetCare Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #E3D7ED;
            --text-color: #000000;
            --bg-color: #FFFFFF;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: var(--text-color);
        }
        
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        
        /* Sidebar Styles */
        .sidebar {
            width: 250px;
            background-color: var(--bg-color);
            color: var(--text-color);
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }
        
        .sidebar-header {
            padding: 20px;
            background-color: var(--primary-color);
            text-align: center;
        }
        
        .sidebar-header h3 {
            margin: 0;
            color: var(--text-color);
        }
        
        .menu-category {
            padding: 15px 20px 5px;
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
            font-weight: bold;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s;
        }
        
        .menu-item:hover {
            background-color: var(--primary-color);
        }
        
        .menu-item.active {
            background-color: var(--primary-color);
            border-left: 4px solid var(--text-color);
        }
        
        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }
        
        /* Main Content Styles */
        .main-content {
            flex: 1;
            padding: 20px;
            background-color: #f9f9f9;
        }
        
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #ddd;
        }
        
        .user-profile {
            display: flex;
            align-items: center;
        }
        
        .user-profile img {
            border-radius: 50%;
            margin-right: 10px;
        }
        
        /* Card Styles */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        
        .card {
            background-color: var(--bg-color);
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .card-header {
            padding: 15px 20px;
            background-color: var(--primary-color);
            border-bottom: 1px solid #ddd;
        }
        
        .card-header h3 {
            margin: 0;
            color: var(--text-color);
        }
        
        .card-body {
            padding: 20px;
        }
        
        .card-content {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            background-color: var(--primary-color);
            color: var(--text-color);
        }
        
        .card-text h4 {
            margin: 0;
            font-size: 24px;
        }
        
        .card-text p {
            margin: 5px 0 0;
            color: #666;
        }
        
        .quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .action-btn {
            display: flex;
            align-items: center;
            padding: 8px 15px;
            background-color: var(--primary-color);
            color: var(--text-color);
            text-decoration: none;
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .action-btn:hover {
            background-color: #d0c4e0;
        }
        
        .action-btn i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3>Stray Heart Admin</h3>
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
                <a href="manage_stalls.php" class="menu-item">
                    <i class="fas fa-fw fa-store"></i>
                    <span>Manage Stalls</span>
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
            </div>
            
            <!-- Dashboard Cards -->
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-header">
                        <h3>Pets Management</h3>
                    </div>
                    <div class="card-body">
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
                        <div class="quick-actions">
                            <a href="admin-adoption.php" class="action-btn">
                                <i class="fas fa-tasks"></i>
                                <span>Manage Adoptions</span>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="card">
                    <div class="card-header">
                        <h3>Hospitals</h3>
                    </div>
                    <div class="card-body">
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
                
            
            <!-- Quick Links Section -->
            <div class="card">
                <div class="card-header">
                    <h3>Donations & stalls</h3>
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
                        <a href="manage_stalls.php" class="action-btn">
                            <i class="fas fa-store"></i>
                            <span>Manage Stalls</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
