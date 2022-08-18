<?php

declare(strict_types=1);


if (!function_exists('dd')) {

    function dd()
    {
        $value = func_get_args();
            echo '<pre>';
             array_map(fn($x) => var_dump($x),$value);
            echo '</pre>';
    }
}


if (!function_exists('filterInt')) {

    function filterInt($input)
    {
        return (int) filter_var($input, FILTER_SANITIZE_NUMBER_INT);
    }
}


if (!function_exists('filterStirng')) {

    function filterStirng($input)
    {
        return (string) htmlentities(strip_tags($input), ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('filterStringArray')) {

    function filterStringArray(array $arr)
    {
        foreach ($arr as $key => $value) {
            $arr[$key] = htmlentities(filter_var(trim($value), FILTER_SANITIZE_FULL_SPECIAL_CHARS), ENT_QUOTES, 'utf-8');
        }
        return $arr;
    }
}


if (!function_exists('app')) {
    /**
     * @var \app\core\application; 
     */
    function app()
    {
        return \app\core\application::$app;
    }
}



if (!function_exists('config')) {

    function config(string $value)
    {
        return app()->configs->getConfig($value) ?? false;
    }
}
if (!function_exists('basePath')) {

    function basePath()
    {
        return app()::$dir === null
            ? dirname(dirname(dirname(__DIR__)))
            : dirname(app()::$dir);
    }
}

if (!function_exists('configPath')) {
    function configPath()
    {
        return corePath() . DIRECTORY_SEPARATOR . 'configs/' ?? false;
    }
}



function emailBody(array $body)
{
    $mailBody = require corePath() . '/../views/layouts/mail.T.php';
    return str_replace(['{{name}}', '{{activation}}'], $body, $mailBody) ?? false;
}


if (!function_exists('corePath')) {
    function corePath()
    {
        return dirname(__DIR__) ?? false;
    }
}



function convertSize($file)
{
    $sizetype = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    return $file ? round((float) $file / 1024 ** ($i = floor(log($file, 1024))), 2) . $sizetype[$i] : "n/a";
}
