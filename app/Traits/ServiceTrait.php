<?php 

namespace App\Traits;

use Exception;

Trait ServiceTrait
{

	public function index()
	{
		return [];
	}

	public function create()
	{
		return [];
	}

	public function store()
	{
		return [];
	}

	public function show($id)
	{
		return [];
	}

	public function edit($id)
	{
		return [];
	}

	public function update($id)
	{
		return [];
	}

	/**
	 * 验证产品并返回，默认不能为空
	 * @param  [type]  $key     [description]
	 * @param  [type]  $default [description]
	 * @param  boolean $bool    [description]
	 * @return [type]           [description]
	 */
	public function checkParam($key, $default, $bool = true)
	{
		$val = request($key);

		if($bool) {
			if(!$val) {
				throw new Exception("参数不能为空", 2);
			}
		} else {
			$val = $val ?: $default;
		}

		return $val;
	}

	public function checkParamValue($val, $default, $bool = true)
	{
		if($bool) {
			if(!$val) {
				throw new Exception("参数不能为空", 2);
			}
		} else {
			$val = $val ?: $default;
		}

		return $val;
	}

	/**
	 * 获取请求中的参数的值
	 * @param  array  $fields [description]
	 * @return [type]         [description]
	 */
	public function searchArray($fields=[])
	{
		$results = [];
		if (is_array($fields)) {
			foreach($fields as $field => $operator) {
				if(request()->has($field) && $value = $this->checkParam($field, '', false)) {
					if( $operator == 'like' ) {
						$results[$field] = [$field, $operator, "%{$value}%"];
					} else {
						$results[$field] = [$field, $operator, $value];
					}
				}
			}
		}

		return $results;
	}

	/**
	 * 获取请求中的参数的值
	 * @param  array  $fields [description]
	 * @return [type]         [description]
	 */
	public function searchArrayAdvance($fields=[])
	{
		$results = [];
		if (is_array($fields)) {
			foreach($fields as $field => $operator) {
				/*传递的值*/
				$value = request()->has($field) ? $this->checkParam($field, '', false) : '';

				/*默认值*/
				if( is_array($operator) ) {
					$setOperator = $operator['operator'] ?: '=';
					/*默认值*/
					$defaultValue = is_array($operator) && isset($operator['default']) && $operator['default'] ? $operator['default'] : '';
					$setValue = $defaultValue ?: $value;
					$setEncrypt = isset($operator['encrypt']) ? $operator['encrypt'] : '';

					/*没有默认值*/
					if( !$defaultValue ) {
						$setValue = $setEncrypt ? $setEncrypt->decodeId($setValue) : $setValue;
					}
					
				} else {
					$setOperator = $operator;
					$setValue = $value;
				}

				if( $setValue ) {
					$results[$field] = $this->getSearchResult($field, $setOperator, $setValue);
				}
			}
		}

		return $results;
	}

	private function getSearchResult($field, $operator, $value)
	{	
		switch( $operator ) {
			case 'like' :
				$result = [$field, $operator, "%{$value}%"];
				break;
			default :
				$result = [$field, $operator, $value];
				break;
		}

		return $result;
	}

	public function setBetweenValue($operator)
	{
		$setValue = [];

		$startField = $operator['start'];
		$endField = $operator['end'];

		$startValue = request($startField, '');
		$endValue = request($endField, '');

		if( $startValue && $endValue ) {
			$setValue = [
				$startValue, $endValue
			];
		}

		return $setValue;
	}
}