<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="/favicon.ico">

	<title><?= $title ?></title>

	<!-- Bootstrap core CSS -->
	<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="/templates/venom/css/main.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"
	        integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY"
	        crossorigin="anonymous"></script>

<!--	Общие функции JS-->
	<script src="/templates/<?= TEMPLATE ?>/js/general.js"></script>

</head>

<body id="top">
<header>
	<? include_once APP . "/views/" . TEMPLATE . "/common/header.php" ?>
</header>

<section class="content">
	<?= $content ?>
</section>

<footer>
	<? include_once APP . "/views/" . TEMPLATE . "/common/footer.php" ?>
</footer>

<? // d(\core\Db::$countSql,0);?>
<? // d(\core\Db::$queries,0);?>

<!-- Bootstrap core JavaScript
================================================== -->
<script src="/bootstrap/js/bootstrap.min.js"></script>

<!--Отправка почты-->
<script src="/templates/<?= TEMPLATE ?>/js/mail.js"></script>

<!-- Script to Activate the Carousel -->
<script>
	$('.carousel').carousel({
		interval: 5000 //changes the speed
	})
</script>
</body>
</html>