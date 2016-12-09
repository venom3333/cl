<?php
/**
 *
 * Файл инициализации корзины
 *
 */
if ( ! isset( $_SESSION['cart']['grandQuantity'] ) ) {
	$_SESSION['cart']['grandQuantity'] = 0;
}
if ( ! isset( $_SESSION['cart']['grandTotal'] ) ) {
	$_SESSION['cart']['grandTotal'] = 0;
}