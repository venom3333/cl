<div class="container">
	<!--Левое меню-->
	<? include_once APP . "/views/" . TEMPLATE . "/common/nav_left.php" ?>
	<!--/Левое меню-->

	<!--Инфо о продукте-->
	<div class="col-md-10 product-model-sec">
		<h2><?= $product['name'] ?></h2>
		<section id="myCarousel" class="carousel slide">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<? $counter = 0; ?>
				<? foreach ( $product['images'] as $image ): ?>
					<li data-target="#myCarousel" data-slide-to="<?= $counter ++; ?>" <? if ( $counter == 1 )
						echo "class = \"active\"" ?>></li>
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

		<!--/Инфо о продукте-->
		<p><?= $product['description'] ?></p>

		<div class="table-responsive">
			<table class="table table-bordered table-striped table-hover">
				<thead>
				<tr>
					<th>Диаметр</th>
					<th>Длина</th>
					<th>Ширина</th>
					<th>Высота</th>
					<th>Мощность</th>
					<th>Сила света</th>
					<th>Цена</th>
				</tr>
				</thead>
				<tbody>
				<? foreach ( $product['specifications'] as $specification ): ?>
					<tr>
						<td><?= $specification['diameter'] ?></td>
						<td><?= $specification['length'] ?></td>
						<td><?= $specification['width'] ?></td>
						<td><?= $specification['height'] ?></td>
						<td><?= $specification['power'] ?></td>
						<td><?= $specification['light_output'] ?></td>
						<td><?= $specification['price'] ?></td>
					</tr>
				<? endforeach ?>
				</tbody>
			</table>
		</div>
	</div>