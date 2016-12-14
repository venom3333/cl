<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover">
		<thead>
		<tr>
			<th>ID</th>
			<!--			<th>Иконка</th>-->
			<th>Имя</th>
			<th>Категории</th>
			<th>Варианты</th>
			<th>Создано</th>
			<th>Обновлено</th>
			<th>Статус</th>
			<th>Действия</th>
		</tr>
		</thead>
		<tbody>
		<? foreach ( $products as $product ): ?>
			<tr>
				<td><?= $product['id'] ?></td>
				<!--			<td><img src="--><? //= $product['icon'] ?><!--" alt=""></td>-->
				<td><?= $product['name'] ?></td>
				<td>
					<? if ( isset( $product['categories'] ) ): ?>
						<? foreach ( $product['categories'] as $category ): ?>
							<?= $category['name'] ?>
						<? endforeach; ?>
					<? endif; ?>

				</td>
				<td><? if ( isset( $product['specs'] ) )
						echo $product['specs'] ?></td>
				<td><?= $product['created'] ?></td>
				<td><?= $product['updated'] ?></td>
				<td>
					<?= $product['status'] ? "Виден" : "Не виден"; ?>
				</td>
				<td class="adminActions">
					<div class="glyphicon glyphicon-edit"></div>
					<a href="/admin/toggle-product-status/<?= $product['id'] ?>">
						<div class="glyphicon glyphicon-eye-close"></div>
					</a>
					<a href="/admin/remove-product/<?= $product['id'] ?>">
						<div class="glyphicon glyphicon-remove-circle"></div>
					</a>
				</td>
			</tr>
		<? endforeach ?>
		</tbody>
	</table>
</div>
<a href="/admin/new-product"><input type="button" value="Создать новый продукт"></a>