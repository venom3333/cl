<!--Инфо о продукте-->
<div class="col-md-10 product-model-sec">
	<h2 id="productName"><?= $product['name'] ?></h2>

	<!--	Не отображается (нужно для корзины)-->
	<div id="productIcon" style="display: none;"><?= $product['icon'] ?></div>
	<div id="productId" style="display: none;"><?= $product['id'] ?></div>
	<!--	/Не отображается (нужно для корзины)-->

	<!--Галерея-->
	<section id="myCarousel" class="carousel slide my-carousel">
		<!-- Indicators -->
		<ol class="carousel-indicators image-carousel-indicators">
			<? $counter = 0; ?>
			<? foreach ( $product['images'] as $image ): ?>
				<li data-target="#myCarousel"
				    data-slide-to="<?= $counter ++; ?>" <? if ( $counter == 1 ) {
					echo "class = \"myCarousel active\"";
				} else echo "class = \"myCarousel\"" ?>>
					<img src="<?= $image['image'] ?>" alt="">
				</li>
			<? endforeach; ?>
		</ol>
		<!-- Wrapper for Slides -->
		<div class="carousel-inner">
			<? $counter = 0; ?>
			<? foreach ( $product['images'] as $image ): ?>
				<div <? $counter ++;
				if ( $counter == 1 ) {
					echo "class = \"item active\"";
				} else echo "class = \"item\"" ?>>
					<!-- Set the first background image using inline CSS below. -->
					<div class="fill" style="background-image:url('<?= $image['image'] ?>');"></div>
					<div class="carousel-caption">
						<h2>Caption 1</h2>
					</div>
				</div>
			<? endforeach; ?>
		</div>

		<!-- Controls -->
		<a class="left carousel-control" href="#myCarousel" data-slide="prev">
			<span class="icon-prev"></span>
		</a>
		<a class="right carousel-control" href="#myCarousel" data-slide="next">
			<span class="icon-next"></span>
		</a>
	</section>
	<!--Галерея-->


	<p><?= $product['description'] ?></p>

	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover sort_table">
			<thead>
			<tr>
				<th>Диаметр</th>
				<th>Длина</th>
				<th>Ширина</th>
				<th>Высота</th>
				<th>Мощность</th>
				<th>Сила света</th>
				<th>Цена</th>
				<th>Кол-во</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<? $i = 0; ?>
			<? foreach ( $product['specifications'] as $specification ): ?>
				<tr class="spec<?= $i ?>" id="spec<?= $i ?>">
					<td class="spec<?= $i ?>" id="spec<?= $i ?>Diameter"><?= $specification['diameter'] ?></td>
					<td class="spec<?= $i ?>" id="spec<?= $i ?>Length"><?= $specification['length'] ?></td>
					<td class="spec<?= $i ?>" id="spec<?= $i ?>Width"><?= $specification['width'] ?></td>
					<td class="spec<?= $i ?>" id="spec<?= $i ?>Height"><?= $specification['height'] ?></td>
					<td class="spec<?= $i ?>" id="spec<?= $i ?>Power"><?= $specification['power'] ?></td>
					<td class="spec<?= $i ?>" id="spec<?= $i ?>LightOutput"><?= $specification['light_output'] ?></td>
					<td class="spec<?= $i ?>" id="spec<?= $i ?>Price"><?= $specification['price'] ?></td>
					<td>
						<input type="number" class="spec<?= $i ?>" id="spec<?= $i ?>Quantity" min="1" value="1" style="width: 3em;">
					</td>
					<td class="cart-button spec<?= $i ?>" id="spec<?= $i ?>CartButton">+
						<div class="glyphicon glyphicon-shopping-cart"></div>
					</td>
				</tr>
				<? $i ++ ?>
			<? endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<!--/Инфо о продукте-->
<script src="/templates/<?= TEMPLATE ?>/js/cart.js"></script>
<script src="/templates/<?= TEMPLATE ?>/js/sort_tables.js"></script>
<script>
	$(function () {
		// jQuery methods go here...
		$("table.sort_table").sort_table({
			"action": "init"
		});
	});
</script>