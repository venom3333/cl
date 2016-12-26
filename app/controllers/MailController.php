<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 26.12.2016
 * Time: 10:27
 */

namespace app\controllers;

use app\models\Mail;

class MailController extends AppController {
	/**
	 * Отправляет запрос на обратный зворнок на определенные e-mail
	 */
	public function callbackAction() {

		$data      = get_object_vars( json_decode( $_POST['data'] ) );
		$mailModel = new Mail;
		$mailModel->sendArrayToDefaultMail( 'Заявка на звонок', $data );
		exit;
	}

	/**
	 * Отправляет информацию о заказе на определенные e-mail
	 */
	public function makeOrderAction() {

		$customerInfo        = get_object_vars( json_decode( $_POST['data'] ) );
		$customerInfo2String = '';
		foreach ( $customerInfo as $key => $value ) {
			$customerInfo2String .= "\r\n$key: $value";
		}

		$data = $_SESSION['cart'];

		$order ['customerInfo'] = $customerInfo2String;
		$order['grandTotal']    = $_SESSION['cart']['grandTotal'];
		$order['grandQuantity'] = $_SESSION['cart']['grandQuantity'];
		foreach ( $data['products'] as &$product ) {
			$product        = get_object_vars( $product );
			$product2string = "";
			foreach ( $product as $key => $value ) {
				$product2string .= "\r\n$key: $value";
			}
			$product = $product2string;

			$order['products'][] = $product;
		}
		$order['products'] = implode( "\r\n", $order['products'] );

		$mailModel = new Mail;
		$mailModel->sendArrayToDefaultMail( 'ЗАКАЗ!', $order );
		exit;
	}
}