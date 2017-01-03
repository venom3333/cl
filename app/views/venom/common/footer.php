<div class="footer">
	<div class="footer-container">
		<div class="footer-grids">
			<div class="col-md-3 logo">
				<a href="/" class="vertical-center"><img src="/images/сustomlight-logo-w.svg" alt="Логотип"></a>
			</div>
			<div class="col-md-6 ftr-grid footer-categories">
				<div class="col-md-12">
					<a href="/" class="col-md-6"><div>Главная</div></a>
					<a href="#top" class="col-md-6"><div>Наверх</div></a>
					<h5>Категории:</h5>
					<? foreach ( $layoutEssentials['categories'] as $categoryName ): ?>
					<a
						href="/category/<?= $categoryName['id'] ?>" class="col-md-12"><div><?= $categoryName['name'] ?></div></a>
					<? endforeach; ?>
				</div>
			</div>
			<div class="col-md-3 ftr-grid contacts">
				<h3>Контaкты:</h3>
				<p>Телефон: 8(495)773-71-59</p>
				<p>Факс: 8(495)773-71-59</p>
				<p>Email: info@custom-light.ru</p>
				<p>Адрес: 141280, Московская область, г.Ивантеевка, Студенческий проезд, дом 12</p>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>