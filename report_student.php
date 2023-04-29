<?php
session_start();
$name = $_SESSION["name"];

include 'dbconnect.php';

if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}



$sqlstudent = "SELECT * FROM tbl_student";
$stmt = $conn->prepare($sqlstudent);
$stmt->execute();
$result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
$rows = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html>
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    body {
        font-family: Arial, sans-serif;
    }

    h1 {
        font-size: 45px;
        font-weight: bold;
        text-align: center;
        margin-top: 10px;
        margin-bottom: 60px;
        color: #36A2EB;
        }


    .sidebar {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 15%;
        background-color: #f1f1f1;
        padding: 20px;
        overflow: auto;
    }

    .sidebar button {
        display: block;
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #ddd;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .sidebar button:hover {
        background-color: #bbb;
    }

    .active {
    background-color: red;
    }

    .content {
        margin-left: 25%;
        padding: 20px;
    }

    .back-button {
        display: inline-block;
        padding: 5px 10px;
        background-color: #ddd;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-bottom: 10px;
    }

    .back-button:hover {
        background-color: #bbb;
    }

    .page-title {
        font-size: 24px;
        font-weight: bold;
        margin-top: 20px;
        margin-bottom: 40px;
       
    }

    .menu-bar {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    .menu-bar button {
        display: block;
        padding: 10px;
        background-color: #ddd;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-right: 10px;
    }

    .menu-bar .tablinks.active {
    background-color: #888;
    }

    .menu-bar button:hover {
        background-color: #bbb;
    }

    .menu-bar-line {
        border-bottom: 4px solid #b2d4ff;
        width: 100%;
        margin-bottom: 20px;
    }

    .export-button {
        display: inline-block;
        padding: 5px 10px;
        background-color: #ddd;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-left: auto;
    }

    .export-button:hover {
        background-color: #bbb;
    }

    .container {
        display: flex;
       
    }

    .chart-container {
        display: inline-block;
        vertical-align: top;
        margin-left: 50px; /* Add margin to the left */
    }

    .table-container {
        width: 60%;
        height: 450px; 
        margin-top: 20px;
        margin-right: 10px; /* Add margin to the right */
        border: 1px solid black;
    }

    .table-container2 {
        width: 100%;
        height: 450px; 
        margin-top: 20px;
        margin-right: 10px; /* Add margin to the right */
        border: 1px solid black;
    }


    .scrollable-table-container {
    height: 100%;
    overflow: auto;
    }

    .report-table {
    border-collapse: collapse;
    width: 100%;
    
    }

    .report-table th,
    .report-table td {
    
    padding: 8px;
    }

    .report-table th {
    background-color: #ddd;
    position: sticky;
    top: 0;
    
    }

    .report-table tbody tr:nth-child(even) {
    background-color: #f2f2f2;
    width: 20%;
    }

    .report-table tbody tr:hover {
    background-color: #ddd;
    }

    .sidebar #project-button.active {
        background-color: #b3d9ff;
    }
    


</style>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <title>Welcome to Final Project Management System</title>
</head>

