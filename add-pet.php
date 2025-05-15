<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Pet</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background: #fff;
        }
        .navbar {
  background-color: transparent !important;
}

.navbar-brand {
  font-weight: 700;
  color: #e3d7ed !important;
}

.nav-link {
  color: black !important;
  font-weight: 500;
  margin: 0 5px;
  transition: all 0.3s ease;
}

.nav-link:hover {
  color: white !important;
  transform: translateY(-2px);
}

.btn-adopt {
  background-color: #E3D7ED;
  color: black !important;
  border-radius: 50px;
  padding: 8px 20px !important;
  font-weight: 600;
}

.btn-adopt:hover {
  background-color: #d0c4dd;
  transform: translateY(-2px);
}

        /* Left Section - Welcome Message */
        .left-section {
            flex: 1;
            background-color: #e3d7ed; /* Soft Lavender */
            padding: 50px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        .welcome-message {
            max-width: 450px;
            text-align: center;
        }

        .welcome-message h1 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #000;
        }

        .welcome-message p {
            font-size: 1.1rem;
            line-height: 1.6;
            margin-bottom: 15px;
            color: #333;
        }

        /* Right Section - Pet Form */
        .right-section {
            flex: 1;
            background-color: #fff;
            padding: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e3d7ed;
        }

        .form-container h2 {
            color: #000;
            text-align: center;
            margin-bottom: 25px;
            font-size: 1.8rem;
        }

        input, textarea, button {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border-radius: 6px;
            border: 1px solid #ddd;
            font-size: 15px;
            transition: all 0.3s;
        }

        input:focus, textarea:focus {
            outline: none;
            border-color: #e3d7ed;
            box-shadow: 0 0 0 2px rgba(227, 215, 237, 0.3);
        }

        button {
            background: #000;
            color: white;
            border: none;
            font-weight: bold;
            cursor: pointer;
            margin-top: 15px;
        }

        button:hover {
            background: #333;
        }

        ::placeholder {
            color: #999;
        }

        input[type="file"] {
            padding: 10px;
            background: #f9f9f9;
        }
        .image-container {
    margin-top: 50px;
    display: flex;
    justify-content: center;
}
.image-container img {
    width: 300px;
    height: auto;
    border-radius: 20px;
    animation: float 3s ease-in-out infinite;
}

    </style>
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
