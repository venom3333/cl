<script src="/templates/<?= TEMPLATE ?>/js/preview.js"></script>

<!--Основная информация о проекте-->
<div class="projectEdit col-md-12 border">
	<form action="/admin/update-project/<?= $project['id'] ?>" enctype="multipart/form-data" method="post">
		<h1>Редактирование проекта (ID = <input type="text" id="projectId" name="projectId" style="width: 2em"
		                                         value="<?= $project['id'] ?>" readonly>)</h1>
		<h4>Редактирование основной мнформации:</h4>
		<div class="form-group">
			<label for="projectName">Наименование</label>
			<input type="text" class="form-control" id="projectName" name="projectName" value="<?= $project['name'] ?>"
			       required>
		</div>

		<div class="form-group">
			<label for="projectShortDescription">Краткое описание (макс 255 символов)</label>
			<input type="text" class="form-control" id="projectShortDescription" name="projectShortDescription"
			       value="<?= $project['short_description'] ?>" required>
		</div>

		<div class="form-group">
			<label for="projectDescription">Описание</label>
			<textarea class="form-control" id="projectDescription" name="projectDescription"
			          required><?= $project['description'] ?></textarea>
		</div>

		<div class="form-group">
			<label for="projectCurrentIcon">Текущая иконка</label>
			<input type="text" class="form-control" id="projectCurrentIcon" name="projectCurrentIcon"
			       value="<?= $project['icon'] ?>"
			       readonly>
		</div>
		<img src="<?= $project['icon'] ?>" alt="" id="projectCurrentIconPreview">


		<div class="form-group">
			<label for="projectIcon">Новая иконка категории (ЗАМЕНИТ ТЕКУЩУЮ, размер установится в 200*150px):</label>
			<input type="file" class="form-control" id="projectIcon" name="projectIcon" accept="image/*"
			       onchange="previewImage('projectIcon', 'iconPreview')">
			<img src="" alt="" id="iconPreview" class="preview">
		</div>

		<input type="submit" class="btn btn-success" value="Сохранить основную информацию">
	</form>
</div>
<!--/Основная информация о проекте-->

<!--Категории проекта-->
<div class="projectEdit col-md-12 border">
	<h4>Редактирование категорий:</h4>
	<form action="/admin/update-project-categories/<?= $project['id'] ?>" method="post">
		<? foreach ( $categories as $category ): ?>
			<div class="checkbox">
				<label><input type="checkbox" name="category<?= $category['id'] ?>"
				              value="<?= $category['id'] ?>" <? foreach ( $project['categories'] as $projectCategory ) {
						echo ( $projectCategory['id'] == $category['id'] ) ? "checked" : "";
					} ?>><?= $category['name'] ?>
				</label>
			</div>
		<? endforeach; ?>
		<input type="submit" class="btn btn-warning" value="Обновить категории">
	</form>
</div>
<!--/Категории проекта-->

<!--Информация об изображениях проекта-->
<!--Удаление изображений-->
<div class="projectEdit col-md-12 border">
	<h4>Удаление прикрепленных изображений:</h4>
	<? foreach ( $project['images'] as $image ): ?>
		<div class="col-md-3">
			<img class="col-md-12" src="<?= $image['image'] ?>" alt="">
			<form action="/admin/remove-project-image/<?= $image['id'] ?>/<?= $project['id'] ?>" method="post">
				<input type="submit" class="btn btn-danger" value="Удалить">
			</form>
		</div>
	<? endforeach; ?>
</div>
<!--/Удаление изображений-->

<!--Добавление изображений-->
<div class="projectEdit col-md-12 border">
	<h4>Добавление изображений:</h4>
	<form action="/admin/add-project-image/<?= $project['id'] ?>" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="projectImage">Новое изображение (размер установится в 1024*768px):</label>
			<input type="file" class="form-control" id="projectImage" name="projectImage" accept="image/*"
			       onchange="previewImage('projectImage', 'imagePreview')">
			<img src="" alt="" id="imagePreview" class="preview">
			<input type="submit" class="btn btn-primary" value="Добавить изображение">
		</div>
	</form>
</div>
<!--/Добавление изображений-->
<!--/Информация об изображениях проекта-->