<body>
    
	<div class="sidebar">
    <h1>Report</h1>
    <a href="report.php">
        <button class="active"><i class="fa fa-folder-open" style="color: black;"></i> Project</button>
    </a>
    <a href="report_student.php">
        <button class="active"><i class="fa fa-graduation-cap" style="color: black;"></i> Student</button>
    </a>
    

	</div>

	<div class="content">
        <a href="admin.php">
            <button class="back-button">Back</button>
        </a>

		<div class="page-title">Student</div>
		<div class="menu-bar">
            <button class="tablinks active" id="defaultOpen" onclick="openTab(event, 'overview-tab')">Overview</button>
            <button class="tablinks" onclick="openTab(event, 'registered-tab')">Registered</button>
            <button class="tablinks" onclick="openTab(event, 'not-registered-tab')">Not Registered</button>
            <button class="export-button">Export</button>
            <script>
                const exportButton = document.querySelector('.export-button');

                exportButton.addEventListener('click', () => {
                // Get the table and chart elements
                const table = document.querySelector('#table-id');
                const chart = document.querySelector('#chart-id');

                // Print the table and chart
                window.print();
                });

            </script>
        </div>
        <div class="menu-bar-line"></div>
        <div id="overview-tab" class="tabcontent">
        <h3>Total number of students: <?php echo count($rows); ?></h3>
                    <div class="container">
                <div class="table-container">
                    <div class="scrollable-table-container">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Student Matric</th>
                                    <th>Student Name</th>
                                    <th>Tel</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Races</th>
                                    <th>Course</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?php echo $row["std_matric"]; ?></td>
                                        <td><?php echo $row["std_name"]; ?></td>
                                        <td><?php echo $row["std_tel"]; ?></td>
                                        <td><?php echo $row["std_email"]; ?></td>
                                        <td><?php echo $row["std_gender"]; ?></td>
                                        <td><?php echo $row["std_races"]; ?></td>
                                        <td><?php echo $row["std_course"]; ?></td>

                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="chart-container">
                    <?php
                        $std_name_with_projects = 0;
                        $std_name_without_projects = 0;

                        foreach ($rows as $row) {
                            if (!empty($row["project_title"])) {
                                $std_name_with_projects++;
                            } else {
                                $std_name_without_projects++;
                            }
                        }
                    ?>

                    <canvas id="stdPieChart" width="250" height="230"></canvas>
                    <canvas id="stdtBarChart" width="250" height="230"></canvas>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        var ctxPie = document.getElementById('stdPieChart').getContext('2d');
                        var stdPieChart = new Chart(ctxPie, {
                            type: 'pie',
                            data: {
                                labels: ['Student With Project', 'Student Without Project'],
                                datasets: [{
                                    data: [<?php echo $std_name_with_projects; ?>, <?php echo $std_name_without_projects; ?>],
                                    backgroundColor: ['#36A2EB', '#FFCE56'],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                legend: {
                                    position: 'bottom',
                                }
                            }
                        });

                        var ctxBar = document.getElementById('stdtBarChart').getContext('2d');
                        var stdtBarChart = new Chart(ctxBar, {
                            type: 'bar',
                            data: {
                                labels: ['Student With Project', 'Student Without Project'],
                                datasets: [{
                                    label: 'Number of Student With Project',
                                    data: [<?php echo $std_name_with_projects; ?>, <?php echo $std_name_without_projects; ?>],
                                    backgroundColor: ['#36A2EB', '#FFCE56'],
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                responsive: true,
                                legend: {
                                    display: false,
                                },
                                scales: {
                                    yAxes: [{
                                        ticks: {
                                            beginAtZero: true
                                        }
                                    }]
                                }
                            }
                        });
                    </script>
                </div>
            </div>
    
        </div>

        <div id="registered-tab" class="tabcontent">
            <div class="container">
                <div class="table-container2">
                    <div class="scrollable-table-container">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Student Matric</th>
                                    <th>Student Name</th>
                                    <th>Tel</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Races</th>
                                    <th>Course</th>
                                    <th>Project Title</th>
                                    <th>Client</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <?php if (!empty($row["project_title"])): ?>
                                        <tr>
                                        <td><?php echo $row["std_matric"]; ?></td>
                                        <td><?php echo $row["std_name"]; ?></td>
                                        <td><?php echo $row["std_tel"]; ?></td>
                                        <td><?php echo $row["std_email"]; ?></td>
                                        <td><?php echo $row["std_gender"]; ?></td>
                                        <td><?php echo $row["std_races"]; ?></td>
                                        <td><?php echo $row["std_course"]; ?></td>
                                        <td><?php echo $row["project_title"]; ?></td>
                                        <td><?php echo $row["client_name"]; ?></td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div id="not-registered-tab" class="tabcontent">
        <div class="container">
                <div class="table-container2">
                    <div class="scrollable-table-container">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Student Matric</th>
                                    <th>Student Name</th>
                                    <th>Tel</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Races</th>
                                    <th>Course</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <?php if (empty($row["project_title"])): ?>
                                        <tr>
                                            <td><?php echo $row["std_matric"]; ?></td>
                                            <td><?php echo $row["std_name"]; ?></td>
                                            <td><?php echo $row["std_tel"]; ?></td>
                                            <td><?php echo $row["std_email"]; ?></td>
                                            <td><?php echo $row["std_gender"]; ?></td>
                                            <td><?php echo $row["std_races"]; ?></td>
                                            <td><?php echo $row["std_course"]; ?></td>
                                           
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
        </div>
    
    </div>
       
    <!-- JavaScript code for switching tabs -->
    <script>
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }
            tablinks = document.getElementsByClassName("tablinks");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].className = tablinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
        document.getElementById("defaultOpen").click();
    </script>
</body>
</html>
