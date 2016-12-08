<?php
/**
 * файл конфигурации маршрутов
 */

$this->addRoute( "^test/?$", [ 'action' => 'test' ] );

$this->addRoute( "^page/(?P<alias>[a-z-]+)/?$", [ 'controller' => 'Page' ] );

// Маршруты по умолчанию (должны быть ниже всех)
$this->addRoute( '^$', [ 'controller' => DEFAULT_CONTROLLER, 'action' => DEFAULT_ACTION ] );
$this->addRoute( "^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?/?(?P<params>[0-9-]+)?$" );