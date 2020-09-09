<?php 
//ヘルパー関数

// テキストボックス
function input_text($element_name, $values) {
    print '<input type="text" name="'.$element_name;
    if (array_key_exists($element_name, $values)) {
        print '" value="'.htmlentities($values[$element_name]);
    }
    print '"/>';
}

// サブミットボタン
function input_submit($element_name, $label) {
    print '<input type="submit" name="'.$element_name.'" value="';
    print htmlentities($label).'"/>';
}

// テキストボックス
function input_textarea($element_name, $values) {
    print '<textarea name="'.$element_name.'">';
    if (array_key_exists($element_name, $values)) {
        print htmlentities($values[$element_name]);
    }
    print '</textarea>';
}

// ラジオボタン or チェックボックス
function input_radiocheck($type, $element_name, $values, $element_value) {
    print '<input type="'.$type.'" name="'.$element_name.'" value="'.$element_value.'" ';
    if (array_key_exists($element_name, $values)) {
        if ($values[$element_name] == $element_value) {
            print 'checked="checked"';
        }
    }
    print '/>';
}

// セレクトメニュー
function input_select($element_name, $selected, $options, $multiple = false) {
    // <select>タグを出力
    print '<select name="'.$element_name;
    if ($multiple) {
        print '[]" multiple="multiple';
    }
    print '">';
    
    // 選択されるもののリストを設定
   $selected_options = array();
   if (array_key_exists($element_name, $selected)) {
        if ($multiple) {
            foreach ($selected[$element_name] as $val) {
                $selected_options[$val] = true;
            }
        } else {
            $selected_options[$selected[$element_name]] = true;
        }
   }
   
   // <option>タグを出力
   foreach ($options as $option => $label) {
       print '<option value="'.htmlentities($option).'"';
       if ($selected_options[$option]) {
           print ' selected="selected"';
       }
       print '>'.htmlentities($label).'</option>';
   }
   print '</select>';
}


?>