<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Pet</title>
    <link rel="stylesheet" href="assets/css/add-pet.css"> <!-- Optional external CSS -->
    <style>
        

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            background-color: #E3D7ED;
            color: black;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 6px;
            font-size: 14px;
            transition: background-color 0.2s ease;
        }

        .back-btn:hover {
            background-color: #E3D7ED;
        }

       
    </style>
</head>
<body>

    <!-- LEFT SIDE -->
    <div class="left-section">
        <div class="welcome-message">
            <h1>Welcome to Stray Heart</h1>
            <p>Add your beloved pet to our community! Fill out the form to register your pet's details.</p>
            <p>We can't wait to meet your furry friend!</p>
            <div class="image-container">
                <img src="assets/images/home.png" alt="Cute Pet">
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE -->
    <div class="right-section">
        <div class="form-container">

            <!-- Back Button -->
            <a href="admin_dashboard.php" class="back-btn">← Back to Dashboard</a>

            <h2>Add New Pet</h2>
            <form action="insert-pet.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Pet Name" required>
                <input type="text" name="age" placeholder="Pet Age" required>
                <input type="text" name="breed" placeholder="Breed" required>
                <input type="text" name="species" placeholder="Species" required>
                <textarea name="description" placeholder="Description (Personality, habits, etc.)" rows="4" required></textarea>
                <input type="file" name="image" required>
                <button type="submit" name="submit">Add Pet</button>
            </form>
        </div>
    </div>

</body>
</html>
