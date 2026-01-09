<?php

use Spatie\Activitylog\Models\Activity;

function prepZero($value)
{
    return sprintf("%02d", $value);
}


function age($birthdate)
{
    return date_diff(date_create($birthdate), date_create('now'))->y;
}

function formatDate($format, $date)
{
    return date($format, strtotime($date));
}

function randString($count)
{
    $alpha = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $count; $i++) {
        $str .= $alpha[rand(0, strlen($alpha) - 1)];
    }
    return $str;
}

function uploadImage($file, $destination)
{
    if ($file) {
        $rstring = randString(25);
        $file = $file;
        $fname = $rstring . '.' . $file->getClientOriginalExtension();
        $file->move($destination, $fname);
        return $destination . '/' . $fname;
    }
    return '';
}

function selected($a, $b, $c)
{
    if ($a == $b) {
        return $c;
    }
    return '';
}

function productImage($image)
{
    if (empty($image)) {
        return asset('img/img_temp.png');
    }
    return asset($image);
}

function balanceDue($arr)
{
    $sum = 0;
    foreach ($arr as $key => $value) {
        $sum += $value->amount;
    }
    return number_format($sum, 2, '.', '');
}

function isDeletable($table, $field, $id)
{
    return (DB::table($table)->where($field, $id)->exists()) ? false : true;
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
    if ($type == 'module') {
        $accessLists = App\Models\AccessList::where('module_name', $moduleName)->pluck('al_id');
        if (count($accessLists) > 0) {
            $accessbilities = $user->accessibilities->toArray();
            foreach ($accessbilities as $accessibility) {
                /*          dd($accessibility['sub_module_list']['al_id'], $accessibility['sub_module_list']['al_id'], $accessLists[0]); */
                if (isset($accessibility['sub_module_list']['al_id']) && $accessibility['sub_module_list']['al_id'] == $accessLists[0]) {
                    return true;
                }
            }
        }
        return false;
    } else if ($type == 'sub-module') {
        foreach ($user['accessibilities'] as $accessibility) {
            if (isset($accessibility['sub_module_list']['route']) && $accessibility['sub_module_list']['route'] == $moduleName) {
                return true;
            }
        }
        return false;
    }
}
function getChanges($model, $replicate)
{

    $attributes = $model->getChanges();
    $old = [];
    foreach ($attributes as $key => $value) {
        $old[$key] = $replicate[$key];
    }
    return [
        'attributes' => $attributes,
        'old' => $old
    ];
}
function activityLogWithProperties($model, $attributes, $replicate)
{
    $attributes = $model->getChanges();
    $old = [];
    foreach ($attributes as $key => $value) {
        $old[$key] = $replicate[$key];
    }
    activity($attributes['log_name'])->event($attributes['event'])->performedOn($model)
        ->withProperties(['attributes' => $attributes, 'old' => $old])
        ->tap(function (Activity $activity) {
            $activity->transaction_date = $this->transactionDate();
        })
        ->log($attributes['log']);
}
function sortList($data, $index)
{
    // dd($data->toArray()['data']);
    usort($data->toArray()['data'], function ($a, $b) use ($index) {
        return customSort($a, $b, $index);
    });
    return $data;
}

function customSort($a, $b, $propertyToCompare)
{
    if ($a[$propertyToCompare] && $b[$propertyToCompare]) {
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
