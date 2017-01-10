<h1>Редактирование страницы (ID = <input type="text" id="projectId" name="projectId" style="width: 2em"
                                         value="<?= $page['id'] ?>" readonly>)</h1>
<form action="/admin/update-page/<?= $page['id'] ?>" enctype="multipart/form-data" method="post">
	<div class="form-group">
		<label for="pageName">Наименование</label>
		<input type="text" class="form-control" id="pageName" name="pageName" value="<?= $page['name'] ?>" required>
	</div>

	<div class="form-group">
		<label for="pageShortDescription">Алиас</label>
		<input type="text" class="form-control" id="pageAlias" name="pageAlias" value="<?= $page['alias'] ?>" required>
	</div>

	<div class="form-group">
		<label for="pageContent">Содержание</label>
		<textarea class="form-control" id="pageContent" name="pageContent"><?= $page['content'] ?></textarea>
	</div>

	<input type="submit" class="btn btn-primary" value="Обновить Страницу">
</form>
