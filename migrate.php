<?php
session_start(); ?>


<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous" />

	<title>Wordpress DB migrate</title>
</head>

<body>
	<br /><br />

	<?php

	date_default_timezone_set("Asia/Colombo");
	// ini_set("upload_max_filesize","30M");
	$target_path = "uploads/";
	// echo ini_get('upload_max_filesize'), ", " , ini_get('post_max_size');

	function __autoload($class_name)
	{
		require_once 'lib/' . $class_name . '.php';
	}


	if (isset($_FILES['uploadedfile'])) {
		$now = date("Ymdhis");
		$fileName = $_FILES['uploadedfile']['name'];
		$_SESSION["oldfilename"] = $fileName;
		$fileName = str_replace('.', "-$now.", $fileName);
		$_SESSION["newfilename"] = $fileName;

		// $target_path = $target_path . basename( $_FILES['uploadedfile']['name']);
		$target_path = $target_path . basename($fileName);
		// var_dump($target_path);

		$alert = '';
		if (move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $target_path)) {
			$alert = "<span style=\"color:green\">The file <b>" .  basename($_FILES['uploadedfile']['name']) .
				" </b>has been uploaded</span><br/><br/>";
		}
		// $target_path = "ours2017.sql";

		$mter = new Regx($fileName);


	?>





		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<a href="index.php">Wordpress Database Migration</a>
						</div>
						<div class="card-body">
							<h5 class="card-title">Step 02</h5>
							<p class="card-text">
								<?php echo $alert; ?>
							</p>
							<form name="form1" method="post" action="">

								<div class="form-group">
									<label for="email">File Name:</label>
									<input type="test" class="form-control" id="filename" name="filename" value="<?php echo $fileName; ?>" readonly>
								</div>

								<div class="form-group">
									<label for="email">Old Site URL:</label>
									<input type="text" class="form-control" id="oldsite" name="oldsite" value="<?php echo $mter->getOldSiteName(); ?>" readonly>
								</div>

								<div class="form-group">
									<label for="email">News Site URL:</label>
									<input type="text" class="form-control" id="newsite" name="newsite" value="<?php echo $mter->getOldSiteName(); ?>">
								</div>

								<button type="submit" name="step3" id="step3" class="btn btn-primary">Change DB</button>


							</form>

						</div>
					</div>
				</div>
			</div>
		</div>




	<?php





		// } else{
		// 	echo "<span style=\"color:red\">There was an error uploading the file, please try again!</span><br/><br/>";
		// }


	}



	if (isset($_POST['step3'])) {
		//echo 'aaaaaaaaaaaaaaaaaaaa';
		// $target_file="ours2017.sql";
		$target_file = $_POST['filename'];
		$mter = new Regx($target_file);

		// echo $mter->fileContent;
		$oldSiteUrl = $_POST['oldsite']; //'http://www.ou.ac.lk/ours';
		$newSiteUrl = $_POST['newsite'];  //'http://www.ou.ac.lk/ours11';
		$_SESSION["oldSiteUrl"] = $oldSiteUrl;
		$_SESSION["newSiteUrl"] = $newSiteUrl;

		$diffNoOfCharactors = strlen($oldSiteUrl) - strlen($newSiteUrl);
		$mter->diffNoOfCharactors = $diffNoOfCharactors;

		$mter->oldSiteUrl = $oldSiteUrl;
		$mter->newSiteURL = $newSiteUrl;

	?>

		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<a href="index.php">Wordpress Database Migration</a>
						</div>
						<div class="card-body">
							<h5 class="card-title">Step 03</h5>
							<p class="card-text">
								<?php echo $mter->matchAll($oldSiteUrl, $newSiteUrl); ?>
								Download your migrated DB file from here : <a href="downloads/<?php echo $_SESSION["newfilename"]; ?>">download</a>
							</p>

						</div>
					</div>
				</div>
			</div>
		</div>

		

	<?php
	}

	?>


	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>