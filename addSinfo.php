<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['session_id'])) {
  header('Location: addSinfo.php');
  exit;
}

// If form is submitted
if (isset($_POST['submit'])) {
  // Get user inputs
  $profile_picture = $_POST['profile_picture'];
  $name = $_POST['name'];
  $telephone = $_POST['telephone'];
  $address = $_POST['address'];
  $age = $_POST['age'];
  $gender = $_POST['gender'];
  $race = $_POST['race'];
  
  // Insert user inputs into database
  $conn = mysqli_connect('localhost', 'username', 'password', 'database_name');
  $username = $_SESSION['username'];
  $sql = "INSERT INTO tbl_students (profile_picture, name, telephone, address, age, gender, race, username) VALUES ('$profile_picture', '$name', '$telephone', '$address', '$age', '$gender', '$race', '$username')";
  mysqli_query($conn, $sql);
  
  // Redirect back to user profile page
  header('Location: student.php');
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Information</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    
    header {
      background-color: #4285f4;
      color: #fff;
      text-align: center;
      padding: 20px;
    }
    
    h1 {
      margin: 0;
      font-size: 36px;
    }
    
    main {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }
    
    form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }
    
    label {
      font-weight: bold;
      margin-bottom: 5px;
    }
    
    input[type="text"] {
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
      border: 1px solid #ccc;
      width: 100%;
      max-width: 400px;
      box-sizing: border-box;
      font-size: 16px;
    }
    
    .btn {
      background-color: #4285f4;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    
    .btn:hover {
      background-color: #357ae8;
    }
  </style>
</head>
<body>
  <header>
    <h1>Add Information</h1>
  </header>
  
  <main>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      <label for="profile_picture">Profile Picture URL</label>
      <input type="text" name="profile_picture">
      <label for="name">Name</label>
      <input type="text" name="name" required>
      <label for="telephone">Telephone Number</label>
      <input type="text" name="telephone" required>
  <label for="address">Address</label>
  <input type="text" name="address" required>
  <label for="age">Age</label>
  <input type="text" name="age" required>
  <label for="gender">Gender</label>
  <select name="gender" required>
    <option value="">Select Gender</option>
    <option value="male">Male</option>
    <option value="female">Female</option>
    <option value="other">Other</option>
  </select>
  <label for="race">Race</label>
  <select name="race" required>
    <option value="">Select Race</option>
    <option value="asian">Asian</option>
    <option value="black">Black</option>
    <option value="latino">Latino</option>
    <option value="white">White</option>
    <option value="other">Other</option>
  </select>
  <button type="submit" name="submit" class="btn">Save</button>
</form>
  </main>
</body>
</html>