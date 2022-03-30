<html>
<head>
	<meta charset="utf-8">
	<title>Js tasks</title>
	<link rel="stylesheet" href="../../../css/style.css">
	<link rel="stylesheet" href="../style.css">
	<link rel="stylesheet" href="../../../css/slider.css">
</head>

<body>
	<div class="wrapper">
		<?
		include '../../../template/header.php';
		?>

		<div class="slider_wrapper">
			<div class="slider_view">
				<i class="prev"><i class="btn" data-action="go_prev"></i></i>
				<i class="next"><i class="btn" data-action="go_next"></i></i>
				<div class="slides"></div>

			</div>
			<div class="nav"></div>
			<div class="preview_slides"></div>
		</div>

		<div class="popup">
			<div class="popup_background"></div>
			<div class="slide_content">
		</div>

	</div>

	<script
			src="https://code.jquery.com/jquery-3.6.0.min.js"
			integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
			crossorigin="anonymous">
	</script>
	<script type="text/javascript" src="main.js"></script>
</body>
<!--<footer></footer>-->
</html>
