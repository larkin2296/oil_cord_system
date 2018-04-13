<?php 

if(!function_exists('checkEncrypt'))
{
	function checkEncrypt($module = 'default')
	{
		return config('back.encrypt.' . $module);
	}
}