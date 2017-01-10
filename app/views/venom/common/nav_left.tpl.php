<!--Левое меню-->
<div class="rsidebar span_1_of_left col-md-2">
	<section class="sky-form">
		<div class="product_right">
			<h4 class="m_2">Категории</h4>
			<div class="tab1">
				<? foreach ( $layoutEssentials['categories'] as $categoryName ): ?>
					<a href="/category/<?= $categoryName['id'] ?>"><p><?= $categoryName['name'] ?></p></a>
				<? endforeach; ?>
			</div>
	</section>
</div>
<!--/Левое меню-->