<?php 

namespace App\Traits;

use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Predis\Connection\ConnectionException;

Trait ExceptionTrait
{
	public function handler(Exception $e, $resetMessage = '')
	{
		$code = $e->getCode();

		$message = $resetMessage;

		switch($code) {
			/*非自定义抛出的异常*/
			case '0' :
				if( $e instanceof ModelNotFoundException) {
					$message = trans('code/global.model_not_found');
				}

				break;
			//自定义
			case '2' :
				$message = $e->getMessage();
				break;

			case 'HY000' : 
				$message = trans('code/global.HY000');
				break;				

			case '10061' :
				$message = "连接redis出错";
				break;
				break;
			default : 
				$message = '出错了';
				break;
		}

		return $message;
	}
}