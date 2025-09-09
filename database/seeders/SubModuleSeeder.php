<?php

namespace Database\Seeders;

use App\Models\SubModuleList;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $subModules = [
            [
                "sml_id" => "122",
                "al_id" => "6",
                "route" => "login",
                "description" => "System Login",

            ],
            [
                "sml_id" => "123",
                "al_id" => "6",
                "route" => "logout",
                "description" => "System Logout",

            ],
            [
                "sml_id" => "124",
                "al_id" => "6",
                "route" => "authenticate",
                "description" => "System Authentication",

            ],
            [
                "sml_id" => "125",
                "al_id" => "8",
                "route" => "chart-of-accounts",
                "description" => "Chart of Accounts Home",

            ],
            [
                "sml_id" => "126",
                "al_id" => "8",
                "route" => "accounts/create",
                "description" => "Chart of Accounts (Create)",

            ],
            [
                "sml_id" => "127",
                "al_id" => "8",
                "route" => "accounts-datatable",
                "description" => "Chart of Accounts (Datatable)",

            ],
            [
                "sml_id" => "128",
                "al_id" => "8",
                "route" => "set-status",
                "description" => "Chart of Accounts (Set Status)",

            ],
            [
                "sml_id" => "156",
                "al_id" => "5",
                "route" => "systemSetup",
                "description" => "System Setup",

            ],
            [
                "sml_id" => "157",
                "al_id" => "5",
                "route" => "systemSetup/general/company/update",
                "description" => "Company Update",

            ],
            [
                "sml_id" => "158",
                "al_id" => "5",
                "route" => "systemSetup/general/accounting/update",
                "description" => "Accounting Update",

            ],
            [
                "sml_id" => "159",
                "al_id" => "5",
                "route" => "systemSetup/general/currency/update",
                "description" => "Currency Update",

            ],
            [
                "sml_id" => "174",
                "al_id" => "7",
                "route" => "dashboard",
                "description" => "Dashboard Home",

            ],
            [
                "sml_id" => "175",
                "al_id" => "5",
                "route" => "companySettings",
                "description" => "Company Settings (Panel)",
            ],
            [
                "sml_id" => "178",
                "al_id" => "5",
                "route" => "JournalBook",
                "description" => "JournalBook (Panel)",

            ],
            [
                "sml_id" => "179",
                "al_id" => "5",
                "route" => "UserMasterFile",
                "description" => "UserMasterFile (Panel)",
            ],
            [
                "sml_id" => "180",
                "al_id" => "5",
                "route" => "accounting",
                "description" => "accounting (Panel)",

            ],
            [
                "sml_id" => "181",
                "al_id" => "5",
                "route" => "currency",
                "description" => "currency (Panel)",
            ],
            [
                "sml_id" => "187",
                "al_id" => "5",
                "route" => "systemSetup/general/userMasterFile/createOrUpdate",
                "description" => "User Master FIle (Create or Update)",

            ],
            [
                "sml_id" => "189",
                "al_id" => "5",
                "route" => "systemSetup/general/usermasterfile/searchAccount",
                "description" => "User Master File (Search Account)",

            ],
            [
                "sml_id" => "191",
                "al_id" => "5",
                "route" => "systemSetup/general/usermasterfile/fetchInfo",
                "description" => "User Master File (Fetch Information)",

            ],
            [
                "sml_id" => "193",
                "al_id" => "5",
                "route" => "systemSetup/general/usermasterfile/createOrUpdateAccessibility",
                "description" => "User Master File ( Update Accessibility)",

            ],
            [
                "sml_id" => "195",
                "al_id" => "5",
                "route" => "systemSetup/general/usermasterfile/createOrUpdate",
                "description" => "User Master File ( Create User or Update User)",

            ],
            [
                "sml_id" => "197",
                "al_id" => "5",
                "route" => "CategoryFile",
                "description" => "Category File (Panel)",

            ],
            [
                "sml_id" => "201",
                "al_id" => "5",
                "route" => "subsidiary",
                "description" => "Subsidiary Panel",

            ],
            [
                "sml_id" => "202",
                "al_id" => "5",
                "route" => "systemSetup/general/journalBook/createOrUpdate",
                "description" => "Journal Book (Create or Update)",

            ],
            [
                "sml_id" => "203",
                "al_id" => "5",
                "route" => "systemSetup/general/journalBook/fetchBookInfo",
                "description" => "Journal Book (Fetch Book Information) ",
            ],
            [
                "sml_id" => "204",
                "al_id" => "5",
                "route" => "systemSetup/general/journalBook/deleteBook",
                "description" => "Journal Book (Delete Book Record)",
            ],
            [
                "sml_id" => "205",
                "al_id" => "5",
                "route" => "systemSetup/general/categoryFile/createOrUpdate",
                "description" => "Subsidiary Category File (Create or Update)",
            ],
            [
                "sml_id" => "206",
                "al_id" => "5",
                "route" => "systemSetup/general/categoryFile/fetchCategoryInfo",
                "description" => "Subsidiary Category File (Fetch Category Info)",

            ],
            [
                "sml_id" => "207",
                "al_id" => "5",
                "route" => "systemSetup/general/categoryFile/deleteCategory",
                "description" => "Subsidiary Category File (Delete Category)",
            ],
            [
                "sml_id" => "208",
                "al_id" => "4",
                "route" => "reports",
                "description" => "Report (Panel)",
            ],
            [
                "sml_id" => "209",
                "al_id" => "4",
                "route" => "reports/subsidiaryledger",
                "description" => "Report (Subsidiary Ledger Panel)",

            ],
            [
                "sml_id" => "211",
                "al_id" => "4",
                "route" => "reports/generalLedger",
                "description" => "Report (General Ledger)",

            ],
            [
                "sml_id" => "212",
                "al_id" => "4",
                "route" => "reports/trialBalance",
                "description" => "Report (Trial Balance)",
            ],
            [
                "sml_id" => "213",
                "al_id" => "4",
                "route" => "reports/incomeStatement",
                "description" => "Report (Income Statement)",
            ],
            [
                "sml_id" => "214",
                "al_id" => "4",
                "route" => "reports/bankReconcillation",
                "description" => "Report (Bank Reconcillation)",
            ],
            [
                "sml_id" => "215",
                "al_id" => "4",
                "route" => "reports/cashPosition",
                "description" => "Report (Cash Position)",
            ],
            [
                "sml_id" => "216",
                "al_id" => "4",
                "route" => "reports/cashTransactionBlotter",
                "description" => "Report (Cash Transaction Blotter)",

            ],
            [
                "sml_id" => "217",
                "al_id" => "9",
                "route" => "journal/journalEntryList",
                "description" => "Journal Entry List",
            ],
            [
                "sml_id" => "219",
                "al_id" => "9",
                "route" => "journal/journalEntry",
                "description" => "Journal Entry ",
            ],
            [
                "sml_id" => "220",
                "al_id" => "4",
                "route" => "reports/cheque",
                "description" => "Cheque",
            ],
            [
                "sml_id" => "221",
                "al_id" => "4",
                "route" => "reports/postDatedCheque",
                "description" => "Post-Dated Cheque",
            ],
            [
                "sml_id" => "223",
                "al_id" => "8",
                "route" => "accounts/getAccountTypeContent",
                "description" => "Chart of Account  (Get Type Content)",
            ],
            [
                "sml_id" => "225",
                "al_id" => "8",
                "route" => "accounts/saveType",
                "description" => "Accounts VIew Type Modal",
            ],
            [
                "sml_id" => "226",
                "al_id" => "8",
                "route" => "accounts/saveClass",
                "description" => "Accounts VIew ClassModal",
            ],
            [
                "sml_id" => "227",
                "al_id" => "8",
                "route" => "accounts/createNewType",
                "description" => "Chart of Account save Type",
            ],
            [
                "sml_id" => "228",
                "al_id" => "8",
                "route" => "accounts/createNewClass",
                "description" => "Chart of Account save Class",
            ],
            [
                "sml_id" => "232",
                "al_id" => "4",
                "route" => "reports/subsidiarySaveorEdit",
                "description" => "Subsidiary Create or Update",
            ],
            [
                "sml_id" => "234",
                "al_id" => "10",
                "route" => "sales",
                "description" => "sales",

            ],
            [
                "sml_id" => "235",
                "al_id" => "10",
                "route" => "sales/store",
                "description" => "sales",

            ],
            [
                "sml_id" => "236",
                "al_id" => "10",
                "route" => "sales-datatable",
                "description" => "sales",
            ],
            [
                "sml_id" => "237",
                "al_id" => "10",
                "route" => "getsales",
                "description" => "sales",

            ],
            [
                "sml_id" => "238",
                "al_id" => "10",
                "route" => "sales/invoice",
                "description" => "sales",
            ],
            [
                "sml_id" => "239",
                "al_id" => "10",
                "route" => "sales/create/invoice",
                "description" => "sales",
            ],
            [
                "sml_id" => "240",
                "al_id" => "10",
                "route" => "sales/store",
                "description" => "sales",

            ],
            [
                "sml_id" => "241",
                "al_id" => "10",
                "route" => "sales-datatable",
                "description" => "sales",
            ],
            [
                "sml_id" => "242",
                "al_id" => "10",
                "route" => "getsales",
                "description" => "sales",
            ],
            [
                "sml_id" => "244",
                "al_id" => "10",
                "route" => "expenses",
                "description" => "expenses",
            ],
            [
                "sml_id" => "245",
                "al_id" => "11",
                "route" => "expenses/store",
                "description" => "expenses",
            ],
            [
                "sml_id" => "246",
                "al_id" => "11",
                "route" => "expenses/void",
                "description" => "expenses",
            ],
            [
                "sml_id" => "247",
                "al_id" => "11",
                "route" => "expense-datatable",
                "description" => "expenses",
            ],
            [
                "sml_id" => "248",
                "al_id" => "11",
                "route" => "create/expense",
                "description" => "expenses",
            ],
            [
                "sml_id" => "250",
                "al_id" => "11",
                "route" => "create/bill",
                "description" => "expenses",
            ],
            [
                "sml_id" => "255",
                "al_id" => "4",
                "route" => "reports/subsidiaryViewInfo",
                "description" => "Report (Subsidiary Fetch Information)",

            ],
            [
                "sml_id" => "256",
                "al_id" => "4",
                "route" => "reports/subsidiaryDelete",
                "description" => "Report (Subsidiary Delete)",

            ],
            [
                "sml_id" => "259",
                "al_id" => "9",
                "route" => "journal",
                "description" => "Journal VIew (NOT INCLUDE)",
            ],
            [
                "sml_id" => "260",
                "al_id" => "9",
                "route" => "journal/saveJournalEntry",
                "description" => "Journal (save Journal Entry)",
            ],
            [
                "sml_id" => "262",
                "al_id" => "9",
                "route" => "journal/saveJournalEntryDetails",
                "description" => "Journal Entry (save Journal Entry Details)",
            ],
            [
                "sml_id" => "263",
                "al_id" => "9",
                "route" => "journal/JournalEntryFetch",
                "description" => "Journal (Fetch Journal Information)",
            ],
            [
                "sml_id" => "265",
                "al_id" => "9",
                "route" => "journal/JournalEntryPostUnpost",
                "description" => "Journal (Set Unposted to Posted)",
            ],
            [
                "sml_id" => "267",
                "al_id" => "9",
                "route" => "journal/JournalEntryEdit",
                "description" => "Journal Edit",
            ],
            [
                "sml_id" => "268",
                "al_id" => "6",
                "route" => "user/profile",
                "description" => "User Profile ",
            ],
            [
                "sml_id" => "269",
                "al_id" => "9",
                "route" => "journal/JournalEntryCancel",
                "description" => "Journal Entry Cancel",
            ],
            [
                "sml_id" => "270",
                "al_id" => "4",
                "route" => "reports/journalledger",
                "description" => "Journal Ledger",
            ],
            [
                "sml_id" => "271",
                "al_id" => "9",
                "route" => "journal/searchJournalEntry",
                "description" => "Search Journal",
            ],
            [
                "sml_id" => "272",
                "al_id" => "9",
                "route" => "reports/revenue-minus-expense",
                "description" => "Income Minus Expense",
            ],
            [
                "sml_id" => "273",
                "al_id" => "4",
                "route" => "reports/cashTransactionBlotter",
                "description" => "Reports Cash Blotter",
            ],
            [
                "sml_id" => "274",
                "al_id" => "4",
                "route" => "reports/showTransactionBlotter",
                "description" => "View Cash Blotter",
            ],
            [
                "sml_id" => "275",
                "al_id" => "4",
                "route" => "reports/bank-reconciliation",
                "description" => "View Bank Reconciliation",
            ],
            [
                "sml_id" => "276",
                "al_id" => "4",
                "route" => "reports/subsidiary-ledger",
                "description" => "View Subsidiary Ledger Reports",
            ]
        ];
        DB::beginTransaction();
        try {
            foreach ($subModules as $module) {
                SubModuleList::create($module);
            }
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
        }
    }
}
