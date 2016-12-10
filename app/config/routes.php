<?php
/**
 * файл конфигурации маршрутов
 */

$this->addRoute( "^test/?$", [ 'action' => 'test' ] );

$this->addRoute( "^page/(?P<alias>[a-z-]+)/?$", [ 'controller' => 'Page' ] );

//$this->addRoute( "^cart/(?P<action>[a-z-]+)/(?P<alias>[0-9-]+)/(?P<params>[0-9-]+)/?$", [ 'controller' => 'Cart' ] );    // алиас - id продукта в корзине, params - количество оного

// Маршруты по умолчанию (должны быть ниже всех)
$this->addRoute( '^$', [ 'controller' => DEFAULT_CONTROLLER, 'action' => DEFAULT_ACTION ] );
$this->addRoute( "^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?/?(?P<alias>[a-z-0-9]+)?/?(?P<params>[0-9-]+)?$" );