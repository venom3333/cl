	<!--Инфо о проекте-->
	<div class="col-md-10 product-model-sec">
		<h2><?= $project['name'] ?></h2>
		<section id="myCarousel" class="carousel slide">
			<!-- Indicators -->
			<ol class="carousel-indicators">
				<? $counter = 0; ?>
				<? foreach ( $project['images'] as $image ): ?>
					<li data-target="#myCarousel" data-slide-to="<?= $counter ++; ?>" <? if ( $counter == 1 )
						echo "class = \"active\"" ?>></li>
				<? endforeach; ?>
			</ol>

			<!-- Wrapper for Slides -->
			<div class="carousel-inner">
				<? $counter = 0; ?>
				<? foreach ( $project['images'] as $image ): ?>
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

		<!--/Инфо о проекте-->
		<p><?= $project['description'] ?></p>
	</div>