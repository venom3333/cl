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
			<ul class="nav navbar-nav">
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Каталог<b class="caret"></b></a>
					<ul class="dropdown-menu">
						<p><b>Категории:</b></p>
						<li class="divider"></li>
						<? foreach ( $layoutEssentials['categories'] as $categoryName ): ?>
							<li><a href="/category/<?= $categoryName['id'] ?>"><?= $categoryName['name'] ?></a></li>
						<? endforeach; ?>
					</ul>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">Реализованные проекты<b
							class="caret"></b></a>
					<ul class="dropdown-menu">
						<? foreach ( $layoutEssentials['projects'] as $projectName ): ?>
							<li><a href="/project/<?= $projectName['id'] ?>"><?= $projectName['name'] ?></a></li>
						<? endforeach; ?>
					</ul>
				</li>
				<? foreach ( $layoutEssentials['pages'] as $pageName ): ?>
					<li class="nav-a"><a href="/page/<?= $pageName['alias'] ?>"><?= $pageName['name'] ?></a></li>
				<? endforeach; ?>
			</ul>
		</div>
		<!-- /.navbar-collapse -->
	</div>
	<!-- /.container-fluid -->
</nav>