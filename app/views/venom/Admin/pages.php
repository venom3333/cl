<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover">
		<thead>
		<tr>
			<th>ID</th>
			<th>Имя</th>
			<th>Алиас</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<? foreach ( $pages as $page ): ?>
			<tr>
				<td><?= $page['id'] ?></td>
				<td><a href="/page/<?= $page['id'] ?>"><?= $page['name'] ?></a></td>
				<td><?= $page['alias'] ?></td>
				<td class="adminActions">
					<a href="/admin/edit-page/<?= $page['id'] ?>">
						<div class="glyphicon glyphicon-edit"></div>
					</a>
					<a href="#" onclick="confirmDelete('/admin/remove-page/<?= $page['id'] ?>')">
						<div class="glyphicon glyphicon-remove-circle"></div>
					</a>
				</td>
			</tr>
		<? endforeach ?>
		</tbody>
	</table>
</div>
<a href="/admin/new-page"><input type="button" value="Создать новую страницу"></a>