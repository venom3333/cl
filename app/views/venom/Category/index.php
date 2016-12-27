<!--Список товаров категории-->
<div class="col-md-10 product-model-sec">
	<h2><?= $categoryHeader['name'] ?></h2>
	<div class="h-line-reverse clearfix"></div>
	<p><?= $categoryHeader['short_description'] ?></p>
	<div class="h-line-reverse clearfix"></div>
	<p><?= $categoryHeader['description'] ?></p>
	<div class="h-line-reverse clearfix"></div>
	<? foreach ( $products as $product ): ?>
		<div class="product-grid col-md-3">
			<a href="/product/<?= $product['id'] ?>">
				<div class="product-img">
					<img src="<?= $product['icon'] ?>" class="img-responsive" alt="">
					<div class="b-wrapper">
					</div>
				</div>
				<h4><?= $product['name'] ?></h4>

				<!--				<div class="product-info simpleCart_shelfItem">-->
<!--					<div class="product-info-cust prt_name">-->
<!--						<p>--><?//= $product['short_description'] ?><!--</p>-->
<!--						<div class="clearfix"></div>-->
<!--					</div>-->
<!--				</div>-->
			</a>
		</div>
	<? endforeach; ?>
</div>
<!--/Список товаров категории-->

<!--Список относящихся к категории проектов-->
<div class="col-md-12 product-model-sec">
	<h3>Проекты с данной категорией</h3>
	<div class="h-line-reverse clearfix"></div>
	<? foreach ( $projects as $project ): ?>
		<div class="product-grid col-md-3">
			<a href="/project/<?= $project['id'] ?>">
				<div class="product-img">
					<img src="<?= $project['icon'] ?>" class="img-responsive" alt="">
				</div>
				<h4><?= $project['name'] ?></h4>

				<!--				<div class="product-info simpleCart_shelfItem">-->
<!--					<div class="product-info-cust prt_name">-->
<!--						<p>--><?//= $project['short_description'] ?><!--</p>-->
<!--						<div class="clearfix"></div>-->
<!--					</div>-->
<!--				</div>-->
			</a>
		</div>
	<? endforeach; ?>
	<!--/Список относящихся к категории проектов-->
</div>