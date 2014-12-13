<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Test Page</title>
</head>
<body>
    <?
        $number = $model->getAttribute("number");
        $name = $model->getAttribute("name");
        if($name == NULL) $name = "Joey";
    ?>

    Hello, <?=$name?>! Your number is <?=$number?>
</body>
</html>