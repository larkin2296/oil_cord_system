<?php 

/**
 * 获取缓存的值
 */
if ( !function_exists('getCache') ) {
	function getCache($key)
	{
		return getCachePrefix() . config('back.cache.' . $key);
	}
}

if ( !function_exists('getCacheAllMenu') ) {
	function getCacheAllMenu()
	{
		return getCache('menu.key.all');
	}
}

if ( !function_exists('getCacheUserMenu') ) {
	function getCacheUserMenu($userId)
	{
		return getCache('menu.key.user') . '_' . $userId;
	}
}