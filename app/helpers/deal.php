<?php 

if( !function_exists('dealAvatar')) {
	function dealAvatar($avatar, $folder = 'storage')
	{
		$results = asset("storage/{$avatar}");

        if( $avatar ) {
            if( starts_with('http', $avatar) ) {
                $results = $avatar;
            }
        } else {
            $results = '';
        }

        return $results;
	}
}