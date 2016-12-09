<nav class="navbar" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse"
			        data-target="#bs-example-navbar-collapse-1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="/">Custom Light</a>
			<a class="navbar-brand" href="#callback">8(800)322-22-32</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li class="active"><a href="/page/about">О компании</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Каталог<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="#"><b>Категории:</b></a></li>
						<li class="divider"></li>
						<? foreach ( $categoryNames as $categoryName ): ?>
							<li><a href="/category/<?= $categoryName['id'] ?>"><?= $categoryName['name'] ?></a></li>
						<? endforeach; ?>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Реализованные проекты<b
							class="caret"></b></a>
					<ul class="dropdown-menu">
						<? foreach ( $projectNames as $projectName ): ?>
							<li><a href="/project/<?= $projectName['id'] ?>"><?= $projectName['name'] ?></a></li>
						<? endforeach; ?>
					</ul>
				</li>
				<li class="active"><a href="/page/designers">Архитекторам / Дизайнерам</a></li>
				<li class="active"><a href="/page/contacts">Контакты</a></li>
			</ul>

			<ul class="nav navbar-nav navbar-right">
<!--				<li>-->
<!--					<form action="" class="navbar-search pull-left">-->
<!--						<input type="text" placeholder="Search" class="search-query span2">-->
<!--					</form>-->
<!--				</li>-->
				<li><a href="/cart" class="glyphicon glyphicon-shopping-cart"> В корзине:<br>4 товара на 48 000 руб.</a></li>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container-fluid -->
</nav>