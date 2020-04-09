
<?php
if (!empty($_POST['_submit_check'])) {
    if (validate_form()) {
        process_form();
    } else {
        show_form();
    }
} else {
    show_form();
}

function process_form() {
    print "Hello, ".$_POST['my_name'];
}

function show_form() {
    print<<<_HTML_
<html>
<body>
<form method="POST" action="{$_SERVER['SCRIPT_NAME']}">
Your Name: <input type="text" name="my_name">
<br/>
<input type="submit" value="Say Hello">
<input type="hidden" name="_submit_check" value="1">
</form>
</body>
</html>
_HTML_;
}

function validate_form() {
    if (strlen($_POST['my_name']) < 3) {
        return false;
    } else {
        return true;
    }
}
?>