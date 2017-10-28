<?php
	session_start();
	if ($_SESSION['first_name'] === null || $_SESSION['last_name'] === null || $_SESSION['email'] === null) {
		header("Location: ../login_and_register/index.php");
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>VES-ESAS</title>
	<link rel="stylesheet" type="text/css" href="addExam.css" />
	<link href="https://fonts.googleapis.com/css?family=Lato:100,100i,300,300i,400,400i,700,700i,900,900i" rel="stylesheet">
</head>
<body>

	<!-- header component -->
  <div class="gen_header">
    
    <div class="header_img"> 
      <img src="../login_and_register/ves-logo.png" />
    </div>
    
    <div class="header_title">
      <a href="../home/index.php">VESIT - ESAS</a>
      <hr>
      <div class="header_subtitle">VESIT Examination Staff Allotment System</div>
      <div class="header_info">Welcome <?php echo $_SESSION['first_name']." ".$_SESSION['last_name']."!"; ?></div>
    </div>

	  <div class="logout">
	    <button onclick="location.href='../login_and_register/logout.php'">LOGOUT</button>
	  </div>	

  </div>
  <div class="home_navigator">
  	<div class="link"><a href="../home/index.php">🡨 Go Back</a></div>
  </div>
  
  <!-- content body -->
  <div class="container_body">
  	<div class="container">
			  <div class="exam_form_header">
					<div class="title">Examination List!</div>
					<div class="subtitle">Update or delete exams: </div>
				</div>
				<div class="staff_list">

					<table width="100%">

						<tr>
							<th>Course ID</th>
							<th>Course Name</th>
							<th>Held On</th>
							<th>Start Time</th>
							<th>End Time</th>
							<th>Room No.</th>
							<th>Update</th>
							<th>Delete</th>
						</tr>

						<?php 
							$db = new mysqli('localhost', 'root', '', 'esas') 
								or die("Error connecting to database!");

							$sql = "SELECT * from exam";

							$results = $db->query($sql);

							while($row = $results->fetch_assoc()) {
								?>

								<tr>
									<td><?php echo $row['course_id']; ?></td>
									<td><?php echo $row['course_name']; ?></td>
									<td><?php echo date('d-m-Y', strtotime($row['held_on']));; ?></td>
									<td><?php echo date('H:i', strtotime($row['start_time'])); ?></td>
									<td><?php echo date('H:i', strtotime($row['end_time'])); ?></td>
									<td><?php echo $row['room_no']; ?></td>
									<td>
										<form method="POST" action="updateExam.php">
											<input type="hidden" name="update_id" value='<?php echo $row['_id'] ?>' />
											<div class="update">
												<button type="submit">UPDATE</button>	
											</div>
										</form>
									</td>
									<td>
										<form method="POST" action="deleteExam.php">
											<input type="hidden" name="delete_id" value='<?php echo $row['_id'] ?>' />
											<div class="delete">
												<button type="submit">DELETE</button>	
											</div>
										</form>
									</td>
								</tr>
								
								<?php
							}
						?>

					</table>

				</div>
		</div>
	</div>

</body>
</html>
