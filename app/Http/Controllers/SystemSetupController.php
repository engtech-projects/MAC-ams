<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Company;
use App\Models\Currency;
use App\Models\AccessList;
use App\Models\Accounting;
use App\Models\JournalBook;
use Illuminate\Support\Str;
use App\Models\PersonalInfo;

use Illuminate\Http\Request;

use App\Models\CompanyAddress;
use App\Models\Accessibilities;
use App\Models\Branch;
use App\Models\SubsidiaryCategory;


class SystemSetupController extends MainController
{
    public function index()
    {
        return view('systemSetup.systemSetup')->with([
            'title'     => 'MAC-AMS | System Setup',
            'nav'         => ['settings', 'general'],
            'company'     => Company::with('address')->first(),
            'accessLists' => AccessList::with('sub_module_list')->get(),
            'journalBookList' => JournalBook::get(),
            'subsidiaryCategories' => SubsidiaryCategory::get(),
            'currencies' => Currency::all(),
            'accounting' => Accounting::first(),
            'branch' => Branch::all()
        ]);

        return view('systemSetup.systemSetup', $data);
    }

    public function companyUpdate(Request $request)
    {
        $company = null;
        $address = null;
        if (!Company::first()) {
            $company = new Company;
        } else {
            $company = Company::first();
        }
        $companyReplicate = $company->exists ? $company->replicate() : null;
        $company->logo = '';
        $company->company_name = $request->company_name;
        $company->company_email = $request->company_email;
        $company->phone_number = $request->phone_number;
        $company->contact_number = $request->contact_number;
        $company->save();
        if (!CompanyAddress::first()) {
            $address = new CompanyAddress;
        } else {
            $address = CompanyAddress::first();
        }
        $addressReplicate = $address->exists ? $address->replicate() : null;
        $address->street = $request->address;
        $address->city = $request->city;
        $address->province = $request->town;
        $address->zip_code = $request->postal_code;
        $address->country = $request->country;
        $address->company_id = $company->company_id;
        $address->save();

        $allChanges = [];
        $allOld = [];
        if ($companyReplicate) {
            $companyChanges = getChanges($company, $companyReplicate);
            unset($companyChanges['attributes']['updated_at'], $companyChanges['old']['updated_at']);
            if (!empty($companyChanges['attributes'])) {
                $allChanges['company'] = $companyChanges['attributes'];
                $allOld['company'] = $companyChanges['old'];
            }
        } else {
            $allChanges['company'] = $company->toArray();
            $allOld['company'] = [];
        }
        if ($addressReplicate) {
            $addressChanges = getChanges($address, $addressReplicate);
            unset($addressChanges['attributes']['updated_at'], $addressChanges['old']['updated_at']);
            if (!empty($addressChanges['attributes'])) {
                $allChanges['address'] = $addressChanges['attributes'];
                $allOld['address'] = $addressChanges['old'];
            }
        } else {
            $allChanges['address'] = $address->toArray();
            $allOld['address'] = [];
        }
        if (!empty($companyChanges['attributes'])) {
            activity("System Setup")->event("updated")->performedOn($company)
                ->withProperties([
                'model_snapshot' => [
                    'company' => $company->toArray(),
                    'address' => $address->toArray()
                ],
                'attributes' => $allChanges,
                'old' => $allOld
                ])
                ->log("Company Settings - Update");
        }

        Session::flash('success', 'Company info updated successfully.');
        return redirect(route('systemSetup'));
    }

    public function accountingUpdate(Request $request)
    {
        $accounting = null;
        $replicate = null;
        if (!Accounting::first()) {
            $accounting = new Accounting;
        } else {
            $accounting = Accounting::first();
            $replicate = $accounting->replicate();
        }
        $accounting->start_date = $request->start_date;
        $accounting->end_date = $request->end_date;
        $accounting->method = $request->method;
        $accounting->save();

        $changes = getChanges($accounting, $replicate);
        unset($changes['attributes']['updated_at'], $changes['old']['updated_at']);
        if (!empty($changes['attributes'])) {
            activity("System Setup")->event("updated")->performedOn($accounting)
                ->withProperties([
                    'model_snapshot' => $accounting->toArray(),
                    'attributes' => $changes['attributes'],
                    'old' => $changes['old']])
                ->log("Accounting - Update");
        }
        Session::flash('success', 'Accounting info updated successfully.');
        return redirect(route('systemSetup'));
    }


