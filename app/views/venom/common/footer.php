<div class="footer">
	<div class="footer-container">
		<div class="footer-grids">
			<div class="col-md-3 logo">
				<a href="/"><img src="/images/сustomlight-logo-w.svg" alt="Логотип"></a>
			</div>
			<div class="col-md-3 ftr-grid footer-categories">
				<a href="/" class="col-md-6">Главная</a>
				<a href="#top" class="col-md-6">Наверх</a>
				<h3>Категории</h3>
					<? foreach ( $categoryNames as $categoryName ): ?>
						<div class="col-md-6"><a href="/category/<?= $categoryName['id'] ?>"><?= $categoryName['name'] ?></a></div>
					<? endforeach; ?>

			</div>
			<div class="col-md-3 ftr-grid contacts">
				<h3>Контaкты:</h3>
					<p>Телефон: 8(495)773-71-59</p>
					<p>Факс: 8(495)773-71-59</p>
					<p>Email: info@custom-light.ru</p>
			</div>
			<div class="col-md-3 ftr-grid">
				<form class="callback" id="callback">
					<div class="form-group">
						<label for="inputName"></label>
						<input type="email" class="form-control" id="inputName" placeholder="Ваше имя" required>
					</div>
					<div class="form-group">
						<label for="inputPhoneNumber"></label>
						<input type="text" class="form-control" id="inputPhoneNumber" placeholder="Ваш телефон" required>
					</div>
					<div class="form-group">
						<label for="inputText"></label>
						<textarea type="text" class="form-control" id="inputText" placeholder="Примечание"></textarea>
					</div>
					<button type="button" class="btn btn-default callback-mail-button">Заказать звонок</button>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>