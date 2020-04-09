
<?php
if (array_key_exists('my_name', $_POST)) {
    print "Hello, ".$_POST['my_name'];
} else {
    print<<<_HTML_
<html>
<body>
<form method="post" action="{$_SERVER['SCRIPT_NAME']}">
Your Name: <input type="text" name="my_name">
<br/>
<input type="submit" value="Say Hello">
</form>
</body>
</html>
_HTML_;
}
?>