    public function journalBookCreateOrUpdate(Request $request)
    {
        $book_id = $request->bookId;
        $journ = new JournalBook;
        $status = $journ->checkBookCode($request->book_code, $book_id);


        if (empty($book_id)) {
            if (!$status) {
                $book = new JournalBook;
                $book->book_code = $request->book_code;
                $book->book_name = $request->book_name;
                $book->book_src = $request->book_src;
                $book->book_ref = $request->book_ref;
                $book->book_head = $request->book_head;
                $book->book_flag = $request->book_flag;
                $book->save();
                activity("System Setup")->event("created")->performedOn($book)
                    ->withProperties(['model_snapshot' => $book->toArray()])
                    ->log("Journal Book - Create");
                return json_encode(['status' => 'create', 'book_id' => $book->book_id]);
            } else {
                return json_encode(['status' => 'book_code_duplicate', 'book_id' => '']);
            }
        } else {
            if (!$status) {
                $book = JournalBook::find($book_id);
                $replicate = $book->replicate();
                $book->book_code = $request->book_code;
                $book->book_name = $request->book_name;
                $book->book_src = $request->book_src;
                $book->book_ref = $request->book_ref;
                $book->book_head = $request->book_head;
                $book->book_flag = $request->book_flag;
                $book->save();

                $changes = getChanges($book, $replicate);
                unset($changes['attributes']['updated_at'], $changes['old']['updated_at']);
                if (!empty($changes['attributes'])) {
                    activity("System Setup")->event("updated")->performedOn($book)
                        ->withProperties([
                            'model_snapshot' => $book->toArray(),
                            'attributes' => $changes['attributes'], 
                            'old' => $changes['old']
                        ])
                        ->log("Journal Book - Update");
                }
                return json_encode(['status' => 'update', 'book_id' => $book->book_id]);
            } else {
                return json_encode(['status' => 'book_code_duplicate', 'book_id' => '']);
            }
        }
    }

    public function fetchBookInfo(Request $request)
    {
        $book_id = $request->bookId;
        return json_encode(JournalBook::where('book_id', $book_id)->get());
    }
    public function deleteBook(Request $request)
    {
        $book_id = $request->bookId;
        $book = JournalBook::find($book_id);
        if ($book) {
            activity("System Setup")->event("deleted")->performedOn($book)
                ->withProperties([
                    'model_snapshot' => $book->toArray(),
                    'old' => $book->toArray()
                ])
                ->log("Journal Book - Delete");
            $deleted = $book->delete();
            return json_encode($deleted);
        }
        return json_encode(false);
    }

