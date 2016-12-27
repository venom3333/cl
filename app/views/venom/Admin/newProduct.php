<script src="/templates/<?= TEMPLATE ?>/js/preview.js"></script>

<h1>Новый продукт!</h1>
<form action="/admin/create-product" enctype="multipart/form-data" method="post" novalidate>
	<div class="form-group">
		<label for="productName">Наименование</label>
		<input type="text" class="form-control" id="productName" name="productName" required>
	</div>

	<div class="form-group">
		<label for="productStatus">Статус видимости (1 - видимый, 0 - невидимый)</label>
		<input type="number" class="form-control" id="productStatus" name="productStatus" value="1" min="0" max="1"
		       required>
	</div>

	<div class="form-group">
		<label for="productShortDescription">Краткое описание (макс 255 символов)</label>
		<input type="text" class="form-control" id="productShortDescription" name="productShortDescription" required>
	</div>

	<div class="form-group">
		<label for="productDescription">Описание</label>
		<textarea class="form-control" id="productDescription" name="productDescription" required></textarea>
	</div>

	<div class="form-group">
		<label for="productIcon">Иконка продукта (уменьшится до 200*150)</label>
		<input type="file" class="form-control" id="productIcon" name="productIcon" accept="image/*"
		       onchange="previewImage('productIcon', 'iconPreview')" required>
		<img src="" alt="" id="iconPreview" class="preview">
	</div>

	<? foreach ( $categories as $category ): ?>
		<div class="checkbox">
			<label><input type="checkbox" name="category<?= $category['id'] ?>"
			              value="<?= $category['id'] ?>"><?= $category['name'] ?>
			</label>
		</div>
	<? endforeach; ?>

	<h4>Добавьте от 2х до 5ти изображений (уменьшится до 1024*768):</h4>
	<div class="row">
		<? for ( $i = 1; $i <= 5; $i ++ ): ?>
			<div class="form-group col-md-2">
				<label for="productImage<?= $i ?>">Изображение <?= $i ?></label>
				<input type="file" class="form-control" id="productImage<?= $i ?>" name="productImage<?= $i ?>"
				       accept="image/*" onchange="previewImage('productImage<?= $i ?>','productPreview<?= $i ?>')">
				<img src="" alt="" id="productPreview<?= $i ?>" class="preview">
			</div>
		<? endfor; ?>
	</div>


	<h4>Варианты:</h4>
	<div class="table-responsive">
		<table class="table table-bordered table-striped table-hover">
			<thead>
			<tr>
				<th>Диаметр</th>
				<th>Длина</th>
				<th>Ширина</th>
				<th>Высота</th>
				<th>Мощность</th>
				<th>Cветовой поток</th>
				<th>Цена</th>
			</tr>
			</thead>
			<tbody>
			<? for ( $i = 1; $i <= 5; $i ++ ): ?>
				<tr>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productDiameter<?= $i ?>"
							       name="productDiameter<?= $i ?>">
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productLength<?= $i ?>"
							       name="productLength<?= $i ?>">
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productWidth<?= $i ?>"
							       name="productWidth<?= $i ?>">
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productHeight<?= $i ?>"
							       name="productHeight<?= $i ?>">
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productPower<?= $i ?>"
							       name="productPower<?= $i ?>">
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productLightOutput<?= $i ?>"
							       name="productLightOutput<?= $i ?>">
						</div>
					</td>
					<td>
						<div class="form-group">
							<input type="number" class="form-control" id="productPrice<?= $i ?>"
							       name="productPrice<?= $i ?>">
						</div>
					</td>
				</tr>
			<? endfor; ?>
			</tbody>
		</table>
	</div>
	<input type="submit" class="btn btn-primary" value="Создать Продукт">
</form>
