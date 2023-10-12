<?php

function prepZero($value){
	return sprintf("%02d", $value);
}

function age($birthdate){
	return date_diff(date_create($birthdate), date_create('now'))->y;
}

function formatDate($format, $date){
	return date($format, strtotime($date));
}

function randString($count){
	$alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$str = '';
	for($i=0; $i < $count; $i++){
		$str .= $alpha[rand(0, strlen($alpha)-1)];
	}
	return $str;
}

function uploadImage($file, $destination){
	if($file){
		$rstring = randString(25);
		$file = $file;
		$fname = $rstring . '.' . $file->getClientOriginalExtension();
		$file->move($destination, $fname);
		return $destination . '/' . $fname;
	}
	return '';
}

function selected($a, $b, $c){
	if($a == $b){
		return $c;
	}
	return '';
}

function productImage($image){
	if(empty($image)){
		return asset('img/img_temp.png');
	}
	return asset($image);
}

function balanceDue($arr){
	$sum = 0;
	foreach ($arr as $key => $value) {
		$sum += $value->amount;
	}
	return number_format($sum, 2, '.', '');
}

function isDeletable($table, $field, $id)
{
	return (DB::table($table)->where($field,$id)->exists()) ? false : true;
}

function addCommas($number)
{
	return number_format($number, 2);
}

function removeCommas($obj)
{
	return str_replace(',', '', $obj);
}

function checkUserHasAccessModule($type, $moduleName)
{
	$user = Auth::user();
	if($type == 'module')
	{
		$accessLists = App\Models\AccessList::where('module_name',$moduleName)->pluck('al_id');
		if(count($accessLists)> 0)
		{
			foreach($user['accessibilities'] as $accessibility){
				if($accessibility['subModuleList']['al_id'] == $accessLists[0])
				{
					return true;
				}
			}
		}
		return false;
	}else if($type == 'sub-module')
	{
		foreach($user['accessibilities'] as $accessibility){
			
			if($accessibility['subModuleList']['route'] == $moduleName)
			{
				return true;
			}
		}
		return false;
	}
}
function sortList($data, $index){
	// dd($data->toArray()['data']);
	usort($data->toArray()['data'], function ($a, $b) use ($index) {
		return customSort($a, $b, $index);
	});
	return $data;
}

function customSort($a, $b, $propertyToCompare) {
	if($a[$propertyToCompare] && $b[$propertyToCompare]){
		if ($a[$propertyToCompare] < $b[$propertyToCompare]) {
			return -1; // $a comes before $b
		} elseif ($a[$propertyToCompare] > $b[$propertyToCompare]) {
			return 1; // $a comes after $b
		} else {
			return 0; // $a and $b are equal
		}
	}
	return 0;
}