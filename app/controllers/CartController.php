<?php
/**
 * Created by PhpStorm.
 * User: vovan
 * Date: 08.12.2016
 * Time: 16:16
 */

namespace app\controllers;


use app\models\Category;
use app\models\Project;

class CartController extends AppController {

	public $layout = 'main';

	/**
	 *  Вывод основной страницы корзины
	 */
	public function indexAction() {
		//< для меню и левой навигации
		$categoryModel = new Category;
		$projectModel  = new Project;
		$categoryNames = $categoryModel->findAllNames();
		$projectNames  = $projectModel->findAllNames();
		//> для меню и левой навигации

		$this->view = 'cart';

		$title = "Custom Light. Корзина. Оформление заказа.";
		$this->set( compact( 'title', 'categoryNames', 'projectNames' ) );

	}

	/**
	 *  Добавляет продукт в корзину и обновляет виджет корзины
	 */
	public function addAction() {
		$this->layout = false;

		$data = json_decode( $_POST['data'] );

		$cartItemId = $data->id .
		              $data->diameter .
		              $data->length .
		              $data->width .
		              $data->height .
		              $data->power .
		              $data->light_output;

		if ( isset( $_SESSION['cart']['products'][ $cartItemId ] ) ) {
			$_SESSION['cart']['products'][ $cartItemId ]->quantity += $data->quantity;
		} else {
			$_SESSION['cart']['products'][ $cartItemId ] = $data;
		}

		include APP . "/config/cart.php"; // вычисление кол-ва и общей суммы

		$content = APP . "/views/" . TEMPLATE . "/common/carticon.php";
		include $content; // обновляем виджет
	}

	/**
	 *  Очищает всю корзину
	 */
	public function wipeAction() {
		$this->layout                 = false;
		$_SESSION['cart']['products'] = array();

		include APP . "/config/cart.php"; // вычисление кол-ва и общей суммы

		$content = APP . "/views/" . TEMPLATE . "/Cart/cart.php";
		include $content; // обновляем вид корзины
	}


	/**
	 *  Удаляет продукт из корзины
	 *
	 * @param integer $cartItemId ID продукта в таблице корзины
	 */
	public function deleteAction( $cartItemId ) {

		$this->layout = false;

		if ( isset( $_SESSION['cart']['products'][ $cartItemId ] ) ) {
			unset( $_SESSION['cart']['products'][ $cartItemId ] );
		}

		include APP . "/config/cart.php"; // вычисление кол-ва и общей суммы

		$content = APP . "/views/" . TEMPLATE . "/Cart/cart.php";
		include $content; // обновляем вид корзины
	}

	/**
	 *  Обновляет виджет корзины
	 */
	public function updateWidgetAction() {
		$this->layout = false;

		$content = APP . "/views/" . TEMPLATE . "/common/carticon.php";
		include $content; // обновляем виджет
	}

	/**
	 *  Обновляет количество продукта в корзине
	 *
	 * @param int $cartItemId ID продукта в таблице корзины
	 * @param int $quantity количество продукта в таблице корзины
	 */
	public function updateQuantityAction( $cartItemId, $quantity ) {
		$this->layout = false;

		if ( isset( $_SESSION['cart']['products'][ $cartItemId ] ) ) {
			$_SESSION['cart']['products'][ $cartItemId ]->quantity = $quantity;
		}
		if ( $_SESSION['cart']['products'][ $cartItemId ]->quantity == 0 ) {
			unset( $_SESSION['cart']['products'][ $cartItemId ] );
		}

		include APP . "/config/cart.php"; // вычисление кол-ва и общей суммы

		$content = APP . "/views/" . TEMPLATE . "/Cart/cart.php";
		include $content; // обновляем виджет
	}

}
