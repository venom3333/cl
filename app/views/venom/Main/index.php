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
					<h4><?= $category['name'] ?></h4>

					<!--					<div class="product-info simpleCart_shelfItem">-->
<!--						<div class="product-info-cust prt_name">-->
<!--							<p>--><?//= $category['short_description'] ?><!--</p>-->
<!--							<div class="clearfix"></div>-->
<!--						</div>-->
<!--					</div>-->
				</a>
			</div>
		<? endforeach; ?>
	</div>
</div>
<!--/Контент-->