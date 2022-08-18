<?php declare(strict_types=1); 
 namespace app\core\form;

class Form{


    public static function start($action,$method,$options = [])
    {
        $att = [];
        foreach ($options as $key => $value) {
            $att[] = "$key=\"$value\"";
        }
        echo sprintf('<form action="%s" method="%s" %s >', $action,$method, implode(' ', $att));
        return new Form();
    }

    public static function end()
    {
        echo '</form>';
    }

   public function input($model,$attr)
   {
        return new input($model,$attr);
   }

    public static function button($text)
    {
         echo sprintf('<input type="submit" value="%s" name="%s"   class="btn btn-outline-dark mt-3"/>',$text,$text);
    }
}