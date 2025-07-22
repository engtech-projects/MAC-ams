<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subsidiary extends Model
{
    use HasFactory;

    protected $table = 'subsidiary';
    protected $primaryKey = 'sub_id';

    const SUBSIDIARY_OFFICE = 5;
    const DEPRECIATION_LATEST_DATE = '2024-04-30';

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
        'monthly_due',
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
        $date = Carbon::parse($date);
        $subsidiary = Subsidiary::when($categoryId, function ($query) use ($categoryId) {
            $query->where('sub_cat_id', $categoryId);
        })->with(['depreciation_payments' => function ($query) use ($date) {
            $query->when($date, function ($query) use ($date) {
                $month = $date->month;
                $year = $date->year;
                $query->whereDate('date_paid', '<=', $date);
                /* $query->whereMonth('date_paid', '>=', $month)->whereYear('date_paid', $year); */
            });
        }, 'prepaid_expense.prepaid_expense_payments'])
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
        return $branch ? $branch->branch_code . '-' . $branch->branch_name : '';
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
        //return ($subNoDepre > 0) ? (($amount - $salvage) / $subNoDepre) : 0.0;
        return floatval($this->monthly_due ?? 0);
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

    public function depreciation_payments(): HasMany
    {
        return $this->hasMany(DepreciationPayment::class, 'sub_id', 'sub_id');
    }

    public function getTotalDepreciableAmountAttribute()
    {
        return round($this->sub_amount - $this->salvage, 2);
    }
    /* protected function monthlyDue(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
            set: fn(string $value) => strtolower($value),
        );
    } */
    public function getExpensedAttribute()
    {
        return round($this->depreciation_payments()->sum("amount"), 2);
    }
    public function getUnexpensedAttribute()
    {
        return round($this->sub_no_depre != 0 ? $this->total_depreciable_amount - $this->expensed : 0.0, 2);
    }
}
