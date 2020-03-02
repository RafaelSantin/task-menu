<?php

namespace App\Http\Utils;
use Illuminate\Support\Facades\Log;

Class GeneralUtils 
{
	

    public static function verifyDepth($array, $max_depth, $depth = null){    

    	Log::info('here');
    	$array = $array[0];

    	if(is_null($depth))
    	{
    		$depth = 1;
    	}		

    	if (isset($array['children']) && !empty($array['children']))
    	{
    		$depth++;
    		self::verifyDepth($array['children'],$max_depth, $depth);
    	}

    	return $depth;

    }

}