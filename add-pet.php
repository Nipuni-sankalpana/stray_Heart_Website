<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Pet</title>
    <link rel="stylesheet" href="assets/css/add-pet.css">
    
</head>
    

<body>
 
   
    <div class="left-section">
        <div class="welcome-message">
            <h1>Welcome to Stray Heart</h1>
            <p>Add your beloved pet to our community! Fill out the form to register your pet's details.</p>
            <p>We can't wait to meet your furry friend! </p>
            <div class="image-container">
            <img src="assets/images/home.png">
            </div>
        </div>
    </div>

   
    <div class="right-section">
        <div class="form-container">
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
     <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>
