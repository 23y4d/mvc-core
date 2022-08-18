<?php declare(strict_types=1);

namespace app\core\form;
use app\core\form\filed;

class input extends filed  
{

	public function rendeInput()
	{
			
		return sprintf('<input type="%s" name="%s" value="%s" class="form-control  %s "  />',
			$this->type,
			$this->attr,
			$this->model->{$this->attr},
			$this->model->hasError($this->attr) ? 'is-invalid' : '',
		);
	}

}

