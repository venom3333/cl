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
				<? foreach ( $product['images'] as $productImage ): ?>
					<li data-target="#myCarousel" data-slide-to="<?= $counter++; ?>" <? if($counter == 1) echo "class = \"active\""?>></li>
				<? endforeach; ?>
			</ol>

			<!-- Wrapper for Slides -->
			<div class="carousel-inner">

				<div class="item active">
					<!-- Set the first background image using inline CSS below. -->
					<div class="fill" style="background-image:url('/images/bnr.jpg');"></div>
					<div class="carousel-caption">
						<h2>Caption 1</h2>
					</div>
				</div>

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
	</div>