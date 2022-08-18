<?php declare(strict_types=1);


namespace app\core;


class view
{

    protected static $title;

    protected static $layout;

    public static function getView(string $view, array $params = [])
    {
        $file   = self::viewOnly($view, $params);
        $title =  self::$title ?? config('view.title');
        $layout = self::layout();
        return str_replace(['{{title}}', '{{text}}'], [$title, $file], $layout);
    }
    
    public static function setTitle($title)
    {
        self::$title = $title;
    }

    public static function setlayout($layout)
    {
        self::$layout = $layout;
    }


    private static function layout()
    {

        $layout = self::$layout ?? config('view.layout');
        ob_start();
        echo self::headers();
        require basePath() . "/app/views/layouts/{$layout}.php";
        return ob_get_clean();
    }

    private static function viewOnly($view, $params)
    {
        extract($params,EXTR_SKIP);
        ob_start();
        require basePath() . "/app/views/{$view}.php";
        return ob_get_clean();
    }


    private static function headers()
    {
        $output = '';
        $resources = config('view');
        if ($resources) {
            $css = $resources['css'] ?? null;
            if ($css) {
                foreach ($css as $cssKey => $path) {
                    $output .= '<link type="text/css" rel="stylesheet" href="' . $path . '" />';
                }
            }
            $js = $resources['js'] ?? null;
            if ($js) {
                foreach ($js as $jsKey => $path) {
                    $output .= '<script src="' . $path . '"></script>';
                }
            }
        }
        require basePath() . "/app/views/layouts/headerstart.php";
        return $output;
    }

}
