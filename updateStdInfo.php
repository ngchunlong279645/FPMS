<?php
session_start();
$name = $_SESSION["name"];
include_once("dbconnect.php");
$sql = "SELECT * FROM tbl_student WHERE std_name = '$name'";
$select_stmt = $conn->prepare($sql);
$select_stmt->execute();
$row = $select_stmt->fetch(PDO::FETCH_ASSOC);
$user_id = $row["user_id"];

if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}

if (isset($_POST['submit'])) {
	include_once("dbconnect.php");
	$matric= $_POST['matric'];
    $description = addslashes($_POST['description']);
    $tel= $_POST['tel'];
    $address = $_POST['address'];
    $email = addslashes($_POST['email']);
    $dob = addslashes($_POST['dob']);
    $gender = $_POST['gender'];
    $races = $_POST['races'];
    $course = addslashes($_POST['course']);
    $sqlupdateInfo = "UPDATE `tbl_student` SET `std_matric`='$matric',`std_description`='$description',
   `std_tel`='$tel',`std_email`='$email',`std_address`='$address',`std_dateofbirth`='$dob',`std_gender`='$gender',
   `std_races`='$races',`std_course`='$course' WHERE std_name = '$name'";
   try {
	$conn->exec( $sqlupdateInfo);
	if (file_exists($_FILES["fileToUpload"]["tmp_name"]) || is_uploaded_file($_FILES["fileToUpload"]["tmp_name"])) {
		uploadImage($user_id);
		echo "<script>alert('Success')</script>";
		echo "<script>window.location.replace('student.php')</script>";
	} else {
		echo "<script>alert('Success')</script>";
		echo "<script>window.location.replace('student.php')</script>";
	}
} catch (PDOException $e) {
	echo "<script>alert('Failed')</script>";
	echo "<script>window.location.replace('updateStdInfo.php?submit=details&user_id=$user_id')</script>";
}
}


function uploadImage($filename)
{
    $target_dir = "../user/student/";
    $target_file = $target_dir . $filename . ".png";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
}

