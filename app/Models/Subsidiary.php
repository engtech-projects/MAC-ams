<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subsidiary extends Model
{
    use HasFactory;

    protected $table = 'subsidiary';
    protected $primaryKey = 'sub_id';

    protected $fillable = [
        'sub_cat_id',
        'sub_name',
        'sub_code',
        'sub_address',
        'sub_tel',
        'sub_acct_no',
        'sub_per_branch',
        'sub_date',
        'sub_amount',
        'sub_no_depre',
        'sub_no_amort',
        'sub_life_used',
        'sub_salvage',
        'sub_date_post'
    ];

    public function subsidiary_category()
    {
        return $this->belongsTo(SubsidiaryCategory::class, 'sub_cat_id');
    }
    public static function fetchBranch()
    {
        $branch = Subsidiary::leftJoin("subsidiary_category", "subsidiary.sub_cat_id", "=", "subsidiary_category.sub_cat_id")
            ->select("subsidiary.*", "subsidiary_category.*")
            ->where("subsidiary_category.sub_cat_id", "=", 48)
            ->get();
        return $branch;
    }

    public function deleteSubsidiary($id) {}
    public function getDepreciation($categoryId, $branch, $date)
    {
        $subsidiary = Subsidiary::when($categoryId, function ($query) use ($categoryId, $branch) {
            $query->where('sub_cat_id', $categoryId);
        })->when(isset($branch), function ($query) use ($branch) {
            $query->where('sub_per_branch', $branch->branch_code);
        })->when(isset($date), function ($query) use ($date) {
            $query->whereDate('sub_date', '<=', $date);
        })->whereHas('subsidiary_category', function ($query) {
            $query->where('sub_cat_type', 'depre');
        })->whereNotNull('sub_per_branch')->get();
        return $subsidiary;
    }
}
