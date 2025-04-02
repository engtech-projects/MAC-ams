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
        'sub_code',
        'sub_cat_id',
        'sub_name',
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
    public function prepaid_expense()
    {
        return $this->belongsTo(PrepaidExpense::class, 'sub_id', 'sub_id');
    }
    public function subsidiary_accounts()
    {
        return $this->belongsToMany(Accounts::class, 'subsidiary_accounts', 'sub_id', 'account_id');
    }
    public function subsidiary_opening_balance()
    {
        return $this->hasMany(SubsidiaryOpeningBalance::class, 'sub_id');
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


        $subsidiary = Subsidiary::when($categoryId, function ($query) use ($categoryId) {
            $query->where('sub_cat_id', $categoryId);
        })->with(['prepaid_expense.prepaid_expense_payments'])
            ->when(isset($branch), function ($query) use ($branch) {
                $query->where('sub_per_branch', $branch->branch_code);
            })->when(isset($date), function ($query) use ($date) {
                $query->whereDate('sub_date', '<=', $date);
            })->whereHas('subsidiary_category', function ($query) {
                $query->where('sub_cat_type', 'depre');
            })->whereNotNull('sub_per_branch')->with(['subsidiary_accounts'])->get();
        return $subsidiary;
    }

    public function getBranchAttribute()
    {
        $branch = Branch::where('branch_code', $this->sub_per_branch)->first();
        return $branch->branch_code . '-' . $branch->branch_name;
    }

    public function getSalvageAttribute()
    {
        return ($this->sub_amount * $this->sub_salvage) / 100;
    }

    public function getMonthlyAmortAttribute()
    {
        $amount = floatval($this->sub_amount);
        $salvage = floatval($this->salvage);
        $subNoDepre = intval($this->sub_no_depre);

        // Prevent division by zero
        return ($subNoDepre > 0) ? (($amount - $salvage) / $subNoDepre) : 0.0;
    }
    public function getRemAttribute()
    {
        return intVal($this->sub_no_depre) - intVal($this->sub_no_amort);
    }
    public function getDescriptionAttribute()
    {
        return $this->subsidiary_category->description;
    }
    public function getSubCatNameAttribute()
    {
        return $this->subsidiary_category->sub_cat_name;
    }
    /*     public function getSubCatIdAttribute()
    {
        return $this->subsidiary_category->sub_cat_id;
    } */
    public function getExpensedAttribute()
    {
        return floatval($this->monthly_amort) * intVal($this->sub_no_amort);
    }
    public function getUnexpensedAttribute()
    {

        return $this->rem * $this->monthly_amort;
    }
    public function getDueAmortAttribute()
    {
        return $this->rem > 0 ? ($this->monthly_amort) : 0;
    }
    public function getInvAttribute()
    {
        return 0;
    }
    public function getNoAttribute()
    {
        return 0;
    }
}