<?php
use duncan3dc\Laravel\Blade;

Blade::addPath('view');
echo Blade::render($action);

