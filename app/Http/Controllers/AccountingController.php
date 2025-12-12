<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;


class AccountingController extends MainController {

	public function index() {

		$data = [
            'title' => 'MAC-AMS | Accounting',
        ];

        return view('accounting.accounting', $data);

	}

}