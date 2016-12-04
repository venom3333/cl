<?php
/**
 * файл конфигурации маршрутов
 */

$this->addRoute( "^(test)/?$", [ 'controller' => 'Index', 'action' => 'test' ] );


// Маршруты по умолчанию (должны быть ниже всех)
$this->addRoute( '^$', [ 'controller' => 'Index', 'action' => 'index' ] );
$this->addRoute( "^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?/?(?P<params>[0-9-]+)?$" );