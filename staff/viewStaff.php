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
	<link rel="stylesheet" type="text/css" href="addStaff.css" />
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
					<div class="title">Staff Member List!</div>
					<div class="subtitle">Update or delete staff members: </div>
				</div>
				<div class="staff_list">

					<table width="100%">

						<tr>
							<th>Sr. No.</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>E-Mail</th>
							<th>Position</th>
							<th>Times Available</th>
							<th>Available</th>
							<th>Update</th>
							<th>Delete</th>
						</tr>

						<?php 
							$db = new mysqli('localhost', 'root', '', 'esas') 
								or die("Error connecting to database!");

							$sql = "SELECT * from staff";

							$results = $db->query($sql);

							$i = 1;
							while($row = $results->fetch_assoc()) {
								?>

								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row['firstname']; ?></td>
									<td><?php echo $row['lastname']; ?></td>
									<td><?php echo $row['email']; ?></td>
									<td>
										<?php 
											switch ($row['position']) {
												case 'professor':
													echo "Professor";
													break;
												case 'associateProfessor':
													echo "Associate Professor";
													break;
												case 'assistantProfessor':
													echo "Assistant Professor";
													break;
												case 'lecturer':
													echo "Lecturer";
													break;
												default:
													echo "Not Assigned";
													break;
											}
										?>
									</td>
									<td><?php echo $row['noa']; ?></td>
									<?php
										if ($row['available']) {
											echo "<td>Yes</td>";
										} else {
											echo "<td>No</td>";
										}
									?>
									<td>
										<form method="POST" action="updateStaff.php">
											<input type="hidden" name="update_id" value='<?php echo $row['_id'] ?>' />
											<div class="update">
												<button type="submit">UPDATE</button>	
											</div>
										</form>
									</td>
									<td>
										<form method="POST" action="deleteStaff.php">
											<input type="hidden" name="delete_id" value='<?php echo $row['_id'] ?>' />
											<div class="delete">
												<button type="submit">DELETE</button>	
											</div>
										</form>
									</td>
								</tr>
								
								<?php
								$i++;
							}
						?>

					</table>

				</div>
		</div>
	</div>

</body>
</html>
