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

	<title>Custom Light. <?= $title ?></title>

	<!-- Bootstrap core CSS -->
	<link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom styles for this template -->
	<link href="/templates/venom/css/main.css" rel="stylesheet">
	<link href="/templates/venom/css/admin.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"
	        integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY"
	        crossorigin="anonymous"></script>

	<!--	Прикручиваем редактор для полей <textarea>-->
	<script src="/templates/venom/js/tinymce/tinymce.min.js"></script>
	<script src="/templates/venom/js/tinymce_init.js"></script>

	<!--	Общие функции JS-->
	<script src="/templates/<?= TEMPLATE ?>/js/general.js"></script>

</head>

<body id="top">
<header>
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="/">Custom Light</a>
			</div>
			<div class="adminTitle"><?= $title ?><br>
				<? if ( isset ( $_SESSION ['authAdmin'] ) && $_SESSION ['authAdmin'] === true ) : ?>
					Вы - Админ!
					<form action="/admin/exit-auth" method="post">
						<input type="submit" class="btn btn-primary" value="Выйти">
					</form>
				<? else: ?>
					<form action="/admin" class="adminPass" method="post">
						<label for="authAdmin"></label><input type="password" name="authAdmin"
						                                      placeholder="Скажи пароль..."
						                                      id="authAdmin">
					</form>
				<? endif; ?>
			</div>
		</div>
		<!-- /.container-fluid -->
	</nav>
</header>

<div>
	<section class="adminMenu col-md-2">
		<ul>
			<li><a href="/admin"><h4>Админка. Главная.</h4></a></li>
		</ul>
		<ul><p>Работа со страницами</p>
			<a href="/admin/pages">
				<li>Страницы</li>
			</a>
		</ul>
		<ul><p>Работа с базой данных</p>
			<a href="/admin/products">
				<li>Продукты</li>
			</a>
			<a href="/admin/projects">
				<li>Проекты</li>
			</a>
			<a href="/admin/categories">
				<li>Категории</li>
			</a>
		</ul>
	</section>

	<section class="content col-md-10">
		<?= $content ?>
	</section>
</div>

<footer>

</footer>

<? // d( \core\Db::$countSql, 0 ); ?>
<? // d( \core\Db::$queries, 0 ); ?>
<!-- Bootstrap core JavaScript
================================================== -->
<script src="/bootstrap/js/bootstrap.min.js"></script>

<!--защита от случайного удаления-->
<script src="/templates/venom/js/confirmDelete.js"></script>
<!--/защита от случайного удаления-->

</body>
</html>