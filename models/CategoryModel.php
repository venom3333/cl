<?php
/**
 * Модель для таблицы категорий (category)
 */

/**
 * Получить дочерние категории для категории $catId
 *
 * @param integer $catId ID категории
 *
 * @return array массив дочерних категорий
 */
function getChildrenForCat( $catId ) {
	$db     = Db::getConnection();
	$result = $db->query( '
			SELECT *
			FROM `custom_light`.category
			WHERE parent_id =' . $catId);
	$result->setFetchMode( PDO::FETCH_ASSOC );
	$rs = $result->fetchAll();

	$db = null; // закрыть соединение
	return $rs;
}

/**
 * Получить главные категории с привязками дочерних
 *
 * @return array массив всех категорий
 */
function getAllMainCatsWithChildren() {
	$rs = getMainCats();

	foreach ( $rs as &$r ) {
		$rsChildren = getChildrenForCat( $r['id'] );
		if ( $rsChildren ) {
			$r['children'] = $rsChildren;
		}
	}
	unset( $r );

	$db = null; // закрыть соединение
	return $rs;
}

/**
 * Получить главные категории
 *
 * @return array массив главных категорий
 */
function getMainCats (){
	$db     = Db::getConnection();
	$result = $db->query( '
			SELECT *
			FROM `custom_light`.category
		 ' );
	$result->setFetchMode( PDO::FETCH_ASSOC );
	$cats = $result->fetchAll();

	$db = null; // закрыть соединение
	return $cats;
}

/**
 * Получить товары для индекс страницы
 *
 * @return array массив товаров для индекс страницы
 */
function getIndexOfItems (){
	$db = Db::getConnection();
	$result = $db->query('
		SELECT * FROM `custom_light`.item
	');

	$result->setFetchMode( PDO::FETCH_ASSOC );
	$items = $result->fetchAll();

	foreach ( $items as &$item ) {
		$colors = getItemColors( $item['id'] );
		if ( $colors ) {
			$item['colors'] = $colors;
		}
		$categories = getItemCategories( $item['id'] );
		if ( $categories ) {
			$item['categories'] = $categories;
		}
	}
	unset( $item );

	$db = null; // закрыть соединение
	return $items;
}

/**
 * Получить все товары
 *
 * @return array массив всех товаров
 */
function getAllItems(){
	$db = Db::getConnection();
	$result = $db->query('
		SELECT * FROM `custom_light`.item
	');

	$result->setFetchMode( PDO::FETCH_ASSOC );
	$items = $result->fetchAll();

	foreach ( $items as &$item ) {
		$colors = getItemColors( $item['id'] );
		if ( $colors ) {
			$item['colors'] = $colors;
		}
		$categories = getItemCategories( $item['id'] );
		if ( $categories ) {
			$item['categories'] = $categories;
		}
		$images = getItemImages( $item['id'] );
		if ( $images ) {
			$item['images'] = $images;
		}
	}
	unset( $item );

	$db = null; // закрыть соединение
	return $items;
}

/**
 * Получить все цвета, относящиеся к товару
 *
 * @param integer $itemId ID товара
 *
 * @return array массив всех цветов товара
 */
function getItemColors ($itemId){
	$db = Db::getConnection();
	$result = $db->query('
		SELECT `name` AS `color`
		FROM `custom_light`.color
		JOIN item_has_color
		ON color.id = item_has_color.color_id
		WHERE item_has_color.item_id =' . $itemId);

	$result->setFetchMode( PDO::FETCH_ASSOC );
	$colors = $result->fetchAll();

	$db = null; // закрыть соединение
	return $colors;
}

/**
 * Получить все цвета, относящиеся к товару
 *
 * @param integer $itemId ID товара
 *
 * @return array массив всех категорий товара
 */
function getItemCategories ($itemId){
	$db = Db::getConnection();
	$result = $db->query('
		SELECT `name` AS `category`
		FROM `custom_light`.category
		JOIN item_has_category
		ON category.id = item_has_category.category_id
		WHERE item_has_category.item_id =' . $itemId);

	$result->setFetchMode( PDO::FETCH_ASSOC );
	$colors = $result->fetchAll();

	$db = null; // закрыть соединение
	return $colors;
}

/**
 * Получить все цвета, относящиеся к товару
 *
 * @param integer $itemId ID товара
 *
 * @return array массив всех изображений товара
 */
function getItemImages ($itemId){
	$db = Db::getConnection();
	$result = $db->query('
		SELECT `path` AS `image`
		FROM `custom_light`.image
		JOIN item_has_image
		ON image.id = item_has_image.image_id
		WHERE item_has_image.item_id =' . $itemId);

	$result->setFetchMode( PDO::FETCH_ASSOC );
	$images = $result->fetchAll();

	$db = null; // закрыть соединение
	return $images;
}

/**
 * Получить все цвета, относящиеся к товару
 *
 * @param integer $categoryId ID категории
 *
 * @return array наименование категории
 *
 */
function getCategoryHeader ($categoryId){
	$db = Db::getConnection();
	$result = $db->query('
		SELECT name, short_description
		FROM `custom_light`.category
		WHERE id =' . $categoryId);

	$result->setFetchMode( PDO::FETCH_ASSOC );
	$categoryHeader = $result->fetch();

	$db = null; // закрыть соединение
	return $categoryHeader;
}