if (isset($_GET['submit'])) {
    $operation = $_GET['submit'];
    if ($operation == 'details') {
        $user_id = $_GET['user_id'];
        $sqlupdateInfo = "SELECT * FROM tbl_student WHERE user_id = '$user_id'";
        $stmt = $conn->prepare( $sqlupdateInfo);
        $stmt->execute();
        $rows = $stmt->fetchAll();
        $number_of_rows = $stmt->rowCount();
        if ($number_of_rows > 0) {
            foreach ($rows as $student) {
				$student_matric = $student['std_matric'];
                $student_description = $student['std_description'];
                $student_tel = $student['std_tel'];
                $student_email = $student['std_email'];
                $student_address = $student['std_address'];
                $student_dateofbirth = $student['std_dateofbirth'];
                $student_gender = $student['std_gender'];
				$student_races = $student['std_races'];
				$student_course = $student['std_course'];
            }
        }else{
           echo "<script>alert('No student found')</script>";
           echo "<script>window.location.replace('student.php')</script>";
        }
    }
}else{
   echo "<script>alert('Error')</script>";
   echo "<script>window.location.replace('updateStdInfo.php')</script>";
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="../login/js/script.js"></script>
	<title>Edit Information</title>
	<style>
		body {
			margin: 0;
			padding: 0;
			background-color: #f2f2f2;
			font-family: Arial, sans-serif;
		}

		h1 {
			text-align: center;
			margin-top: 50px;
			color: #333;
		}

		form {
			max-width: 500px;
			margin: 0 auto;
			padding: 20px;
			background-color: #fff;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
		}

		.form-group {
			margin-bottom: 20px;
		}

		label {
			display: block;
			margin-bottom: 5px;
			font-weight: bold;
			color: #333;
		}

		input[type="text"],
		input[type="email"],
		input[type="tel"],
		select,
		textarea {
			display: block;
			width: 100%;
			padding: 10px;
			border-radius: 5px;
			border: 1px solid #ccc;
			font-size: 16px;
			color: #333;
			box-sizing: border-box;
		}

		textarea {
			height: 100px;
			resize: vertical;
		}

		.form-group-radio {
			display: flex;
			flex-direction: row;
			align-items: center;
			margin-bottom: 10px;
		}

		input[type="radio"] {
			margin-right: 5px;
		}

		.btn {
			display: inline-block;
			padding: 10px 20px;
			background-color: #0066cc;
			color: #fff;
			font-size: 16px;
			font-weight: bold;
			text-decoration: none;
			border-radius: 5px;
			transition: background-color 0.2s ease;
			cursor: pointer;
			border: none;
		}

		.btn:hover {
			background-color: #0052a3;
		}
	</style>
</head>
<body>
<div class="w3-bar w3-grey">
        <a href="student.php" class="w3-bar-item w3-button w3-right">Back</a>
    </div>
<div class="w3-content w3-padding-32">
        <form class="w3-card w3-padding" action="updateStdInfo.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('Are you sure?')">
                <h1>Personal Information</h1>
            
	<form>
  <div class="w3-container w3-center">
                <img class="w3-image w3-margin" src="../user/student/<?php echo $user_id?>.png" style="height:100%;width:250px"><br>
                <input type="file" name="fileToUpload" onchange="previewFile()">

				
  </div>
    <hr>
		<div class="form-group">
			<label for="name">Name:</label>
			<?php echo " $name" ?> 
		</div>
		<div class="form-group">
			<label for="name">Matric Number:</label>
			<input type="text" id="matric" name="matric" value="<?php echo $student_matric ?>" required>
		</div>
		<div class="form-group">
			<label for="description">Description:</label>
			<textarea id="description" name="description" required><?php echo $student_description ?></textarea>
		</div>
		<div class="form-group">
			<label for="tel">Telephone Number:</label>
			<input type="tel" id="tel" name="tel"  value="<?php echo $student_tel ?>" required>
		</div>
		<div class="form-group">
			<label for="address">Home Address:</label>
			<input type="text" id="address" name="address" value="<?php echo $student_address ?>" required>
		</div>
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" id="email" name="email" value="<?php echo $student_email ?>" required>
		</div>
		<div class="form-group">
			<label for="dob">Date of Birth:</label>
			<input type="date" id="dob" name="dob" value="<?php echo $student_dateofbirth ?>" required>
		</div>
		<div class="form-group">
			<label for="gender">Gender:</label>
			<input type="radio" id="gender_male" name="gender" value="Male" <?php if ($student_gender == "Male") { echo "checked"; } ?>>Male
			<input type="radio" id="gender_female" name="gender" value="Female" <?php if ($student_gender == "Female") { echo "checked"; } ?>>Female
		</div>
		<div class="form-group">
		<label for="races">Races:</label>
		<select class="w3-select w3-border w3-round" id="races" name="races" required>
			<option disabled selected>Select a race</option>
			<option value="Malay" <?php if ($student_races == "Malay") { echo "selected"; } ?>>Malay</option>
			<option value="Chinese" <?php if ($student_races == "Chinese") { echo "selected"; } ?>>Chinese</option>
			<option value="Indian" <?php if ($student_races == "Indian") { echo "selected"; } ?>>Indian</option>
			<option value="Other" <?php if ($student_races == "Other") { echo "selected"; } ?>>Other</option>
		</select>
		</div>

        <div class="form-group">
		<label for="races">Course:</label>
		<select class="w3-select w3-border w3-round" id="course" name="course" required>
			<option disabled selected>Select a course</option>
			<option value="Information Technology" <?php if ($student_course == "Information Technology") { echo "selected"; } ?>>Information Technology</option>
			<option value="Computer Science" <?php if ($student_course == "Computer Science") { echo "selected"; } ?>>Computer Science</option>
		</select>
		</div>
      
      <p>
         <input class="w3-button w3-blue w3-round w3-block w3-border" type="submit" name="submit" value="Save">
      </p>
  </div>
</body>
</html>
