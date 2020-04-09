
<?php
if (!empty($_POST['_submit_check'])) {
    if (!$form_errors = validate_form()) {
        process_form();
    } else {
        show_form($form_errors);
    }
} else {
    show_form();
}

function process_form() {
    $number1 = $_POST['number1'];
    $number2 = $_POST['number2'];
    $operator = $_POST['operator'];
    switch ($operator) {
        case '+':
            $result = $number1 + $number2;
            print $number1.' + '.$number2.' = '.$result;
            break;
        case '-':
            $result = $number1 - $number2;
            print $number1.' - '.$number2.' = '.$result;
            break;
        case '*':
            $result = $number1 * $number2;
            print $number1.' * '.$number2.' = '.$result;
            break;
        case '/':
            $result = $number1 / $number2;
            print $number1.' / '.$number2.' = '.$result;
            break;
    }
}

function show_form($errors = '') {
    if ($errors) {
        print 'Please correct these errors: <ul><li>';
        print implode('</li><li>', $errors);
        print '</li></ul>';
    }

    print<<<_HTML_
<html>
<body>
<form method="POST" action="{$_SERVER['SCRIPT_NAME']}">
<input type="text" name="number1">

<select name="operator">
<option>+</option>
<option>-</option>
<option>*</option>
<option>/</option>
</select>

<input type="text" name="number2">

<input type="hidden" name="_submit_check" value="1">

<input type="submit" value="enter">
</form>
</body>
</html>
_HTML_;
}

function validate_form() {
    $errors = array();
    if ($_POST['number1'] != strval(intval($_POST['number1'])) or
        $_POST['number2'] != strval(intval($_POST['number2']))
        ) {
        $errors[] = 'Please enter valid numbers.';
        return $errors;
    }
}
?>