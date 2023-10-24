<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    use HasFactory;

    protected $table = 'account_type';
    protected $primaryKey = 'account_type_id';
    public $timestamps = true;

    protected $fillable = [
        'account_no',
        'account_type',
        'has_opening_balance',
        'account_category_id'
    ];

    public function accountCategory()
    {
        return $this->belongsTo(AccountCategory::class, 'account_category_id');
    }

    public function scopeRevenueAndExpense($query, $types)
    {
        return $query->whereIn('account_category_id', $types);
    }

    public function accounts()
    {
        return $this->hasMany(Accounts::class, 'account_type_id');
    }

    public function getRevenueAndExpense($filter)
    {
        /* $data = journalEntry::with([
            'journalDetails' => function ($query) {
                $query->select(['journal_id', 'account_id', 'journal_details_debit', 'journal_details_credit'])
                    ->with([
                        'account' => function ($query) {
                            $query->select(['account_id', 'account_name', 'account_type_id'])->with(['accountType' => function($query){
                                $query->with('accountCategory');
                            }]);
                        }
                    ]);
            }
        ])
            ->whereBetween('journal_date', [$filter["date_from"], $filter["date_to"]])
            ->get();
        dd($data[0]->journalDetails->toArray()); */
        $data = $this->revenueAndExpense([AccountCategory::REVENUE_TYPE, AccountCategory::EXPENSE_TYPE])
            ->with([
                'accounts' => function ($q) use ($filter) {
                    $q->select('account_id', 'account_type_id')
                        ->whereHas('journalDetails')
                        ->with('journalDetails', function ($query) use ($filter) {
                            $query->select('account_id', 'journal_id', 'journal_details_debit', 'journal_details_credit')
                                ->whereHas('journalEntry', function ($query) use ($filter) {
                                    $query->whereBetween('journal_date', [$filter["date_from"], $filter["date_to"]])
                                        ->with('journalEntry:journal_id');

                                });
                        });
                }
            ])->get();
        return $data;
    }
}
