<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Supplier;
use App\Models\SupplierAddress;
use Illuminate\Http\Request;

class Supplier extends Model
{
    use HasFactory;
	protected $primaryKey = "supplier_id";
	protected $table = "supplier";
    public $timestamps = true;

	protected $fillable = [
    	'title', 'firstname', 'middlename', 'lastname', 'suffix', 'displayname', 'email_address', 'mobile_number', 'phone_number', 'company', 'tin_number'
    ];


    public function address() {
    	return $this->hasOne(SupplierAddress::class, 'supplier_id');
    }

    public function store(Request $request) {

        $supplier = new Supplier();
        $supplier->title = $request->title;
        $supplier->firstname = $request->firstname;
        $supplier->middlename = $request->middlename;
        $supplier->lastname = $request->lastname;
        $supplier->suffix = $request->suffix;
        $supplier->displayname = $request->displayname;
        $supplier->email_address = $request->email_address;
        $supplier->mobile_number = $request->mobile_number;
        $supplier->phone_number = $request->phone_number;
        $supplier->company = $request->company;
        $supplier->tin_number = $request->tin_number;
        $supplier->save();

        if( $supplier->supplier_id )  {

            $address = new SupplierAddress();
            $address->street = $request->street;
            $address->city = $request->city;
            $address->province = $request->province;
            $address->zip_code = $request->zip_code;
            $address->country = $request->country;
            $address->supplier_id = $supplier->supplier_id;
            $address->save();

            return response()->json(array('success' => true, 'message' => 'New supplier created!'), 200);
        }

        return response()->json(array('success' => true, 'message' => 'Something went wrong!'), 200);
    }

    public function populate() {

        $data = Supplier::all();

        foreach ($data->toArray() as $key => $value) {
            $row = [];
            foreach ($value as $k => $v) {
                $row[$k] = utf8_encode($v);
            }
            $jsonData['data'][] = $row;
        }
        return json_encode($jsonData);

    }

    public function edit(Request $request, Supplier $supplier) {

        if ($supplier->update($request->only(['title', 'firstname', 'middlename', 'lastname', 'suffix', 'displayname', 'email_address', 'mobile_number', 'phone_number', 'company', 'tin_number'])) ) {

            SupplierAddress::where('supplier_id', $supplier->supplier_id)->update($request->only(['street', 'city', 'province', 'zip_code', 'country']));

            return response()->json(array('success' => true, 'message' => 'Updated!'), 200);
        }

        return response()->json(array('success' => true, 'message' => 'Something went wrong!'), 200);
    }

}
