<h1>Корзина.</h1>
<h2>Оформление заказа.</h2>

<div class="table-responsive">
	<table class="table table-bordered table-hover">
		<thead>
		<tr>
			<th class="cart-table cart-id"></th>
			<th class="cart-table cart-photo"></th>
			<th class="cart-table cart-name">Наименование</th>
			<th class="cart-table cart-specification">
				<div class="table-responsive">
					<table class="table table-bordered table-hover cart-inner-thead">
						<thead>
						<tr>
							<th class="cart-cell">Диаметр</th>
							<th class="cart-cell">Длина</th>
							<th class="cart-cell">Ширина</th>
							<th class="cart-cell">Высота</th>
							<th class="cart-cell">Мощность</th>
							<th class="cart-cell">Сила света</th>
						</tr>
						</thead>
					</table>
				</div>
			</th>
			<th class="cart-table cart-qnt">Кол-во</th>
			<th class="cart-table cart-price">Цена</th>
			<th class="cart-table cart-total">Стоимость</th>
			<th class="cart-table cart-delete"></th>
		</tr>
		</thead>

		<!--Товары-->
		<tbody>
		<tr>
			<td>1.</td>
			<td>Photo</td>
			<td>Наименование продукта 1</td>
			<td>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<tbody>
						<tr>
							<td class="cart-cell">200</td>
							<td class="cart-cell"></td>
							<td class="cart-cell"></td>
							<td class="cart-cell">150</td>
							<td class="cart-cell">55</td>
							<td class="cart-cell">4500</td>
						</tr>
						</tbody>
					</table>
				</div>
			</td>
			<td><input type="number" value='12' min="0" style="width: 3em;"></td>
			<td>1 000</td>
			<td>12 000</td>
			<td>Уд.</td>
		</tr>
		<tr>
			<td>2.</td>
			<td>Photo</td>
			<td>Наименование продукта 2</td>
			<td>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<tbody>
						<tr>
							<td class="cart-cell">200</td>
							<td class="cart-cell"></td>
							<td class="cart-cell"></td>
							<td class="cart-cell">150</td>
							<td class="cart-cell">55</td>
							<td class="cart-cell">4500</td>
						</tr>
						</tbody>
					</table>
				</div>
			</td>
			<td><input type="number" value='12' min="0" style="width: 3em;"></td>
			<td>1 000</td>
			<td>12 000</td>
			<td>Уд.</td>
		</tr>
		<tr>
			<td>3.</td>
			<td>Photo</td>
			<td>Наименование продукта 2</td>
			<td>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<tbody>
						<tr>
							<td class="cart-cell">200</td>
							<td class="cart-cell"></td>
							<td class="cart-cell"></td>
							<td class="cart-cell">150</td>
							<td class="cart-cell">55</td>
							<td class="cart-cell">4500</td>
						</tr>
						</tbody>
					</table>
				</div>
			</td>
			<td><input type="number" value='12' min="0" style="width: 3em;"></td>
			<td>1 000</td>
			<td>12 000</td>
			<td>Уд.</td>
		</tr>
		<tr>
			<td>4.</td>
			<td>Photo</td>
			<td>Наименование продукта 3</td>
			<td>
				<div class="table-responsive">
					<table class="table table-bordered table-hover">
						<tbody>
						<tr>
							<td class="cart-cell">200</td>
							<td class="cart-cell"></td>
							<td class="cart-cell"></td>
							<td class="cart-cell">150</td>
							<td class="cart-cell">55</td>
							<td class="cart-cell">4500</td>
						</tr>
						</tbody>
					</table>
				</div>
			</td>
			<td><input type="number" value='12' min="0" style="width: 3em;"></td>
			<td>1 000</td>
			<td>12 000</td>
			<td>Уд.</td>
		</tr>
		</tbody>
		<!--Товары-->
	</table>

	<p class="cart-grand-total">Итого: 48 000 рублей.</p>

	<h3>Информация по заказу:</h3>
	<form class="checkout">
		<div class="form-group">
			<h4>Способ доставки:</h4>
			<div class="form-group form-inline">
				<input type="radio" class="form-control" id="cartDelivery1" name="cartDelivery" value="1">
				<label for="cartDelivery1">Самовывоз.</label>
			</div>
			<div class="form-group form-inline">
				<input type="radio" class="form-control" id="cartDelivery2" name="cartDelivery" value="2">
				<label for="cartDelivery2">Курьером.</label>
			</div>
		</div>
		<div class="form-group form-inline">
			<label for="cartName">ФИО</label>
			<input type="email" class="form-control" id="cartName" name="cartName" placeholder="Ваше имя">
		</div>
		<div class="form-group form-inline">
			<label for="cartPhoneNumber">Телефон</label>
			<input type="tel" class="form-control" id="cartPhoneNumber" placeholder="Ваш телефон">
		</div>
		<div class="form-group form-inline">
			<label for="cartEmail">E-mail</label>
			<input type="email" class="form-control" id="cartEmail" placeholder="Ваш e-mail">
		</div>
		<div class="form-group form-inline">
			<label for="cartAddress">Адрес доставки</label>
			<textarea class="form-control" id="cartAddress" placeholder="Адрес доставки"></textarea>
		</div>
		<div class="form-group form-inline">
			<label for="cartNotes">Примечание</label>
			<textarea class="form-control" id="cartNotes" placeholder="Примечания"></textarea>
		</div>
		<button type="button" class="btn btn-default">Заказать</button>
	</form>
</div>