<?php
/**
 * Class ProductController контроллер продуктов
 */
namespace app\controllers;
// подключаем модели
use app\models\Category;
use app\models\Product;
use app\models\Project;
use core\Venom;

class ProductController {

	/**
	 * экшн поумолчанию (для коротких ЧПУ)
	 *
	 * @param \Smarty $smarty шаблонизатор
	 * @param integer $productId ID продукта
	 */
	public static function indexAction( \Smarty $smarty, $productId ) {
		self::showAction( $smarty, $productId);
	}

	/**
	 * выводит информацию о продукте
	 *
	 * @param \Smarty $smarty шаблонизатор
	 * @param integer $productId ID продукта
	 */
	public static function showAction( \Smarty $smarty, $productId ) {
		//< Для навигационного меню
		$categories = Category::getMainCats();
		$projectNames = Project::getProjectNames();
		//>

		$product = Product::getProduct( $productId );

		$mainSection = "blocks/product_main.tpl";

		$smarty->assign( 'pageTitle', 'Custom Light.  ' . $product['name'] );
		$smarty->assign( 'categories', $categories );
		$smarty->assign( 'projectNames', $projectNames );
		$smarty->assign( 'product', $product );
		$smarty->assign( 'mainSection', $mainSection );

		Venom::loadTemplate( $smarty, 'general' );
	}

}