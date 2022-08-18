<?php

namespace app\core\errorhandlers;


class exceptionhandler
{

    public static function exceptionhandle($error) {
        ob_clean();
        http_response_code(500);
        $title = "Application Error";
        $code = $error->getCode();
        $message = $error->getMessage();
        $file = $error->getFile();
        $line = $error->getLine();
        $trace = str_replace(['#', '\n'], ['<div>#', '</div>'], $error->getTraceAsString());
        $html  = sprintf("<h1 style='color:#dc3545'>%s</h1>", $title);
        $html .= '<p>The application could not run because of the following error:</p>';
        $html .= '<h2>Details</h2>';
        $html .= sprintf('<div><strong>Type:</strong> %s</div>', get_class($error));
        $html .= sprintf('<div><strong>Code:</strong> %s</div>', $code);
        $html .= sprintf('<div><strong>Message:</strong> %s</div>', $message);
        $html .= sprintf('<div><strong>File:</strong> %s</div>', $file);
        $html .= sprintf('<div><strong>Line:</strong> %s</div>', $line);
        $html .= '<h2>Trace</h2>';
        $html .= sprintf('<pre>%s</pre>', $trace);
        $output = sprintf("
                    <html>
                    <head>
                    <title>%s</title>
                    <style>
                    body{background-color:#F1F0EF;margin:30;padding:20px;font:13px/1.5 -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif; }
                    h1{margin:0;font-size:48px;font-weight:normal;line-height:48px;}
                    strong{display:inline-block;width:65px;}   
                    </style>
                    </head>
                    <body> %s </body>
                </html>
        ", $title, $html);
        die($output);
       
    }
}
