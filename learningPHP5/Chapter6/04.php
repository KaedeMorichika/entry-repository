<?php
// フォーム要素表示のヘルパー関数

// テキスト
function input_text($element_name, $values) {
    print '<input type="text" name="'.$element_name.'" value="';
    print htmlentities($values[$element_name]).'">';
}

// サブミット
function input_submit($element_name, $label) {
    print '<input type="submit" name="'.$element_name.'" value="';
    print htmlentities($label).'">';
}

// テキストエリア
function input_textarea($element_name, $values) {
    print '<textarea name="'.$element_name.'">';
    print html_entities($values[$element_name]).'</textarea>';
}

// ラジオボタン・チェックボックス
function input_radiocheck($type, $element_name, $values, $element_value) {
    print '<input type="'.$type.'" name="'.$element_name.'" value="'.$element_value.'"';
    if ($element_value == $values[$element_name]) {
        print 'checked="checked"';
    }
    print '>';
}

// セレクトメニュー
function input_select($element_name, $selected, $options, $maltiple = false) {
    print '<select name="'.$element_name;
    if ($maltiple) {
        print '[]" maltiple="maltiple"';
    }
    print '>';

    $selected_options = array();
    if ($maltiple) {
        foreach ($selected[$element_name] as $val) {
            $selected_options[$val] = true;
        }
    } else {
        $selected_options[ $selected[$element_name] ] = true;
    }

    foreach ($options as $option => $label) {
        print '<option value="'.htmlentities($option).'"';
        if ($selected_options[$option]) {
            print ' selected="selected"';
        }
        print '>'.htmlentities(htmlentities($label)).'</option>';
    }
    print '</select>';
}
?>