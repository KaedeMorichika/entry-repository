<?php
/**
 * オブジェクトのお勉強のためのサンプルプログラムー
 */

$curry_data = getFromDatabase('curry');
$curry = new Curry($curry_data['name'],$curry_data['price'] );

$karaage_data = getFromDatabase('karaage');
$karaage = new Karaage($karaage_data['name'],$karaage_data['price']);

$curry->showExplain();
$curry->showOption();

$karaage->showExplain();
$karaage->showOption();