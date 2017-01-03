<h1>Новая страница!</h1>
<form action="/admin/create-page" enctype="multipart/form-data" method="post">
	<div class="form-group">
		<label for="pageName">Наименование</label>
		<input type="text" class="form-control" id="pageName" name="pageName" required>
	</div>

	<div class="form-group">
		<label for="pageShortDescription">Алиас</label>
		<input type="text" class="form-control" id="pageAlias" name="pageAlias" required>
	</div>

	<div class="form-group">
		<label for="pageContent">Содержание</label>
		<textarea class="form-control" id="pageContent" name="pageContent"></textarea>
	</div>

	<input type="submit" class="btn btn-primary" value="Создать Страницу">
</form>
