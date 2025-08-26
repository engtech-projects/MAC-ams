<?php

namespace Database\Seeders;

use Illuminate\Support\Arr;
use App\Models\Accessibilities;
use App\Models\SubModuleList;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SubModuleListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sml_json = '
            [
                {
                "sml_id": 122,
                "al_id": 6,
                "route": "login",
                "description": "System Login",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 123,
                "al_id": 6,
                "route": "logout",
                "description": "System Logout",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 124,
                "al_id": 6,
                "route": "authenticate",
                "description": "System Authentication",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 125,
                "al_id": 8,
                "route": "accounts",
                "description": "Chart of Accounts Home",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 126,
                "al_id": 8,
                "route": "accounts\/create",
                "description": "Chart of Accounts (Create)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 127,
                "al_id": 8,
                "route": "accounts-datatable",
                "description": "Chart of Accounts (Datatable)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 128,
                "al_id": 8,
                "route": "set-status",
                "description": "Chart of Accounts (Set Status)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 156,
                "al_id": 5,
                "route": "systemSetup",
                "description": "System Setup",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 157,
                "al_id": 5,
                "route": "systemSetup\/general\/company\/update",
                "description": "Company Update",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 158,
                "al_id": 5,
                "route": "systemSetup\/general\/accounting\/update",
                "description": "Accounting Update",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 159,
                "al_id": 5,
                "route": "systemSetup\/general\/currency\/update",
                "description": "Currency Update",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 174,
                "al_id": 7,
                "route": "dashboard",
                "description": "Dashboard Home",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 175,
                "al_id": 5,
                "route": "companySettings",
                "description": "Company Settings (Panel)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 178,
                "al_id": 5,
                "route": "JournalBook",
                "description": "JournalBook (Panel)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 179,
                "al_id": 5,
                "route": "UserMasterFile",
                "description": "UserMasterFile (Panel)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 180,
                "al_id": 5,
                "route": "accounting",
                "description": "accounting (Panel)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 181,
                "al_id": 5,
                "route": "currency",
                "description": "currency (Panel)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 187,
                "al_id": 5,
                "route": "systemSetup\/general\/userMasterFile\/createOrUpdate",
                "description": "User Master FIle (Create or Update)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 189,
                "al_id": 5,
                "route": "systemSetup\/general\/usermasterfile\/searchAccount",
                "description": "User Master File (Search Account)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 191,
                "al_id": 5,
                "route": "systemSetup\/general\/usermasterfile\/fetchInfo",
                "description": "User Master File (Fetch Information)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 193,
                "al_id": 5,
                "route": "systemSetup\/general\/usermasterfile\/createOrUpdateAccessibility",
                "description": "User Master File ( Update Accessibility)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 195,
                "al_id": 5,
                "route": "systemSetup\/general\/usermasterfile\/createOrUpdate",
                "description": "User Master File ( Create User or Update User)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 197,
                "al_id": 5,
                "route": "CategoryFile",
                "description": "Category File (Panel)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 201,
                "al_id": 5,
                "route": "subsidiary",
                "description": "Subsidiary Panel",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 202,
                "al_id": 5,
                "route": "systemSetup\/general\/journalBook\/createOrUpdate",
                "description": "Journal Book (Create or Update)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 203,
                "al_id": 5,
                "route": "systemSetup\/general\/journalBook\/fetchBookInfo",
                "description": "Journal Book (Fetch Book Information) ",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 204,
                "al_id": 5,
                "route": "systemSetup\/general\/journalBook\/deleteBook",
                "description": "Journal Book (Delete Book Record)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 205,
                "al_id": 5,
                "route": "systemSetup\/general\/categoryFile\/createOrUpdate",
                "description": "Subsidiary Category File (Create or Update)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 206,
                "al_id": 5,
                "route": "systemSetup\/general\/categoryFile\/fetchCategoryInfo",
                "description": "Subsidiary Category File (Fetch Category Info)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 207,
                "al_id": 5,
                "route": "systemSetup\/general\/categoryFile\/deleteCategory",
                "description": "Subsidiary Category File (Delete Category)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 208,
                "al_id": 4,
                "route": "reports",
                "description": "Report (Panel)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 209,
                "al_id": 4,
                "route": "reports\/subsidiaryledger",
                "description": "Report (Subsidiary Ledger Panel)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 211,
                "al_id": 4,
                "route": "reports\/generalLedger",
                "description": "Report (General Ledger)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 212,
                "al_id": 4,
                "route": "reports\/trialBalance",
                "description": "Report (Trial Balance)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 213,
                "al_id": 4,
                "route": "reports\/incomeStatement",
                "description": "Report (Income Statement)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 214,
                "al_id": 4,
                "route": "reports\/bankReconcillation",
                "description": "Report (Bank Reconcillation)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 215,
                "al_id": 4,
                "route": "reports\/cashPosition",
                "description": "Report (Cash Position)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 216,
                "al_id": 4,
                "route": "reports\/cashTransactionBlotter",
                "description": "Report (Cash Transaction Blotter)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 217,
                "al_id": 9,
                "route": "journal\/journalEntryList",
                "description": "Journal Entry List",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 219,
                "al_id": 9,
                "route": "journal\/journalEntry",
                "description": "Journal Entry ",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 220,
                "al_id": 4,
                "route": "reports\/cheque",
                "description": "Cheque",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 221,
                "al_id": 4,
                "route": "reports\/postDatedCheque",
                "description": "Post-Dated Cheque",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 223,
                "al_id": 8,
                "route": "accounts\/getAccountTypeContent",
                "description": "Chart of Account  (Get Type Content)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 225,
                "al_id": 8,
                "route": "accounts\/saveType",
                "description": "Accounts VIew Type Modal",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 226,
                "al_id": 8,
                "route": "accounts\/saveClass",
                "description": "Accounts VIew ClassModal",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 227,
                "al_id": 8,
                "route": "accounts\/createNewType",
                "description": "Chart of Account save Type",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 228,
                "al_id": 8,
                "route": "accounts\/createNewClass",
                "description": "Chart of Account save Class",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 232,
                "al_id": 4,
                "route": "reports\/subsidiarySaveorEdit",
                "description": "Subsidiary Create or Update",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 234,
                "al_id": 10,
                "route": "sales",
                "description": "sales",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 235,
                "al_id": 10,
                "route": "sales\/store",
                "description": "sales",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 236,
                "al_id": 10,
                "route": "sales-datatable",
                "description": "sales",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 237,
                "al_id": 10,
                "route": "getsales",
                "description": "sales",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 238,
                "al_id": 10,
                "route": "sales\/invoice",
                "description": "sales",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 239,
                "al_id": 10,
                "route": "sales\/create\/invoice",
                "description": "sales",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 240,
                "al_id": 10,
                "route": "sales\/store",
                "description": "sales",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 241,
                "al_id": 10,
                "route": "sales-datatable",
                "description": "sales",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 242,
                "al_id": 10,
                "route": "getsales",
                "description": "sales",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 244,
                "al_id": 10,
                "route": "expenses",
                "description": "expenses",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 245,
                "al_id": 11,
                "route": "expenses\/store",
                "description": "expenses",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 246,
                "al_id": 11,
                "route": "expenses\/void",
                "description": "expenses",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 247,
                "al_id": 11,
                "route": "expense-datatable",
                "description": "expenses",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 248,
                "al_id": 11,
                "route": "create\/expense",
                "description": "expenses",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 250,
                "al_id": 11,
                "route": "create\/bill",
                "description": "expenses",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 255,
                "al_id": 4,
                "route": "reports\/subsidiaryViewInfo",
                "description": "Report (Subsidiary Fetch Information)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 256,
                "al_id": 4,
                "route": "reports\/subsidiaryDelete",
                "description": "Report (Subsidiary Delete)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 259,
                "al_id": 9,
                "route": "journal",
                "description": "Journal VIew (NOT INCLUDE)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 260,
                "al_id": 9,
                "route": "journal\/saveJournalEntry",
                "description": "Journal (save Journal Entry)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 262,
                "al_id": 9,
                "route": "journal\/saveJournalEntryDetails",
                "description": "Journal Entry (save Journal Entry Details)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 263,
                "al_id": 9,
                "route": "journal\/JournalEntryFetch",
                "description": "Journal (Fetch Journal Information)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 265,
                "al_id": 9,
                "route": "journal\/JournalEntryPostUnpost",
                "description": "Journal (Set Unposted to Posted)",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 267,
                "al_id": 9,
                "route": "journal\/JournalEntryEdit",
                "description": "Journal Edit",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 268,
                "al_id": 6,
                "route": "user\/profile",
                "description": "User Profile ",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 269,
                "al_id": 9,
                "route": "journal\/JournalEntryCancel",
                "description": "Journal Entry Cancel",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 270,
                "al_id": 4,
                "route": "reports\/journalledger",
                "description": "Journal Ledger",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 271,
                "al_id": 9,
                "route": "journal\/searchJournalEntry",
                "description": "Search Journal",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 272,
                "al_id": 9,
                "route": "reports\/revenue-minus-expense",
                "description": "Income Minus Expense",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 273,
                "al_id": 4,
                "route": "reports\/cashTransactionBlotter",
                "description": "Reports Cash Blotter",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 274,
                "al_id": 4,
                "route": "reports\/showTransactionBlotter",
                "description": "View Cash Blotter",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 275,
                "al_id": 4,
                "route": "reports\/bank-reconciliation",
                "description": "View Bank Reconciliation",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 276,
                "al_id": 4,
                "route": "reports\/subsidiary-ledger",
                "description": "View Subsidiary Ledger Reports",
                "created_at": "12\/01\/2023",
                "updated_at": "12\/01\/2023"
                },
                {
                "sml_id": 277,
                "al_id": 4,
                "route": "reports\/balance-sheet",
                "description": "Balance Sheet",
                "created_at": "03\/15\/2024",
                "updated_at": "03\/15\/2024"
                },
                {
                "sml_id": 278,
                "al_id": 4,
                "route": "reports\/monthly-depreciation-report",
                "description": "Monthly Depreciation",
                "created_at": "09\/18\/2024",
                "updated_at": "09\/18\/2024"
                },
                {
                "sml_id": 279,
                "al_id": 4,
                "route": "reports\/monthly-depreciation-report-search",
                "description": "Monthly Depreciation Search",
                "created_at": "11\/05\/2024",
                "updated_at": "11\/05\/2024"
                },
                {
                "sml_id": 280,
                "al_id": 4,
                "route": "reports\/monthly-depreciation-report-post",
                "description": "Monthly Depreciation Post",
                "created_at": "11\/05\/2024",
                "updated_at": "11\/05\/2024"
                },
                {
                "sml_id": 281,
                "al_id": 4,
                "route": "reports\/closing-period",
                "description": "Closing Period",
                "created_at": "04\/23\/2025",
                "updated_at": "04\/23\/2025"
                },
                {
                "sml_id": 282,
                "al_id": 4,
                "route": "reports\/monthly-depreciation\/search",
                "description": "Monthly Depreciation - Search"
                },
                {
                "sml_id": 283,
                "al_id": 4,
                "route": "reports\/monthly-depreciation\/post",
                "description": "Monthly Depreciation - Post"
                },
                {
                "sml_id": 284,
                "al_id": 4,
                "route": "reports\/monthly-depreciation-post-by-branch",
                "description": "Motnhy Depreciation - Post by Branch"
                }
            ]';

        $data = json_decode($sml_json, true);
        try {
            DB::transaction(function () use ($data) {
                $result = collect($data)->map(function ($item) {
                    return [
                        'al_id' => $item['al_id'],
                        'route' => $item['route'],
                        'description' => $item['description']
                    ];
                });
                SubModuleList::upsert($result->toArray(), ['sml_id'], ['al_id', 'route', 'description']);
            });
        } catch (\Exception $e) {
            var_dump(['message' => 'Transcation Failed', 'error' => $e->getMessage()]);
        }
    }
}
