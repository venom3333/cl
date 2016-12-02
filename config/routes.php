<?php
/**
 * файл конфигурации маршрутов
 */
//$this->addRoute( 'category', [ 'controller' => 'category', 'action' => 'index' ] );
//$this->addRoute( 'index', [ 'controller' => 'index', 'action' => 'index' ] );
//$this->addRoute( '', [ 'controller' => 'index', 'action' => 'index' ] );

// Маршруты по умолчанию
$this->addRoute( '^$', [ 'controller' => 'Index', 'action' => 'index' ] );
$this->addRoute( "^(?P<controller>[a-z-]+)/(?P<action>[a-z-]+)?/(?P<params>[0-9-]+)?$" );
$this->addRoute( "^(?P<controller>[a-z-]+)/(?P<params>[0-9-]+)?$" );
