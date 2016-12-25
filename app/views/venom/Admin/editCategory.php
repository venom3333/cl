<script src="/templates/<?= TEMPLATE ?>/js/preview.js"></script>

<form action="/admin/update-category/<?= $category['id'] ?>" enctype="multipart/form-data" method="post">
	<h1>Редактирование категории (ID = <input type="text" id="categoryId" name="categoryId" style="width: 2em"
	                                          value="<?= $category['id'] ?>" readonly>)</h1>
	<div class="form-group">
		<label for="categoryName">Наименование</label>
		<input type="text" class="form-control" id="categoryName" name="categoryName" value="<?= $category['name'] ?>"
		       required>
	</div>

	<div class="form-group">
		<label for="categoryShortDescription">Краткое описание (макс 255 символов)</label>
		<input type="text" class="form-control" id="categoryShortDescription" name="categoryShortDescription"
		       value="<?= $category['short_description'] ?>" required>
	</div>

	<div class="form-group">
		<label for="categoryDescription">Описание</label>
		<textarea class="form-control" id="categoryDescription" name="categoryDescription"
		          required><?= $category['description'] ?></textarea>
	</div>

	<div class="form-group">
		<label for="categoryCurrentIcon">Текущая иконка</label>
		<input type="text" class="form-control" id="categoryCurrentIcon" name="categoryCurrentIcon" value="<?= $category['icon'] ?>"
		       readonly>
	</div>
	<img src="<?= $category['icon'] ?>" alt="" id="categoryCurrentIconPreview">


	<div class="form-group">
		<label for="categoryIcon">Новая иконка категории (ЗАМЕНИТ ТЕКУЩУЮ, размер установится в 200*150px):</label>
		<input type="file" class="form-control" id="categoryIcon" name="categoryIcon" accept="image/*"
		       onchange="previewImage('categoryIcon', 'iconPreview')">
		<img src="" alt="" id="iconPreview" class="preview">
	</div>

	<input type="submit" class="btn btn-success" value="Сохранить">
</form>
