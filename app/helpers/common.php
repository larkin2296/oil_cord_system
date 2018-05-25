<?php

if ( !function_exists('getRouteParam') ) {
	function getRouteParam($key)
	{
		return request()->route($key) ?: '';
	}
}

/**
 * 获取当前登录用户
 */
if ( !function_exists('getUser') ) {
	function getUser()
	{
		return auth()->user();
	}
}

/**
 * 获取当前登录用户id
 */
if ( !function_exists('getUserId') ) {
	function getUserId()
	{
		$user = getUser();

		return $user->id;
	}
}
/**
* 查看供应商是否获取卡密权限
* @param [type] $status [description]
* @param [type] $user_id [description]
*/

    if( !function_exists('getSupplierCardPermission') )
    {
        function getSupplierCardPermission($users)
        {
           $user = app(\App\Repositories\Interfaces\UserRepository::class)->find($users->id);

           return buildSupplierPermission($user->cam_permission);
        }
    }
    if( !function_exists('buildSupplierPermission') )
    {
        function buildSupplierPermission($status)
        {
            if( $status != getCommonCheckValue(true) )
            {
                return getCommonCheckValue(false);
            }
        }
    }


/**
 * 获取单位id
 */
if ( !function_exists('getCompanyId') ) {
	function getCompanyId($companyId = 0)
	{
	    #TODO: sidlee modify by 2018-01-22
		return $companyId ?: session('company_id',0);
	}
}

/**
 * 设置单位id
 */
if ( !function_exists('setCompanyId') ) {
	function setCompanyId($companyId)
	{
		session(['company_id' => $companyId]);
	}
}

/**
 * 获取工作流id
 */
if ( !function_exists('getWorkflowId') ) {
	function getWorkflowId($workflowId = '', $encrypt = false)
	{
		$workflowId = $workflowId ?: session('workflow_id');
		if (!$encrypt) {
			return $workflowId;
		} else {
			return app(\App\Repositories\Interfaces\WorkflowRepository::class)->encodeId($workflowId);
		}
	}
}

/**
 * 是否显示菜单
 */
if ( !function_exists('checkMenuPosition') ) {
	function checkMenuPosition($position)
	{
		$menuPositions = getCompanyId() ? [getMenuPositionValue('all'), getMenuPositionValue('company')] : [getMenuPositionValue('all'), getMenuPositionValue('admin')];

		return in_array($position, $menuPositions);
		
	}
}

/**
 * 计算倒计时
 */
if ( !function_exists('calcCarbonCountdown') ) {
	function calcCarbonCountdown($value, $format = 'one')
	{	
		// dd($value);
		$value = new \Carbon\Carbon($value);

		/*当前时间*/
		$now = new \Carbon\Carbon();

		// dd($value->diffInSeconds($now)->format('d'));
		/*相差秒数*/
		$diffSeconds = $value->diffInSeconds($now);

		$isOverdue = $value >= $now ? true : false;

		$string = '';

		/*一分钟秒数*/
		$standMinute = 60;
		/*一小时秒数*/
		$standHour = 3600;
		/*一天秒数*/
		$standDay = 86400;

		$days = floor($diffSeconds / $standDay) ? : 0;

		$diffSeconds = $diffSeconds - $days * $standDay;
		$hours = floor($diffSeconds / $standHour) ? : 0;

		$diffSeconds = $diffSeconds - $hours * $standHour;
		$minutes = floor($diffSeconds / $standMinute) ? : 0;

		/*单类型格式*/
		if($format == 'one') {
			if( $days ) {
				$string = $days . 'd';
			} else if ( $hours ) {
				$string = $hours . 'h';
			} else if ( $minutes ) {
				$string = $minutes . 'm';
			}

			if( $value > $now ) {
				$string = $string ? : '0m'; 
			}

			if( $value < $now ) {
				$string = $string ? '-' . $string : '-1m'; 
			}
		}

		/*全部类型格式*/
		if( $format == 'all' ) {
			$daysString = $days ? $days . '天' : '';
			$hoursString = $hours ? $hours . '小时' : '';
			$minutesString = $minutes ? $minutes . '分' : '';
			$string = $daysString . $hoursString . $minutesString;

			if( $value > $now ) {
				$string = $string ? : '0分'; 
			}

			if( $value < $now ) {
				$string = $string ? '-' . $string : '-1分'; 
			}
		}

		return $string;

	}
}

/**
 * 计算文件大小
 */
if ( !function_exists('calcFileSize') ) {
	function calcFileSize($value, $unit = 'MB')
	{	
		switch( $unit ) {
			case 'MB' :
				$value = number_format($value / 1024 /1024, 2);
				break;
			case 'KB' :
				$value = number_format($value / 1024, 2);
				break;
		}

		return $value . $unit;
	}
}

/**
 * 验证用户登录密码是否正确
 */
if ( !function_exists('checkUserPasswordByWeb') ) {
	function checkUserPasswordByWeb($password)
	{
		$user = getUser();

		$credentials = [
			'password' => $password
		];

		/*验证用户密码是否正确*/
		return checkUserPassword($user, $credentials);
	}
}

if( !function_exists('checkUserPassword')) {
	function checkUserPassword($user, $credentials)
	{
		/*验证用户密码是否正确*/
		return auth()->guard()->getProvider()->validateCredentials($user, $credentials);
	}
}

if(!function_exists('makeTree')){
    function makeTree($data,$id = 0){
        $list = [];
        foreach($data as $v) {
            if($v['pid'] == $id) {
                $v['son'] = makeTree($data, $v['id']);
                if(empty($v['son'])) {
                    unset($v['son']);
                }
                array_push($list, $v);
            }
        }
        return $list;
    }
}
