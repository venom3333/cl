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
		//< Для навигационного меню
		$categories = CategoryModel::getMainCats();
		$projectNames = ProjectModel::getProjectNames();
		//>

		$product = ProductModel::getProduct( $productId );

		$mainSection = "blocks/product_main.tpl";

		$smarty->assign( 'pageTitle', 'Custom Light.  ' . $product['name'] );
		$smarty->assign( 'categories', $categories );
		$smarty->assign( 'projectNames', $projectNames );
		$smarty->assign( 'product', $product );
		$smarty->assign( 'mainSection', $mainSection );


		//d($product);

		Venom::loadTemplate( $smarty, 'general' );
	}

}