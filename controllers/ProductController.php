<?php
/**
 * Class ProductController контроллер продуктов
 */

// подключаем модели
require_once '../models/CategoryModel.php';
require_once '../models/ProductModel.php';

class ProductController {

	/**
	 * экшн поумолчанию (для коротких ЧПУ)
	 *
	 * @param Smarty $smarty шаблонизатор
	 * @param integer $productId ID продукта
	 */
	public static function indexAction( Smarty $smarty, $productId ) {
		self::showAction( $smarty, $productId);
	}

	/**
	 * выводит информацию о продукте
	 *
	 * @param Smarty $smarty шаблонизатор
	 * @param integer $productId ID продукта
	 */
	public static function showAction( Smarty $smarty, $productId ) {
		$categories = CategoryModel::getMainCats();
		$product = ProductModel::getProduct( $productId );

		$smarty->assign( 'pageTitle', 'Custom Light.  ' . $product['name'] );
		$smarty->assign( 'categories', $categories );
		$smarty->assign( 'product', $product );

		//d($product);

		Venom::loadTemplate( $smarty, 'product' );
	}

}