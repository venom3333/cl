<code><?php echo __FILE__ ?></code>
<h3><? echo $name ?></h3>
<h3><? echo $hi ?></h3>
<ul>
	<? foreach ( $categories as $category ): ?>
		<li><? echo $category['name'] ?></li>
	<? endforeach; ?>
</ul>
