<script src="/templates/<?= TEMPLATE ?>/js/preview.js"></script>

<h1>Новый проект!</h1>
<form action="/admin/create-project" enctype="multipart/form-data" method="post">
	<div class="form-group">
		<label for="projectName">Наименование</label>
		<input type="text" class="form-control" id="projectName" name="projectName" required>
	</div>

	<div class="form-group">
		<label for="projectShortDescription">Краткое описание (макс 255 символов)</label>
		<input type="text" class="form-control" id="projectShortDescription" name="projectShortDescription" required>
	</div>

	<div class="form-group">
		<label for="projectDescription">Описание</label>
		<textarea class="form-control" id="projectDescription" name="projectDescription" required></textarea>
	</div>

	<div class="form-group">
		<label for="projectIcon">Иконка проекта (размер установится в 200*150px)</label>
		<input type="file" class="form-control" id="projectIcon" name="projectIcon" accept="image/*"
		       onchange="previewImage('projectIcon', 'iconPreview')" required>
		<img src="" alt="" id="iconPreview" class="preview">
	</div>

	<? foreach ( $categories as $category ): ?>
		<div class="checkbox">
			<label><input type="checkbox" name="category<?= $category['id'] ?>"
			              value="<?= $category['id'] ?>"><?= $category['name'] ?>
			</label>
		</div>
	<? endforeach; ?>

	<h4>Добавьте от 2х до 5ти изображений (размер установится в 1024*768px):</h4>
	<div class="row">
		<? for ( $i = 1; $i <= 5; $i ++ ): ?>
			<div class="form-group col-md-2">
				<label for="projectImage<?= $i ?>">Изображение <?= $i ?></label>
				<input type="file" class="form-control" id="projectImage<?= $i ?>" name="projectImage<?= $i ?>"
				       accept="image/*" onchange="previewImage('projectImage<?= $i ?>','projectPreview<?= $i ?>')">
				<img src="" alt="" id="projectPreview<?= $i ?>" class="preview">
			</div>
		<? endfor; ?>
	</div>

	<input type="submit" value="Создать Проект">
</form>
