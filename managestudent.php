<?php
session_start();
if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <title>Welcome to Final Project Management System</title>
</head>

    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #F7F7F7;
      }
      .container {
        width: 800px;
        margin: 50px auto;
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
      }
      h1 {
        text-align: center;
        margin-top: 50px;
        font-size: 36px;
        color: #333;
      }
      table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
      }
      th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
        font-size: 18px;
      }
      th {
        background-color: #ddd;
      }
      th, td {
        border: 1px solid #ccc;
        padding: 10px;
        text-align: left;
      }
      .btn-add {
        background-color: green;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
        cursor: pointer;
      }
      .btn-delete {
        background-color: red;
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
        cursor: pointer;
        margin-left: 20px;
      }

      .add-student-btn {
      background-color: green;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      cursor: pointer;
    }

    .popup-page {
      display: none;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0, 0, 0, 0.5);
      z-index: 1;
    }

    .popup-page-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background-color: white;
      padding: 20px;
      border-radius: 5px;
    }

    .close-popup-page {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 18px;
      cursor: pointer;
    }
    </style>
  </head>
  <body>
  <a href="lecturer.php" class="w3-bar-item w3-button w3-right">Back</a>
    <header class="w3-header w3-blue w3-center w3-padding-32 ">
        <h1>FINAL PROJECT MANAGEMENT SYSTEM</h1>
    </header>
    <div class="container">
      <h1>Student List</h1>
      <table>
        <tr>
          <th>Name</th>
          <th>Matric Number</th>
          <th>Project Name</th>
          <th>Supervisor Name</th>
          <th>Action</th>
        </tr>
        <tr>
          <td>John Doe</td>
          <td>A01234567</td>
          <td>Web Development</td>
          <td>Dr. Smith</td>
          <td>
            <a href="#" class="btn-delete">Delete</a>
          </td>
        </tr>
        <tr>
          <td>Jane Doe</td>
          <td>A01234568</td>
          <td>Mobile App Development</td>
          <td>Dr. Johnson</td>
          <td>
            <a href="#" class="btn-delete">Delete</a>
          </td>

        </tr>
        <tr>
          <td>Bob Smith</td>
          <td>A01234569</td>
          <td>Data Analytics</td>
          <td>Dr. Lee</td>
          <td>
            <a href="#" class="btn-delete">Delete</a>
          </td>

        </tr>
        <tr>
          <td>Alice Johnson</td>
          <td>A01234570</td>
          <td>Machine Learning</td>
          <td>Dr. Chen</td>
          <td>
            <a href="#" class="btn-delete">Delete</a>
          </td>

        </tr>
      </table>
    </div>
    <a class="add-student-btn" href="#">Add Student</a>

  <div class="popup-page">
    <div class="popup-page-content">
      <span class="close-popup-page">&times;</span>
      <form>
        <label for="matric-number">Matric Number:</label>
        <input type="text" id="matric-number">
        <input type="submit" value="Submit">
      </form>
    </div>
  </div>

  <script>
    const addStudentBtn = document.querySelector('.add-student-btn');
    const popupPage = document.querySelector('.popup-page');
    const closePopupPage = document.querySelector('.close-popup-page');

    addStudentBtn.addEventListener('click', function(event) {
      event.preventDefault();
      popupPage.style.display = 'block';
    });

    closePopupPage.addEventListener('click', function() {
      popupPage.style.display = 'none';
    });
  </script>
  </body>
</html>