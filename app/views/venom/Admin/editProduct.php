<script src="/templates/<?= TEMPLATE ?>/js/preview.js"></script>

<!--Основная информация о продукте-->
<div class="productEdit col-md-12 border">
	<form action="/admin/update-product/<?= $product['id'] ?>" enctype="multipart/form-data" method="post">
		<h1>Редактирование продукта (ID = <input type="text" id="productId" name="productId" style="width: 2em"
		                                         value="<?= $product['id'] ?>" readonly>)</h1>
		<h4>Редактирование основной мнформации:</h4>
		<div class="form-group">
			<label for="productName">Наименование</label>
			<input type="text" class="form-control" id="productName" name="productName" value="<?= $product['name'] ?>"
			       required>
		</div>

		<div class="form-group">
			<label for="productShortDescription">Краткое описание (макс 255 символов)</label>
			<input type="text" class="form-control" id="productShortDescription" name="productShortDescription"
			       value="<?= $product['short_description'] ?>" required>
		</div>

		<div class="form-group">
			<label for="productDescription">Описание</label>
			<textarea class="form-control" id="productDescription" name="productDescription"
			          required><?= $product['description'] ?></textarea>
		</div>

		<div class="form-group">
			<label for="productCurrentIcon">Текущая иконка</label>
			<input type="text" class="form-control" id="productCurrentIcon" name="productCurrentIcon"
			       value="<?= $product['icon'] ?>"
			       readonly>
		</div>
		<img src="<?= $product['icon'] ?>" alt="" id="productCurrentIconPreview">


		<div class="form-group">
			<label for="productIcon">Новая иконка категории (ЗАМЕНИТ ТЕКУЩУЮ, размер установится в 200*150px):</label>
			<input type="file" class="form-control" id="productIcon" name="productIcon" accept="image/*"
			       onchange="previewImage('productIcon', 'iconPreview')">
			<img src="" alt="" id="iconPreview" class="preview">
		</div>

		<input type="submit" class="btn btn-success" value="Сохранить основную информацию">
	</form>
</div>
<!--/Основная информация о продукте-->

<!--Категории продукта-->
<div class="productEdit col-md-12 border">
	<h4>Редактирование категорий:</h4>
	<form action="/admin/update-product-categories/<?= $product['id'] ?>" method="post">
		<? foreach ( $categories as $category ): ?>
			<div class="checkbox">
				<label><input type="checkbox" name="category<?= $category['id'] ?>"
				              value="<?= $category['id'] ?>" <? foreach ( $product['categories'] as $pcats ) {
						echo ( $pcats['id'] == $category['id'] ) ? "checked" : "";
					} ?>><?= $category['name'] ?>
				</label>
			</div>
		<? endforeach; ?>
		<input type="submit" class="btn btn-warning" value="Обновить категории">
	</form>
</div>
<!--/Категории продукта-->

<!--Информация об изображениях продукта-->
<!--Удаление изображений-->
<div class="productEdit col-md-12 border">
	<h4>Удаление прикрепленных изображений:</h4>
	<? foreach ( $product['images'] as $image ): ?>
		<div class="col-md-3">
			<img class="col-md-12" src="<?= $image['image'] ?>" alt="">
			<form action="/admin/remove-product-image/<?= $image['id'] ?>/<?= $product['id'] ?>" method="post">
				<input type="submit" class="btn btn-danger" value="Удалить">
			</form>
		</div>
	<? endforeach; ?>
</div>
<!--/Удаление изображений-->

<!--Добавление изображений-->
<div class="productEdit col-md-12 border">
	<h4>Добавление изображений:</h4>
	<form action="/admin/add-product-image/<?= $product['id'] ?>" method="post" enctype="multipart/form-data">
		<div class="form-group">
			<label for="productImage">Новое изображение (размер установится в 1024*768px):</label>
			<input type="file" class="form-control" id="productImage" name="productImage" accept="image/*"
			       onchange="previewImage('productImage', 'imagePreview')">
			<img src="" alt="" id="imagePreview" class="preview">
			<input type="submit" class="btn btn-primary" value="Добавить изображение">
		</div>
	</form>
</div>
<!--/Добавление изображений-->
<!--/Информация об изображениях продукта-->

<!--Информация о спецификациях продукта-->
<!--Удаление спецификаций-->
<div class="productEdit col-md-12 border">
	<h4>Удаление прикрепленных спецификаций:</h4>
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover sort_table">
			<thead>
			<tr>
				<th>ID</th>
				<th>Диаметр</th>
				<th>Длина</th>
				<th>Ширина</th>
				<th>Высота</th>
				<th>Мощность</th>
				<th>Световой поток (лм)</th>
				<th>Цена</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<? $i = 0; ?>
			<? foreach ( $product['specifications'] as $specification ): ?>
				<tr class="spec<?= $i ?>" id="spec<?= $i ?>">
					<td class="spec<?= $i ?>" id="spec<?= $i ?>Id"><?= $specification['id'] ?></td>
					<td class="spec<?= $i ?>" id="spec<?= $i ?>Diameter"><?= $specification['diameter'] ?></td>
					<td class="spec<?= $i ?>" id="spec<?= $i ?>Length"><?= $specification['length'] ?></td>
					<td class="spec<?= $i ?>" id="spec<?= $i ?>Width"><?= $specification['width'] ?></td>
					<td class="spec<?= $i ?>" id="spec<?= $i ?>Height"><?= $specification['height'] ?></td>
					<td class="spec<?= $i ?>" id="spec<?= $i ?>Power"><?= $specification['power'] ?></td>
					<td class="spec<?= $i ?>" id="spec<?= $i ?>LightOutput"><?= $specification['light_output'] ?></td>
					<td class="spec<?= $i ?>" id="spec<?= $i ?>Price"><?= $specification['price'] ?></td>
					<td>
						<form action="/admin/remove-product-specification/<?= $specification['id'] ?>/<?= $product['id'] ?>" method="post">
							<input type="submit" class="btn btn-danger" value="Удалить">
						</form>
					</td>
				</tr>
				<? $i ++ ?>
			<? endforeach ?>
			</tbody>
		</table>
	</div>
</div>
<!--/Удаление спецификаций-->

<!--Добавление спецификаций-->
<div class="productEdit col-md-12 border">
	<h4>Добавление спецификаций:</h4>
	<div class="table-responsive">
		<form action="/admin/add-product-specification/<?= $product['id'] ?>" method="post">
			<table class="table table-bordered table-striped table-hover sort_table">
				<thead>
				<tr>
					<th>Диаметр</th>
					<th>Длина</th>
					<th>Ширина</th>
					<th>Высота</th>
					<th>Мощность</th>
					<th>Световой поток (лм)</th>
					<th>Цена</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productDiameter"
							       name="diameter">
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productLength"
							       name="length">
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productWidth"
							       name="width">
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productHeight"
							       name="height">
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productPower"
							       name="power">
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productLightOutput"
							       name="lightOutput">
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productPrice"
							       name="price" required>
						</div>
					</td>
					<td>
						<input type="submit" class="btn btn-primary" value="Добавить">

					</td>
				</tr>
				</tbody>
			</table>
		</form>
	</div>
</div>
<!--/Добавление спецификаций-->
<!--/Информация о спецификациях продукта-->

