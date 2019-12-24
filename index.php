<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Registration Form</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>

  <body>
    <div class="navbar-wrapper">
      <div class="container">
			<h1>Register here!</h1>
			<p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
			<hr/>
      </div>
    </div>

    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container">
		<div class="row">
			<div class="col-xs-12">
				<form method="post" action="index.php" enctype="multipart/form-data" >
					<div class="form-group col-lg-4">Name  <input type="text" name="name" id="name" class="form-control"/></div>
					<div class="form-group col-lg-4">Email <input type="text" name="email" id="email" class="form-control"/></div>
					<div class="form-group col-lg-4">Job <input type="text" name="job" id="job" class="form-control"/></div>
					<div class="form-group col-lg-4">
						<input type="submit" name="submit" value="Submit"  class="btn btn-success"/>
						<input type="submit" name="load_data" value="Load Data"  class="btn btn-info"/>
					</div>
				</form>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
			 <?php
				$host = "akhirwanappserver.database.windows.net";
				$user = "akhirwan";
				$pass = "Padaringan_k383k";
				$db = "dicodingdb";

				try {
					$conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
					$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
				} catch(Exception $e) {
					echo "Failed: " . $e;
				}

				if (isset($_POST['submit'])) {
					try {
						$name = $_POST['name'];
						$email = $_POST['email'];
						$job = $_POST['job'];
						$date = date("Y-m-d");
						// Insert data
						$sql_insert = "INSERT INTO Registration (name, email, job, date) 
									VALUES (?,?,?,?)";
						$stmt = $conn->prepare($sql_insert);
						$stmt->bindValue(1, $name);
						$stmt->bindValue(2, $email);
						$stmt->bindValue(3, $job);
						$stmt->bindValue(4, $date);
						$stmt->execute();
					} catch(Exception $e) {
						echo "Failed: " . $e;
					}

					echo "<h3 class='alert alert-info'>You're registered!</h3>";
				} else if (isset($_POST['load_data'])) {
					try {
						$sql_select = "SELECT * FROM Registration";
						$stmt = $conn->query($sql_select);
						$no = 1;
						$registrants = $stmt->fetchAll(); 
						if(count($registrants) > 0) {
							echo "<h2>People who are registered:</h2>";
							echo "<div class='responsive'><table class='table table-hover table-striped'>";
							echo "<tr class='success'><th>No</th>";
							echo "<th>Name</th>";
							echo "<th>Email</th>";
							echo "<th>Job</th>";
							echo "<th>Date</th></tr>";
							foreach($registrants as $registrant) {
								echo "<tr><td>".$no++."</td>";
								echo "<td>".$registrant['name']."</td>";
								echo "<td>".$registrant['email']."</td>";
								echo "<td>".$registrant['job']."</td>";
								echo "<td>".$registrant['date']."</td></tr>";
							}
							echo "</table></div>";
						} else {
							echo "<h3>No one is currently registered.</h3>";
						}
					} catch(Exception $e) {
						echo "Failed: " . $e;
					}
				}
			?>
			</div>
		</div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
