<script src="/templates/<?= TEMPLATE ?>/js/preview.js"></script>

<h1>Новая категория!</h1>
<form action="/admin/create-category" enctype="multipart/form-data" method="post">
	<div class="form-group">
		<label for="categoryName">Наименование</label>
		<input type="text" class="form-control" id="categoryName" name="categoryName" required>
	</div>

	<div class="form-group">
		<label for="categoryShortDescription">Краткое описание (макс 255 символов)</label>
		<input type="text" class="form-control" id="categoryShortDescription" name="categoryShortDescription" required>
	</div>

	<div class="form-group">
		<label for="categoryDescription">Описание</label>
		<textarea class="form-control" id="categoryDescription" name="categoryDescription" required></textarea>
	</div>

	<div class="form-group">
		<label for="categoryIcon">Иконка категории (размер установится в 200*150px)</label>
		<input type="file" class="form-control" id="categoryIcon" name="categoryIcon" accept="image/*"
		       onchange="previewImage('categoryIcon', 'iconPreview')" required>
		<img src="" alt="" id="iconPreview" class="preview">
	</div>

	<input type="submit" value="Создать Категорию">
</form>
