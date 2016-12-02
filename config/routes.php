<?php
/**
 * файл конфигурации маршрутов
 */

// Маршруты по умолчанию
$this->addRoute( '^$', [ 'controller' => 'Index', 'action' => 'index' ] );
$this->addRoute( "^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?/?(?P<params>[0-9-]+)?$" );