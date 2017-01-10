<div class="footer">
	<div class="footer-container">
		<div class="footer-grids">
			<div class="col-md-3 logo">
				<a href="/" class="vertical-center"><img src="/images/сustomlight-logo-w.svg" alt="Логотип"></a>
			</div>
			<div class="col-md-4 ftr-grid footer-categories">
				<div class="col-md-12">
					<a href="/" class="col-md-6">
						<div>Главная</div>
					</a>
					<a href="#top" class="col-md-6">
						<div>Наверх</div>
					</a>
					<h5>Категории:</h5>
					<? foreach ( $layoutEssentials['categories'] as $categoryName ): ?>
						<a
							href="/category/<?= $categoryName['id'] ?>" class="col-md-12">
							<div><?= $categoryName['name'] ?></div>
						</a>
					<? endforeach; ?>
				</div>
			</div>
			<div class="col-md-2 ftr-grid contacts">
				<h3>Контaкты:</h3>
				<p>Телефон: 8(495)773-71-59</p>
				<p>Факс: 8(495)773-71-59</p>
				<p>Email: info@custom-light.ru</p>
				<p>Адрес: 141280, Московская область, г.Ивантеевка, Студенческий проезд, дом 12</p>
			</div>
			<div class="col-md-3 ftr-grid map">
									<script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?sid=2FrmHV8kBN1pZPuzbG5ZRza3lerBcGkL&amp;width=100%25&amp;height=250&amp;lang=ru_RU&amp;sourceType=constructor&amp;scroll=true"></script>
<!--					<a href="https://yandex.ru/maps/?um=constructor%3A2FrmHV8kBN1pZPuzbG5ZRza3lerBcGkL&amp;source=constructorStatic"-->
<!--					   target="_blank"><img-->
<!--							src="https://api-maps.yandex.ru/services/constructor/1.0/static/?sid=2FrmHV8kBN1pZPuzbG5ZRza3lerBcGkL&amp;width=350&amp;height=250&amp;lang=ru_RU&amp;sourceType=constructor"-->
<!--							alt="" style="border: 0;"/></a>-->
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>