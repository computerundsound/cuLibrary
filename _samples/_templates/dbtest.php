<?php
/** @var \curlibrary\CuMiniTemplateEngine $this */
$this;
?>
<!DOCTYPE html>
<html lang="de">
	<head>
		<meta charset="utf-8">
		<title>Startseite</title>

		<!-- Latest compiled and minified CSS & JS -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.css" rel="stylesheet">

		<script src="https://code.jquery.com/jquery-2.1.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

	</head>
	<body>

		<div class="container">

			<div class="row">

				<div class="col-sm-12">

					<h1><?php $this->showValue('Title') ?></h1>

					<p><?php $this->showValue('message');?></p>

					<p>&nbsp;</p>

					<table class="table">
						<?php
						$dataArray = $this->getValue('resultArray');

						foreach($dataArray as $key => $row):

							?>
							<tr>
								<?php foreach($row as $value): ?>
									<td><?php echo $value; ?></td>
								<?php endforeach; ?>
							</tr>

							<?php
						endforeach;
						?>
					</table>

				</div>

			</div>


		</div>

	</body>
</html>