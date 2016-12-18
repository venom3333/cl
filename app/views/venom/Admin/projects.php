<div class="table-responsive">
	<table class="table table-bordered table-striped table-hover">
		<thead>
		<tr>
			<th>ID</th>
<!--			<th>Иконка</th>-->
			<th>Имя</th>
			<th>Категории</th>
			<th>Краткое описание</th>
		</tr>
		</thead>
		<tbody>
		<? foreach ( $projects as $project ): ?>
			<tr>
				<td><?= $project['id'] ?></td>
<!--				<td><img src="--><?//= $project['icon'] ?><!--" alt=""></td>-->
				<td><a href="/project/<?= $project['id'] ?>"><?= $project['name'] ?></a></td>
				<td>
					<? if ( isset( $project['categories'] ) ): ?>
						<? foreach ( $project['categories'] as $category ): ?>
							<?= $category['name'] ?>
						<? endforeach; ?>
					<? endif; ?>

				</td>
				<td><?= $project['short_description'] ?></td>
				<td class="adminActions">
					<div class="glyphicon glyphicon-edit"></div>
					<a href="/admin/remove-project/<?= $project['id'] ?>">
						<div class="glyphicon glyphicon-remove-circle"></div>
					</a>
				</td>
			</tr>
		<? endforeach ?>
		</tbody>
	</table>
</div>
<a href="/admin/new-project"><input type="button" value="Создать новый проект"></a>