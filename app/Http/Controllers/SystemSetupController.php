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
        $address->street = $request->address;
        $address->city = $request->city;
        $address->province = $request->town;
        $address->zip_code = $request->postal_code;
        $address->country = $request->country;
        $address->company_id = $company->company_id;
        $address->save();

        Session::flash('success', 'Company info updated successfully.');
        return redirect(route('systemSetup'));
    }

    public function accountingUpdate(Request $request)
    {
        $accounting = null;
        if (!Accounting::first()) {
            $accounting = new Accounting;
        } else {
            $accounting = Accounting::first();
        }
        $accounting->start_date = $request->start_date;
        $accounting->end_date = $request->end_date;
        $accounting->method = $request->method;
        $accounting->save();

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
                return json_encode(['status' => 'create', 'book_id' => $book->book_id]);
            } else {
                return json_encode(['status' => 'book_code_duplicate', 'book_id' => '']);
            }
        } else {
            if (!$status) {
                $book = JournalBook::find($book_id);
                $book->book_code = $request->book_code;
                $book->book_name = $request->book_name;
                $book->book_src = $request->book_src;
                $book->book_ref = $request->book_ref;
                $book->book_head = $request->book_head;
                $book->book_flag = $request->book_flag;
                $book->save();
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
        return json_encode(JournalBook::find($book_id)->delete());
    }

    public function userMasterFileCreateOrUpdate(Request $request)
    {
        $user_id = $request->userId;

        $branch = [
            "branch_id" => $request->branch_id
        ];

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
            $user->role_id = '1';
            $user->salt = Str::random(10);
            $user = $person->userInfo()->save($user);
            $user->userBranch()->attach($branch);

            return json_encode('create');
        } else {
            $user = User::find($user_id);
            $user->username = $request->username;
            $user->password = bcrypt($request->password);
            $user->userBranch()->attach($branch);
            $user->push();
            PersonalInfo::where('personal_info_id', $user->personal_info_id)->update([
                'fname' => $request->fname,
                'mname' => $request->mname,
                'lname' => $request->lname,
                'gender' => $request->gender,
                'displayname' => $request->displayname,
                'email_address' => $request->email,
                'phone_number' => $request->phone_number
            ]);
            return json_encode('update');
        }
    }
    public function categoryFileCreateOrUpdate(Request $request)
    {
        $cat_id = $request->catId;
        if (count(SubsidiaryCategory::where('sub_cat_id', $request->cat_id)->get()) > 0) {
            return json_encode(['status' => 'error', 'message' => 'Category File Code Already Exist']);
        }

        if ($cat_id == '') {
            $cat = new SubsidiaryCategory;
            $cat->sub_cat_code = $request->sub_cat_code;
            $cat->sub_cat_name = $request->sub_cat_name;
            $cat->sub_cat_type = $request->sub_cat_type;
            $cat->description = $request->cat_description;

            $cat->save();

            return json_encode(['status' => 'create', 'sub_cat_id' => $cat->sub_cat_id]);
        } else {
            $cat = SubsidiaryCategory::find($cat_id);
            $cat->sub_cat_code = $request->sub_cat_code;
            $cat->sub_cat_name = $request->sub_cat_name;
            $cat->sub_cat_type = $request->sub_cat_type;
            $cat->description = $request->cat_description;

            $cat->save();
            return json_encode(['status' => 'update', 'sub_cat_id' => $cat->sub_cat_id]);
        }
    }

    public function fetchCategoryInfo(Request $request)
    {
        $cat_id = $request->catId;
        return json_encode(SubsidiaryCategory::where('sub_cat_id', $cat_id)->get());
    }

    public function deleteCategoryFile(Request $request)
    {
        $cat_id = $request->catId;
        return json_encode(SubsidiaryCategory::find($cat_id)->delete());
    }

    public function userMasterFileCreateOrUpdateAccessibility(Request $request)
    {
        if (Accessibilities::where(['user_id' => $request->user_id, 'sml_id' => $request->sml_id])->count() > 0) {
            Accessibilities::where(['user_id' => $request->user_id, 'sml_id' => $request->sml_id])->delete();
            return 'removed';
        } else {
            Accessibilities::create(['user_id' => $request->user_id, 'sml_id' => $request->sml_id, 'date_created' => Carbon::now()]);
            return 'added';
        }
    }
    public function searchAccount(Request $request)
    {
        return json_encode(PersonalInfo::where(DB::raw("CONCAT(lname, ', ',fname, ' (', mname, ')' )"), 'LIKE', "%" . $request->name . "%")
            ->with('userInfo')->orderBy('lname')->limit(10)->get());
    }
    public function fetchInfo(Request $request)
    {
        return json_encode(PersonalInfo::where('personal_info_id', $request->p_id)
            ->with('userInfo')->orderBy('lname')->limit(10)->get());
    }

    public function currencyUpdate(Request $request)
    {
        Currency::where('status', '=', 'active')->update(['status' => '']);
        $currency = Currency::find($request->currency);
        $currency->status = 'active';
        $currency->save();
        Session::flash('success', 'Currency updated successfully.');
        return redirect(route('systemSetup'));
    }
}
