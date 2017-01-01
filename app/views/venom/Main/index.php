<!-- Слайдер -->
<? include_once APP . "/views/" . TEMPLATE . "/common/slider.php" ?>
<!-- /Слайдер -->

<!--Контент-->
<div class="container">
	<div class="col-md-12 product-model-sec">
		<? foreach ( $categories as $category ): ?>
			<div class="product-grid col-lg-3 col-md-4 col-sm-6">
				<a href="/category/<?= $category['id'] ?>">
					<div class="product-img b-link-stripe b-animate-go  thickbox">
						<img src="<?= $category['icon'] ?>" class="img-responsive" alt="">
					</div>
					<h5><?= $category['name'] ?></h5>

					<!--					<div class="product-info simpleCart_shelfItem">-->
					<!--						<div class="product-info-cust prt_name">-->
					<!--							<p>--><? //= $category['short_description'] ?><!--</p>-->
					<!--							<div class="clearfix"></div>-->
					<!--						</div>-->
					<!--					</div>-->
				</a>
			</div>
		<? endforeach; ?>
	</div>
</div>
<div class="about-main col-md-8 col-md-offset-2">
	<h3>О компании:</h3>
	<p>
		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, blanditiis consequatur
		corporis eligendi esse exercitationem iusto libero necessitatibus nemo obcaecati perferendis placeat quam
		rerum
		similique soluta sunt temporibus veritatis vitae.
		Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, blanditiis consequatur corporis
		eligendi esse
		exercitationem iusto libero necessitatibus nemo obcaecati perferendis placeat quam rerum similique soluta
		sunt
		temporibus veritatis vitae.</p>
	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, blanditiis consequatur corporis
		eligendi
		esse exercitationem iusto libero necessitatibus nemo obcaecati perferendis placeat quam rerum similique
		soluta
		sunt temporibus veritatis vitae.</p>
</div>
<div class="clearfix"></div>
<!--/Контент-->