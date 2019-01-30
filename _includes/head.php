<?php
// Include at the top of flow files, after bootstrap.php.
$css = '';

if (file_exists( '../_assets/main.css' )) {
    $css .= file_get_contents( '../_assets/main.css' );
}

if (file_exists( './this-grant.css' )) {
    $css .= file_get_contents( './this-grant.css' );
}
?><!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title><?php echo META_TITLE; ?></title>
    <style media="screen"><?php echo $css; ?></style>
</head>
<body>
<section>
