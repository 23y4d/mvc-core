<?php declare(strict_types=1); 

namespace app\core\form;


class textarea extends filed {

	

    public function rendeInput() 
    {
     
        return sprintf('<textarea  name="%s" class="form-control %s" >%s</textarea> ',
                $this->attr,
                $this->model->hasError($this->attr) ? 'is-invalid' : '',
                $this->model->{$this->attr}
        );


    }
}