    public function userMasterFileCreateOrUpdate(Request $request)
    {
        $user_id = $request->userId;
        $query = User::where('username', $request->username);
        if ($user_id != '') {
            $query->where('id', '!=', $user_id);
        }

        if ($query->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Username already exists'
            ], 422);
        }

        $branch_ids = $request->branch_ids ?? [];
        $accessibility_ids = $request->accessibility_ids ?? [];

        if (empty($branch_ids)) {
            return response()->json([
                'status' => 'error',
                'message' => 'At least one branch must be selected'
            ], 422);
        }

        if ($user_id == '') {
            $person = new PersonalInfo;
            $person->fname = $request->fname;
            $person->mname = $request->mname;
            $person->lname = $request->lname;
            $person->gender = $request->gender;
            $person->displayname = $request->displayname;
            $person->email_address = $request->email;
            $person->phone_number = $request->phone_number;
            $person->save();

            $user = new User;
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->status = 'active';
            $user->role_id = $request->role_id;
            $user->salt = Str::random(10);
            $user->personal_info_id = $person->personal_info_id;
            $user->save();

            if (!empty($branch_ids)) {
                $user->userBranch()->attach($branch_ids);
            }
            if (!in_array(174, $accessibility_ids)) {
                array_unshift($accessibility_ids, 174);
            }
            if (!empty($accessibility_ids)) {
                foreach ($accessibility_ids as $sml_id) {
                    Accessibilities::create([
                        'user_id' => $user->id,
                        'sml_id' => $sml_id,
                        'date_created' => Carbon::now()
                    ]);
                }
            }
            $user->load('userBranch');
            $branchesData = $user->userBranch->map(function($branch) {
                return [
                    'branch_id' => $branch->branch_id,
                    'branch_name' => $branch->branch_name ?? $branch->name
                ];
            });
            $accessibilitiesData = Accessibilities::where('user_id', $user->id)
                ->get()
                ->map(function($accessibility) {
                    return [
                        'sml_id' => $accessibility->sml_id,
                    ];
            });
            $userSnapshot = $user->getAttributes();
            $personSnapshot = $person->getAttributes();
            $modelSnapshot = array_merge($userSnapshot, [
                'personal_info' => $personSnapshot,
                'branches' => $branchesData->toArray(),
                'accessibilities' => $accessibilitiesData->toArray()
            ]);
            activity("System Setup")->event("created")->performedOn($user)
                ->withProperties([
                    'model_snapshot' => $modelSnapshot
                ])
                ->log("User Master File - Create");

            return json_encode('create');
        } else {
            $user = User::find($user_id);
            $replicate = $user->replicate();
            $oldPerson = PersonalInfo::where('personal_info_id', $user->personal_info_id)->first();
            $oldPersonData = $oldPerson ? $oldPerson->getAttributes() : [];
            $oldBranches = $user->userBranch->map(function($branch) {
                return [
                    'branch_id' => $branch->branch_id,
                    'branch_name' => $branch->branch_name ?? $branch->name
                ];
            })->toArray();
            $oldAccessibilities = Accessibilities::where('user_id', $user->id)
                ->get()
                ->map(function($accessibility) {
                    return [
                        'sml_id' => $accessibility->sml_id,
                    ];
            })->toArray();
            $user->username = $request->username;
            if (!empty($request->password)) {
                $user->password = bcrypt($request->password);
            }
            $user->status = $request->status;
            $user->role_id = $request->role_id;
            $user->save();
            $user->userBranch()->sync($branch_ids);
            Accessibilities::where('user_id', $user->id)->delete();
            if (!in_array(174, $accessibility_ids)) {
                array_unshift($accessibility_ids, 174);
            }
            if (!empty($accessibility_ids)) {
                foreach ($accessibility_ids as $sml_id) {
                    Accessibilities::create([
                        'user_id' => $user->id,
                        'sml_id' => $sml_id,
                        'date_created' => Carbon::now()
                    ]);
                }
            }
            PersonalInfo::where('personal_info_id', $user->personal_info_id)->update([
                'fname' => $request->fname,
                'mname' => $request->mname,
                'lname' => $request->lname,
                'gender' => $request->gender,
                'displayname' => $request->displayname,
                'email_address' => $request->email,
                'phone_number' => $request->phone_number
            ]);
            $changes = getChanges($user, $replicate);
            unset($changes['attributes']['updated_at'], $changes['old']['updated_at']);
            $user->load('userBranch');
            $newPerson = PersonalInfo::where('personal_info_id', $user->personal_info_id)->first();
            $newPersonData = $newPerson ? $newPerson->getAttributes() : [];
            
            $newBranches = $user->userBranch->map(function($branch) {
                return [
                    'branch_id' => $branch->branch_id,
                    'branch_name' => $branch->branch_name ?? $branch->name
                ];
            })->toArray();
            $newAccessibilities = Accessibilities::where('user_id', $user->id)
                ->get()
                ->map(function($accessibility) {
                    return [
                        'sml_id' => $accessibility->sml_id,
                    ];
            })->toArray();
            $personChanged = false;
            $personChanges = [];
            foreach ($newPersonData as $key => $value) {
                if ($key !== 'updated_at' && isset($oldPersonData[$key]) && $oldPersonData[$key] != $value) {
                    $personChanged = true;
                    $personChanges[$key] = $value;
                }
            }
            $branchesChanged = $oldBranches != $newBranches;
            $accessibilitiesChanged = $oldAccessibilities != $newAccessibilities;
            $userSnapshot = $user->getAttributes();
            $modelSnapshot = array_merge($userSnapshot, [
                'personal_info' => $newPersonData,
                'branches' => $newBranches,
                'accessibilities' => $newAccessibilities
            ]);
            if (!empty($changes['attributes']) || $personChanged || $branchesChanged || $accessibilitiesChanged) {
                $properties = [
                    'model_snapshot' => $modelSnapshot,
                    'attributes' => $changes['attributes'], 
                    'old' => $changes['old']
                ];
                if ($personChanged) {
                    $properties['attributes']['personal_info'] = $personChanges;
                    $oldPersonChanges = [];
                    foreach ($personChanges as $key => $value) {
                        $oldPersonChanges[$key] = $oldPersonData[$key];
                    }
                    $properties['old']['personal_info'] = $oldPersonChanges;
                }
                if ($branchesChanged) {
                    $properties['attributes']['branches'] = $newBranches;
                    $properties['old']['branches'] = $oldBranches;
                }
                if ($accessibilitiesChanged) {
                    $properties['attributes']['accessibilities'] = $newAccessibilities;
                    $properties['old']['accessibilities'] = $oldAccessibilities;
                }
                activity("System Setup")->event("updated")->performedOn($user)
                    ->withProperties($properties)
                    ->log("User Master File - Update");
            }

            return json_encode('update');
        }
    }
    public function categoryFileCreateOrUpdate(Request $request)
    {
        $cat_id = $request->catId;
        $isDuplicate = SubsidiaryCategory::where('sub_cat_code', $request->sub_cat_code)
            ->when($cat_id, function($query) use ($cat_id) {
                return $query->where('sub_cat_id', '!=', $cat_id);
            })
            ->exists();
        if ($isDuplicate) {
            return json_encode([
                'status' => 'sub_cat_code_duplicate', 
                'message' => 'Category code already exists. Please enter a unique code.'
            ]);
        }
        if (empty($cat_id)) {
            $cat = new SubsidiaryCategory;
            $cat->sub_cat_code = $request->sub_cat_code;
            $cat->sub_cat_name = $request->sub_cat_name;
            $cat->sub_cat_type = $request->sub_cat_type;
            $cat->description = $request->cat_description;
            $cat->save();

            $categoryAccounts = [
                $request->account_id => ['transaction_type' => 'credit'],
                $request->account_id_debit => ['transaction_type' => 'debit'],
            ];
            $cat->accounts()->attach($categoryAccounts);
            $cat->load('accounts');
            $accountsData = $cat->accounts->map(function($account) {
                return [
                    'account_id' => $account->account_id,
                    'account_name' => $account->account_name,
                    'transaction_type' => $account->pivot->transaction_type
                ];
            });
            $modelSnapshot = $cat->getAttributes();
            activity("System Setup")->event("created")->performedOn($cat)
                ->withProperties([
                    'model_snapshot' => array_merge($modelSnapshot, [
                            'accounts' => $accountsData->toArray()
                        ])
                ])
                ->log("Category File - Create");
            return json_encode(['status' => 'create', 'sub_cat_id' => $cat->sub_cat_id]);
        } else {
            $cat = SubsidiaryCategory::find($cat_id);
            $replicate = $cat->replicate();
            $oldAccounts = $cat->accounts->map(function($account) {
                return [
                    'account_id' => $account->account_id,
                    'account_name' => $account->account_name,
                    'transaction_type' => $account->pivot->transaction_type
                ];
            })->toArray();
            $cat->sub_cat_code = $request->sub_cat_code;
            $cat->sub_cat_name = $request->sub_cat_name;
            $cat->sub_cat_type = $request->sub_cat_type;
            $cat->description = $request->cat_description;
            $cat->save();
            
            $categoryAccounts = [
                $request->account_id => ['transaction_type' => 'credit'],
                $request->account_id_debit => ['transaction_type' => 'debit'],
            ];
            $cat->accounts()->sync($categoryAccounts);
            $categoryAccounts = [
                $request->account_id => ['transaction_type' => 'credit'],
                $request->account_id_debit => ['transaction_type' => 'debit'],
            ];
            $changes = getChanges($cat, $replicate);
            unset($changes['attributes']['updated_at'], $changes['old']['updated_at']);
            $cat->load('accounts');
            $newAccounts = $cat->accounts->map(function($account) {
                return [
                    'account_id' => $account->account_id,
                    'account_name' => $account->account_name,
                    'transaction_type' => $account->pivot->transaction_type
                ];
            })->toArray();
            $modelSnapshot = $cat->getAttributes();
            $accountsChanged = $oldAccounts != $newAccounts;
            if (!empty($changes['attributes']) || $accountsChanged) {
                $properties = [
                    'model_snapshot' => array_merge($modelSnapshot, ['accounts' => $newAccounts]),
                    'attributes' => $changes['attributes'], 
                    'old' => $changes['old']
                ];
                if ($accountsChanged) {
                    $properties['attributes']['accounts'] = $newAccounts;
                    $properties['old']['accounts'] = $oldAccounts;
                }
                
                activity("System Setup")->event("updated")->performedOn($cat)
                    ->withProperties($properties)
                    ->log("Category File - Update");
            }
            return json_encode(['status' => 'update', 'sub_cat_id' => $cat->sub_cat_id]);
        }
    }

    public function fetchCategoryInfo(Request $request)
    {
        $cat_id = $request->catId;
        
        $category = SubsidiaryCategory::with('accounts')
            ->where('sub_cat_id', $cat_id)
            ->first();
        
        if ($category) {
            $accounts = $category->accounts->groupBy('pivot.transaction_type');
            
            return json_encode([[
                'sub_cat_id' => $category->sub_cat_id,
                'sub_cat_code' => $category->sub_cat_code,
                'sub_cat_name' => $category->sub_cat_name,
                'sub_cat_type' => $category->sub_cat_type,
                'description' => $category->description,
                'account_credit' => $accounts->get('credit')?->first()?->account_id,
                'account_debit' => $accounts->get('debit')?->first()?->account_id,
            ]]);
        }
        
        return json_encode([]);
    }

    public function deleteCategoryFile(Request $request)
    {
        $cat_id = $request->catId;
        $category = SubsidiaryCategory::with('accounts')->find($cat_id);
        if (!$category) {
            return json_encode(['status' => 'error', 'message' => 'Category not found.']);
        }
        if ($category->subsidiaries()->exists()) {
            return json_encode([
                'status' => 'error', 
                'message' => 'Cannot delete. This category is already used in other records.'
            ]);
        }
        $accountsData = $category->accounts->map(function($account) {
            return [
                'account_id' => $account->account_id,
                'account_name' => $account->account_name,
                'transaction_type' => $account->pivot->transaction_type
            ];
        });
        $modelSnapshot = $category->getAttributes();
        activity("System Setup")->event("deleted")->performedOn($category)
            ->withProperties([
                'model_snapshot' => array_merge($modelSnapshot, [
                        'accounts' => $accountsData->toArray()
                    ]),
                'old' => array_merge($modelSnapshot, [
                        'accounts' => $accountsData->toArray()
                    ])
            ])
            ->log("Category File - Delete");

        $category->accounts()->detach();
        $category->delete();
        return json_encode(['status' => 'success', 'message' => 'Successfully deleted.']);
    }

    public function searchAccount(Request $request)
    {
        $name = strtolower(trim($request->name));

        if (empty($name)) {
            return response()->json([]);
        }

        $searchTerms = array_filter(explode(' ', $name));
        $query = PersonalInfo::query();

        // For each search term, it must match at least one name field
        foreach ($searchTerms as $term) {
            $query->where(function ($q) use ($term) {
                $q->whereRaw("LOWER(fname) LIKE ?", ["%{$term}%"])
                    ->orWhereRaw("LOWER(mname) LIKE ?", ["%{$term}%"])
                    ->orWhereRaw("LOWER(lname) LIKE ?", ["%{$term}%"])
                    ->orWhereRaw("LOWER(displayname) LIKE ?", ["%{$term}%"]);
            });
        }

        $accounts = $query->with('userInfo')
            ->orderBy('lname')
            ->get();
        return response()->json($accounts);
    }
    public function fetchInfo(Request $request)
    {
        $personalInfo = PersonalInfo::where('personal_info_id', $request->p_id)->first();
        if (!$personalInfo) {
            return response()->json(['error' => 'Personal info not found'], 404);
        }
        $response = [
            'fname' => $personalInfo->fname,
            'mname' => $personalInfo->mname,
            'lname' => $personalInfo->lname,
            'gender' => $personalInfo->gender,
            'displayname' => $personalInfo->displayname,
            'email_address' => $personalInfo->email_address,
            'phone_number' => $personalInfo->phone_number,
            'user_info' => null
        ];
        $user = User::where('personal_info_id', $request->p_id)
            ->with(['userBranch']) 
            ->first();
        if ($user) {
            $accessibilities = Accessibilities::where('user_id', $user->id)
                ->get()
                ->map(function($accessibility) {
                    return [
                        'sml_id' => $accessibility->sml_id,
                        'date_created' => $accessibility->date_created
                    ];
                });
            $response['user_info'] = [
                'id' => $user->id,
                'username' => $user->username,
                'status' => $user->status,
                'role_id' => $user->role_id,
                'user_branch' => $user->userBranch->map(function($branch) {
                    return [
                        'branch_id' => $branch->branch_id,
                        'branch_name' => $branch->branch_name ?? $branch->name
                    ];
                })->toArray(),
                'accessibilities' => $accessibilities->toArray()
            ];
        }
        return response()->json($response);
    }

    public function currencyUpdate(Request $request)
    {
        Currency::where('status', '=', 'active')->update(['status' => '']);
        $currency = Currency::find($request->currency);
        $replicate = $currency->replicate();
        $currency->status = 'active';
        $currency->save();
        $changes = getChanges($currency, $replicate);
        unset($changes['attributes']['updated_at'], $changes['old']['updated_at']);
        if (!empty($changes['attributes'])) {
            activity("System Setup")->event("updated")->performedOn($currency)
                ->withProperties([
                    'model_snapshot' => $currency->toArray(),
                    'attributes' => $changes['attributes'],
                    'old' => $changes['old']])
                ->log("Currency - Update");
        }
        Session::flash('success', 'Currency updated successfully.');
        return redirect(route('systemSetup'));
    }
}
