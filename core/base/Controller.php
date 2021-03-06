<?php

namespace core\base;

abstract class Controller {
	/**
	 * Текущий маршрут и параметры (controller, action, params, alias)
	 * @var array
	 */
	public $route = array();
	/**
	 * Текущий вид
	 * @var string
	 */
	public $view;
	/**
	 * Текущий шаблон
	 * @var string
	 */
	public $layout = 'default';

	/**
	 * Пользовательские данные
	 * @var array
	 */
	public $vars = [];

	/**
	 * общая информация для определенного шаблона (меню и т.п.)
	 * @var array
	 */
	protected $layoutEssentials = array();

	/**
	 * Нужна ли авторизация
	 * @var bool;
	 */
	protected $auth = false;

	/**
	 * Наименование категории авторизации (для разграничения уровней доступа)
	 * @var bool;
	 */
	protected $authCategory = 'auth';

	/**
	 * Пароль доступа к контроллеру по умолчанию
	 * @var string;
	 */
	protected $pass = ADMIN_PASS;

	/**
	 * Получен ли доступ к контроллеру
	 * @var bool;
	 */
	protected $is_auth = false;

	/**
	 * Controller constructor.
	 * Создает объект контроллера, проверяет авторизацию и присваивает $route и $view
	 *
	 * @param array $route массив с маршрутом
	 */
	public function __construct( $route ) {
		//> защита от чужих скриптов
		if ( $_SERVER['REQUEST_METHOD'] == 'POST' && $_POST ) {
			$_POST = $this->htmlSpecialCharsUniversal( $_POST );
		}
		//< защита от чужих скриптов

		$this->route = $route;
		$this->view  = $route['action'];

		//> блок функционала авторизации
		if ( $this->auth ) {
			$this->is_auth() or die( "АВТОРИЗАЦИЯ НЕ ПРОШЛА!!!" );
		}
		//< блок функционала авторизации
		$this->getLayoutEssentials();
	}

	/**
	 * Проверяет авторизован ли пользователь
	 *
	 * @return bool авторизован или нет
	 */
	protected function is_auth() {
		if ( isset ( $_POST[ $this->authCategory ] ) && password_verify( htmlspecialchars( $_POST [ $this->authCategory ] ), $this->pass ) ) {
			$_SESSION [ $this->authCategory ] = true;
		}

		if ( $this->view == 'index' ) { // т.к. индексные страницы, как правило, являются страницами авторизации
			return true;
		}

		if ( isset( $_SESSION [ $this->authCategory ] ) && $_SESSION [ $this->authCategory ] ) {
			$this->is_auth = true;

			return true;
		} else {
			$this->is_auth                    = false;
			$_SESSION [ $this->authCategory ] = false;

			return false;
		}
	}

	/**
	 * Отменяет авторизацию определенного контроллера
	 */
	public function exitAuthAction() {
		unset( $_SESSION [ $this->authCategory ] );
		$this->is_auth = false;
		$this->view    = "index";
		$title         = "Авторизация прекращена.";
		$this->setVars( compact( 'title' ) );
	}

	/**
	 * Обрабатывает строки, JSON-строки, массивы строк и объекты функцией htmlspecialchars(); рекурсивно
	 *
	 * @param object|array|string data
	 *
	 * @return object|array|string
	 */
	protected function htmlSpecialCharsUniversal( $data ) {
		// Если массив или объект то входим в рекурсию
		if ( is_array( $data ) || is_object( $data ) ) {
			foreach ( $data as $key => &$item ) {
				// Временный костыль (не обрабатывать поля с такими ключами)
				if ( preg_match( '/(description)/', mb_strtolower( $key ) ) || preg_match( '/(content)/', mb_strtolower( $key ) ) ) {
					continue;
				}
				$item = $this->htmlSpecialCharsUniversal( $item );
			}
		}
		// Если строка
		if ( is_string( $data ) ) {
			json_decode( $data );
			// Если декодируется в объект JSON
			if ( ! json_last_error() ) {
				$data = json_decode( $data );
				// Обрабатываем каждое поле объекта рекурсивно
				$data = $this->htmlSpecialCharsUniversal( $data );
				// Возвращаем первоначальный формат
				$data = json_encode( $data );
			} else {
				// Обрабатываем тем за чем собственно эта функция
				$data = htmlspecialchars( $data );
			}
		}

		if ( is_numeric( $data ) ) {
			$data = $data * 1;
		}

		return $data;
	}

	/**
	 * Загружает необходимую информацию для определенного шаблона
	 */
	protected

	abstract function getLayoutEssentials();

	/**
	 *  Получить вид, передать в него параметры и отрисовать
	 */
	public function getView() {
		$viewObject = new View( $this->route, $this->layout, $this->view );
		$viewObject->render( $this->vars );
	}

	/**
	 *  Присвоить пользовательские данные
	 *
	 * @param array $vars
	 */
	protected function setVars( $vars ) {
		$this->vars = $vars;
	}

	/**
	 * Присвоить пароль для доступа к контроллеру
	 *
	 * @param string $pass
	 */
	protected function setPass( string $pass ) {
		$this->pass = $pass;
	}
}