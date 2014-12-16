<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><?=$model->getAttribute("title")?></title>
</head>
<body>
    <?
        $name = $model->getAttribute("name");
        $message = $model->getAttribute("message");
        if($name == NULL) $name = "Joey";
    ?>

    Hello, <?=$name?>! Your have a message from anonymous : <?=$message?>
</body>
</html>