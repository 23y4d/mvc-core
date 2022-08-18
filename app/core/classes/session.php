<?php declare(strict_types=1);

namespace app\core\classes;


class session 
{
 

	public const INFO 		= 'info';
	public const SUCCESS 	= 'success';
    public const WARNING	= 'warning';
    public const DANGER 	= 'danger';

	private const USER   	= 'user';
	private const FLASH 	= 'flash';

		
	public function __construct() 
	{
		if (!session_id()) 
			session_start();	

	}
	
	public function set(array $value = []) 
	{
		$_SESSION[self::USER] = $value;
	}


	public function get(string $key) 
	{
		return $_SESSION[self::USER][$key] ?? false;
	}


	public function kill() 
	{
		unset($_SESSION[self::USER]);
	}


	public function setFlash($message, $type = null) 
	{
		if($type === null) {
			$type = self::INFO;
		}
		$_SESSION[self::FLASH][] = [
			'type' => $type,
			'value' => $message
		];
	}

	public function getFlash() 
	{
		$flash = $_SESSION[self::FLASH] ?? [];
		unset($_SESSION[self::FLASH]);
		return $flash;
	}


	public function all() 
	{
        return $_SESSION;
    }


	public function destroy() 
	{
        foreach($this->all() as $key => $v) {
            unset($_SESSION[$key]);
        }
    }



}
