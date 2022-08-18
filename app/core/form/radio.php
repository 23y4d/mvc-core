<?php declare(strict_types=1); 

namespace app\core\form;


class radio extends filed {


    
    public function rendeInput() {
     
        return sprintf('<input type="radio" name="%s" value="%s"  class="form-check-input  %s "   %s />',
                $this->attr,
                $this->model->{$this->attr} ?? $this->value,
                $this->model->hasError($this->attr) ? 'is-invalid' : '',
                $this->radioCheckedIf($this->attr,$this->model->{$this->attr})
        );


    }
    private function radioCheckedIf($fieldName, $value, $object = null)
    {
        return ((isset($_POST[$fieldName]) && $_POST[$fieldName] == $value) 
        || ($object !== null && $object->$fieldName == $value)) 
        ? 'checked' : '';
    }

   
}

