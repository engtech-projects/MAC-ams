<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier;


class SupplierController extends MainController
{
    
	 public function index() {

	 	 $data = [
            'title' => 'Suppliers',
            'suppliers' => Supplier::all()->toArray(),
        ];

    	return view('suppliers.suppliers', $data);
    }

    public function create() {

    	return view('suppliers.createsupplier');
    }

    public function store(Request $request) {

    	$supplier = new Supplier();
    	return $supplier->store($request);

    }

    public function show($id) {

    	$data = array(
    		'supplier' => Supplier::find($id),
    		'address' => Supplier::find($id)->address
    	);
    	
    	return view('suppliers.editsupplier', $data);

    }
    public function update(Request $request, Supplier $supplier) {

    	// return $request->input();
    	return $supplier->edit($request, $supplier);

    }


    public function populate() {
    	$supplier = new Supplier();
    	return $supplier->populate();

    }

}
