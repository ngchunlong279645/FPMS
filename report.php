<?php
session_start();
$name = $_SESSION["name"];

include 'dbconnect.php';

if (!isset($_SESSION['session_id'])) {
    echo "<script>alert('Session not available. Please login');</script>";
    echo "<script> window.location.replace('login.php')</script>";
}



$sqlprojects = "SELECT * FROM tbl_projects";
$stmt = $conn->prepare($sqlprojects);
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
    width: 10%;
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
    <a href="#">
        <button ><i class="fa fa-graduation-cap" style="color: black;"></i> Student</button>
    </a>
    

	</div>

	<div class="content">
        <a href="admin.php">
            <button class="back-button">Back</button>
        </a>

		<div class="page-title">Project</div>
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
                    <div class="container">
                <div class="table-container">
                    <div class="scrollable-table-container">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Project ID</th>
                                    <th>Project Title</th>
                                    <th>Project Start Date</th>
                                    <th>Project End Date</th>
                                    <th>Student Name</th>
                                    <th>Client Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <tr>
                                        <td><?php echo $row["project_id"]; ?></td>
                                        <td><?php echo $row["project_title"]; ?></td>
                                        <td><?php echo $row["project_start"]; ?></td>
                                        <td><?php echo $row["project_end"]; ?></td>
                                        <td><?php echo $row["std_name"]; ?></td>
                                        <td><?php echo $row["project_client"]; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="chart-container">
                    <?php
                        $projects_with_std_name = 0;
                        $projects_without_std_name = 0;

                        foreach ($rows as $row) {
                            if (!empty($row["std_name"])) {
                                $projects_with_std_name++;
                            } else {
                                $projects_without_std_name++;
                            }
                        }
                    ?>

                    <canvas id="projectPieChart" width="250" height="230"></canvas>
                    <canvas id="projectBarChart" width="250" height="230"></canvas>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        var ctxPie = document.getElementById('projectPieChart').getContext('2d');
                        var projectPieChart = new Chart(ctxPie, {
                            type: 'pie',
                            data: {
                                labels: ['Registered Project', 'Unregistered Project'],
                                datasets: [{
                                    data: [<?php echo $projects_with_std_name; ?>, <?php echo $projects_without_std_name; ?>],
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

                        var ctxBar = document.getElementById('projectBarChart').getContext('2d');
                        var projectBarChart = new Chart(ctxBar, {
                            type: 'bar',
                            data: {
                                labels: ['Registered Project', 'Unregistered Project'],
                                datasets: [{
                                    label: 'Number of Projects',
                                    data: [<?php echo $projects_with_std_name; ?>, <?php echo $projects_without_std_name; ?>],
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
                <div class="table-container">
                    <div class="scrollable-table-container">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Project ID</th>
                                    <th>Project Title</th>
                                    <th>Project Start Date</th>
                                    <th>Project End Date</th>
                                    <th>Student Name</th>
                                    <th>Client Name</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <?php if (!empty($row["std_name"])): ?>
                                        <tr>
                                            <td><?php echo $row["project_id"]; ?></td>
                                            <td><?php echo $row["project_title"]; ?></td>
                                            <td><?php echo $row["project_start"]; ?></td>
                                            <td><?php echo $row["project_end"]; ?></td>
                                            <td><?php echo $row["std_name"]; ?></td>
                                            <td><?php echo $row["project_client"]; ?></td>
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
                <div class="table-container">
                    <div class="scrollable-table-container">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Project ID</th>
                                    <th>Project Title</th>
                                    <th>Project Start Date</th>
                                    <th>Project End Date</th>
                                    <th>Client Name</th>
                                </tr>
                            </thead>
                            <tbody>
                            <tbody>
                                <?php foreach ($rows as $row): ?>
                                    <?php if (empty($row["std_name"])): ?>
                                        <tr>
                                            <td><?php echo $row["project_id"]; ?></td>
                                            <td><?php echo $row["project_title"]; ?></td>
                                            <td><?php echo $row["project_start"]; ?></td>
                                            <td><?php echo $row["project_end"]; ?></td>
                                            <td><?php echo $row["project_client"]; ?></td>
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
