<!--Хлебные крошки-->
<ol class="breadcrumb">
	<li><a href="/">Категории</a></li>
	<? if ( ! isset( $categoryHeader['name'] ) ): ?>
		<? if ( isset( $product['name'] ) ): ?>
			<li class="active"><?= $product['name'] ?></li>
		<? endif; ?>
		<? if ( isset( $project['name'] ) ): ?>
			<li class="active"><?= $project['name'] ?></li>
		<? endif; ?>
	<? else: ?>
		<li class="active"><?= $categoryHeader['name'] ?></li>
	<? endif; ?>
</ol>