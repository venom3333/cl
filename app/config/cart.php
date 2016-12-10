<?php
/**
 *
 * Файл инициализации корзины
 *
 */
if ( ! isset( $_SESSION['cart']['grandQuantity'] ) || $_SESSION['cart']['grandQuantity'] < 0 ) {
	$_SESSION['cart']['grandQuantity'] = 0;
} else {
	$_SESSION['cart']['grandQuantity'] = 0;
	if ( isset( $_SESSION['cart']['products'] ) ) {
		foreach ( $_SESSION['cart']['products'] as $product ) {
			$_SESSION['cart']['grandQuantity'] += $product->quantity;
		}
	}
}

if ( ! isset( $_SESSION['cart']['grandTotal'] ) || $_SESSION['cart']['grandTotal'] < 0 ) {
	$_SESSION['cart']['grandTotal'] = 0;
} else {
	$_SESSION['cart']['grandTotal'] = 0;
	if ( isset( $_SESSION['cart']['products'] ) ) {
		foreach ( $_SESSION['cart']['products'] as $product ) {
			$_SESSION['cart']['grandTotal'] += $product->quantity * $product->price;
		}
	}
}