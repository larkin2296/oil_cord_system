<?php 

/**
 * 获取global的配置
 */
if ( !function_exists('getGlobalConfig') ) 
{
	function getGlobalConfig($key) 
	{
		return config('back.global.' . $key);
	}
}

/**
 * 获取主题文件
 */
if( !function_exists('getThemeFolder')) {
	function getThemeFolder()
	{
		return getGlobalConfig('theme.folder');
	}
}

/**
 * 获取主题名称
 */
if( !function_exists('getThemeName')) {
	function getThemeName()
	{
		return getGlobalConfig('theme.name');
	}
}

/**
 * 获取主题
 */
if (!function_exists('getTheme')) {
	function getTheme()
	{
		return getThemeFolder() . '.' . getThemeName();
	}
}

if (!function_exists('getThemeTemplate')) {
	function getThemeTemplate($template)
	{
		return getTheme() . '.' . $template;
	}
}

/**
 * 获取redis前缀
 */
if( !function_exists('getRedisPrefix')) {
	function getRedisPrefix($key = '')
	{
		return getGlobalConfig('redis.prefix') . $key;
	}
}

/**
 * 获取cache前缀
 */
if( !function_exists('getCachePrefix')) {
	function getCachePrefix($key = '')
	{
		return getGlobalConfig('cache.prefix') . $key;
	}
}

/**
 * 获取性别
 */
if( !function_exists('getSex') ) {
	function getSex()
	{
		return getGlobalConfig('sex.value');
	}
}

/**
 * 获取通用的true false
 */
if( !function_exists('getCommonCheck') ) {
	function getCommonCheck()
	{
		return getGlobalConfig('commoncheck.value');
	}
}

/**
 * 获取通用的验证的值
 */
if( !function_exists('getCommonCheckValue') ) {
	function getCommonCheckValue($bool = true)
	{
	    return 1;
		//return $bool ? getGlobalConfig('commoncheck.map.true') : getGlobalConfig('commoncheck.map.false');
	}
}

/**
 * 获取通用验证显示的值
 */
if ( !function_exists('getCommonCheckShowValue') ) {
	function getCommonCheckShowValue($value, $trueVale='是', $falseValue='否')
	{
		if ( getCommonCheckValue(true) == $value) {
			return $trueVale;
		} else {
			return $falseValue;
		}
	}
}


/**
 * 获取菜单位置
 */
if ( !function_exists('getMenuPosition') ) 
{
	function getMenuPosition() 
	{
		return getGlobalConfig('menu_position.value');
	}
}

if ( !function_exists('getMenuPositionValue') ) 
{
	function getMenuPositionValue($key) 
	{
		return getGlobalConfig('menu_position.map.' . $key);
	}
}

/**
 * 二维数组根据某一个键值排序
 * @param  [type] $arrays     [description]
 * @param  [type] $sort_key   [description]
 * @param  [type] $sort_order [description]
 * @param  [type] $sort_type  [description]
 * @return [type]             [description]
 */
function my_sort($arrays,$sort_key,$sort_order=SORT_ASC,$sort_type=SORT_NUMERIC ){   
    if(is_array($arrays)){   
        foreach ($arrays as $array){   
            if(is_array($array)){   
                $key_arrays[] = $array[$sort_key];   
            }else{   
                return false;   
            }   
        }   
    }else{   
        return false;   
    }  
    array_multisort($key_arrays,$sort_order,$sort_type,$arrays);   
    return $arrays;   
}  
