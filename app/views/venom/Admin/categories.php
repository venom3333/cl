<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover">
		<thead>
		<tr>
			<th>ID</th>
			<!--			<th>Иконка</th>-->
			<th>Имя</th>
			<th>Краткое описание</th>
		</tr>
		</thead>
		<tbody>
		<? foreach ( $categories as $category ): ?>
			<tr>
				<td><?= $category['id'] ?></td>
				<!--				<td><img src="--><?//= $category['icon'] ?><!--" alt=""></td>-->
				<td><a href="/category/<?= $category['id'] ?>"><?= $category['name'] ?></a></td>
				<td><?= $category['short_description'] ?></td>
				<td class="adminActions">
					<div class="glyphicon glyphicon-edit"></div>
					<a href="/admin/remove-category/<?= $category['id'] ?>">
						<div class="glyphicon glyphicon-remove-circle"></div>
					</a>
				</td>
			</tr>
		<? endforeach ?>
		</tbody>
	</table>
</div>
<a href="/admin/new-category"><input type="button" value="Создать новую категорию"></a>