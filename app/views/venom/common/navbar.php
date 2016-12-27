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
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav test">
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



		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container-fluid -->
</nav>