<?php

/*
 * 唐揚げ、チキン南蛮、カレーを提供する定食屋
 */

require_once 'file_importer.php';

// 唐揚げ、チキン南蛮、カレーのデータを取ってくる。
$karaages = Karaage::get_datas();
$chicken_nanbans = ChickenNanban::get_datas();
$curries = Curry::get_datas();

$karaage_parts = array();
$chicken_nanban_parts = array();
$curry_parts = array();

// 唐揚げの部品群生成
foreach ($karaages as $karaage) {
    
    $karaage_parts[] = new TeishokuComponent(new Karaage($karaage['name'], $karaage['price']));
    
}

// チキン南蛮の部品群生成
foreach ($chicken_nanbans as $chicken_nanban) {
    
    $chicken_nanban_parts[] = new TeishokuComponent(new ChickenNanban($chicken_nanban['name'], $chicken_nanban['price']));
    
}

// カレーの部品群生成
foreach ($curries as $curry) {
    
    $curry_parts[] = new TeishokuComponent(new Curry($curry['name'], $curry['price']));
    
}

$teishoku_components = array_merge($karaage_parts, $chicken_nanban_parts, $curry_parts);

// メニュー表示
Teishoku::show_menu($teishoku_components);

print '<br>';

// フォーム表示
Teishoku::show_form($teishoku_components, 'accounting.php');




?>