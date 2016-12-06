<div class="footer">
	<div class="container footer-container">
		<div class="footer-grids">
			<div class="col-md-3 about-us">
				<h3>Custom Light</h3>
				<p>Maecenas nec auctor sem. Vivamus porttitor tincidunt elementum nisi a, euismod rhoncus urna. Curabitur scelerisque vulputate arcu eu pulvinar. Fusce vel neque diam</p>
			</div>
			<div class="col-md-3 ftr-grid">
				<h3>Категории</h3>
				<ul class="nav-bottom">
					<? foreach ( $categoryNames as $categoryName ): ?>
						<li><a href="/category/<?= $categoryName['id'] ?>"><?= $categoryName['name'] ?></a></li>
					<? endforeach; ?>
				</ul>
			</div>
			<div class="col-md-3 ftr-grid">
				<h3>Контaкты:</h3>
					<p>Телефон: 322-22-32</p>
					<p>Факс: 322-22-32</p>
					<p>Email: info@custom-light.ru</p>
			</div>
			<div class="col-md-3 ftr-grid">
				<form class="callback">
					<div class="form-group">
						<label for="inputName"></label>
						<input type="email" class="form-control" id="inputName" placeholder="Ваше имя">
					</div>
					<div class="form-group">
						<label for="inputPhoneNumber">Email address</label>
						<input type="text" class="form-control" id="inputPhoneNumber" placeholder="Ваш телефон">
					</div>
					<button type="button" class="btn btn-default">Перезвоните мне</button>
				</form>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
</div>