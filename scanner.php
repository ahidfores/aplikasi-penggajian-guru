<?php include "header.php"; ?>
<!-- <!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
	<title>Hello, world!</title>
</head>
<body>	 -->
	<div class="my-3 container justify-content-center">
		<div class="row">
			<div class="col-md-6 col-lg-6">
				<div class="card">
					<div class="card-header">
						Here Is the Camera Scanner
					</div>
					<div class="card-body">
						<video id="preview" style="width:100%;">
						</video>
					</div>
				</div>
			</div>
			<div class="col-md-6 col-lg-6">
				<div class="card">
					<div class="card-header">
						Here Is the Scan Result
					</div>
					<div class="card-body">
						<input type="text" name="" class="form-control" id="res_holder">
					</div>
				</div>
			</div>
		</div>
	</div>	
	<!-- End footer Area -->	
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
	<script type="text/javascript" src="http://localhost/apppenggajianguru/assets/js/is/jquery.min.js"></script>
	<script type="text/javascript" src="http://localhost/apppenggajianguru/assets/js/is/instascan.min.js"></script>
	<script type="text/javascript">
		let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
		scanner.addListener('scan', function (content) {
			console.log(content);
			document.getElementById('res_holder').value = content;
		});
		Instascan.Camera.getCameras().then(function (cameras) {
			if (cameras.length > 0) {
				scanner.start(cameras[0]);
			} else {
				console.error('No cameras found.');
			}
		}).catch(function (e) {
			console.error(e);
		});
	</script>
</body>
</html>