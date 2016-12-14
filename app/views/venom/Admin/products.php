<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover sort_table">
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
<!--			<td><img src="--><?//= $product['icon'] ?><!--" alt=""></td>-->
			<td><?= $product['name'] ?></td>
			<td>
				<? foreach ( $product['categories'] as $category ): ?>
					<?= $category['name'] ?>
				<? endforeach; ?>
			</td>
			<td><?= $product['specs'] ?></td>
			<td><?= $product['created'] ?></td>
			<td><?= $product['updated'] ?></td>
			<td><?= $product['status'] ?></td>
			<td>
				<div class="glyphicon glyphicon-edit"></div>
				<div class="glyphicon glyphicon-eye-close"></div>
				<div class="glyphicon glyphicon-remove-circle"></div>
			</td>
		</tr>
		<? endforeach ?>
		</tbody>
	</table>
</div>
<input type="button" value="Создать новый продукт">