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
							<th class="cart-cell">Световой поток (лм)</th>
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
		<? $counter = 0 ?>
		<? if ( isset( $_SESSION['cart']['products'] ) ): ?>
			<? foreach ( $_SESSION['cart']['products'] as $cartProduct ): ?>
				<? $counter ++; ?>
				<tr>
					<td>
						<?= $counter ?>
						<!--Для JS (невидимо)-->
						<span id="cart<?= $counter ?>productId" style="display: none"><?= $cartProduct->id ?></span>
						<!--/Для JS (невидимо)-->
					</td>
					<td>
						<a href="/product/<?= $cartProduct->id ?>">
							<img src="<?= $cartProduct->icon ?>" width="100px" alt="">
						</a>
					</td>
					<td id="cart<?= $counter ?>Name"><?= $cartProduct->name ?></td>
					<td>
						<div class="table-responsive">
							<table class="table table-bordered table-hover">
								<tbody>
								<tr>
									<td class="cart-cell"
									    id="cart<?= $counter ?>Diameter"><?= $cartProduct->diameter ?></td>
									<td class="cart-cell"
									    id="cart<?= $counter ?>Length"><?= $cartProduct->length ?></td>
									<td class="cart-cell" id="cart<?= $counter ?>Width"><?= $cartProduct->width ?></td>
									<td class="cart-cell"
									    id="cart<?= $counter ?>Height"><?= $cartProduct->height ?></td>
									<td class="cart-cell" id="cart<?= $counter ?>Power"><?= $cartProduct->power ?></td>
									<td class="cart-cell"
									    id="cart<?= $counter ?>LightOutput"><?= $cartProduct->light_output ?></td>
								</tr>
								</tbody>
							</table>
						</div>
					</td>
					<td class="cart-update-button cart<?= $counter ?>">
						<input type="number" id="cart<?= $counter ?>Quantity" value='<?= $cartProduct->quantity ?>'
						       min="1"
						       style="width: 3em;">
						<div class="glyphicon glyphicon-repeat"></div>
					</td>
					<td><?= $cartProduct->price ?></td>
					<td><?= $cartProduct->price * $cartProduct->quantity ?></td>
					<td class="cart-delete-button cart<?= $counter ?>">
						<div class="glyphicon glyphicon-remove-circle"></div>
					</td>
				</tr>
			<? endforeach; ?>
		<? endif; ?>
		</tbody>
		<!--Товары-->
	</table>

	<p class="cart-grand-total">Итого: <?= $_SESSION['cart']['grandQuantity'] ?> предметов
		на <?= $_SESSION['cart']['grandTotal'] ?> рублей.</p>

	<input type="button" class="cart-wipe-button" value="Очистить корзину!">

	<h3>Информация по заказу:</h3>
	<form class="checkout">
		<fieldset class="form-group">
			<legend class="h-line-reverse">Способ доставки:</legend>
			<div class="form-check">
				<label class="cartDelivery1">
					<input type="radio" class="form-check-input" name="cartDelivery" id="cartDelivery1" value="Самовывоз" checked>
					Самовывоз.
				</label>
			</div>
			<div class="form-check">
				<label class="cartDelivery2">
					<input type="radio" class="form-check-input" name="cartDelivery" id="cartDelivery2" value="Доставка">
					Доставка.
				</label>
			</div>
		</fieldset>
		<div class="form-group">
			<label for="cartName">ФИО</label>
			<input type="email" class="form-control" id="cartName" name="cartName" placeholder="Ваше имя">
		</div>
		<div class="form-group">
			<label for="cartPhoneNumber">Телефон</label>
			<input type="tel" class="form-control" id="cartPhoneNumber" placeholder="Ваш телефон">
		</div>
		<div class="form-group">
			<label for="cartEmail">E-mail</label>
			<input type="email" class="form-control" id="cartEmail" placeholder="Ваш e-mail">
		</div>
		<div class="form-group">
			<label for="cartAddress">Адрес доставки</label>
			<textarea class="form-control" id="cartAddress" placeholder="Адрес доставки"></textarea>
		</div>
		<div class="form-group">
			<label for="cartNotes">Примечание</label>
			<textarea class="form-control" id="cartNotes" placeholder="Примечания"></textarea>
		</div>
		<button type="button" class="btn btn-primary make-order-button">Заказать</button>
	</form>
</div>

<script src="/templates/<?= TEMPLATE ?>/js/cart.js"></script>
<script src="/templates/<?= TEMPLATE ?>/js/mail.js"></script>