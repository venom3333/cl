<code><?= __FILE__ ?></code>

<? foreach ( $categories as $category ): ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title"><?= $category['id'] ?> <?= $category['name'] ?></h3>
		</div>
		<div class="panel-body">
			<div><img src="<?= $category['icon'] ?>" alt=""></div>
			<div><?= $category['short_description'] ?></div>
			<div><?= $category['description'] ?></div>
		</div>
	</div>
<? endforeach; ?>