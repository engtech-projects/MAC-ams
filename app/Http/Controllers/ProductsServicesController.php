<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductsServices;
use App\Models\ItemDetail;
use App\Models\ProductsServicesCategory;
use Session;

class ProductsServicesController extends MainController
{
	public function index(Request $request){
		// dd(ProductsServices::with('itemDetails','category')->orderBy('name', 'ASC')->get());
		return view('sales.products_services')->with([
			'title' 	=> 'Products & Services '.' - '.config('app.name'),
			'nav' 		=> ['sales', 'products and services'],
			'items'		=> ProductsServices::with('itemDetails','category')->orderBy('name', 'ASC')->get(),
		]);
	}

	public function fetchDataTable(){
		$data = ProductsServices::with('itemDetails','category')->orderBy('name', 'ASC')->get();
		foreach ($data as $key => $value) {
			$value->withEdit();
			$value->withCopy();
			$value->withImage();
		}
		return $data;
	}

	public function createProduct(Request $request){
		$product = null;
		if(isset($request->id)){
			$product = ProductsServices::with('itemDetails','category')->find($request->id);
		}
		return view('sales.create_product')->with([
			'title' 	=> 'Products & Services '.' - '.config('app.name'),
			'nav' 		=> ['sales', 'products and services'],
			'categories' => ProductsServicesCategory::orderBy('category_name', 'ASC')->get(),
			'product' => $product
		]);
	}

	public function storeProduct(Request $request){
		$upload = uploadImage($request->file, 'img/uploads');
		$item = new ProductsServices;
		$item->name = $request->name;
		$item->type = 'product';
		$item->sku = $request->sku;
		$item->ps_category_id = $request->category;
		$item->qty_on_hand = $request->q_onhand;
		$item->reorder_point = $request->reorder_point;
		$item->description = $request->description;
		$item->rate = $request->sales_price_rate;
		$item->income_account = $request->income_account;
		$item->image_path = $upload;
		$item->save();
		
		Session::flash('success', 'Saved successfully!');
		return redirect(route('products_services'));
	}

	public function editProduct($id){
		return view('sales.edit_product')->with([
			'title' 	=> 'Products & Services '.' - '.config('app.name'),
			'nav' 		=> ['sales', 'products and services'],
			'product'	=> ProductsServices::with('itemDetails','category')->find($id),
			'categories' => ProductsServicesCategory::orderBy('category_name', 'ASC')->get(),
		]);
	}

	public function updateProduct(Request $request){
		$item = ProductsServices::with('itemDetails')->find($request->item_id);
		$upload = $item->image_path;
		if($request->file){
			if(!empty($item->image_path)){
				unlink($upload);
			}
			$upload = uploadImage($request->file, 'img/uploads');
		}		
		$item->name = $request->name;
		$item->type = 'product';
		$item->sku = $request->sku;
		$item->ps_category_id = $request->category;
		$item->qty_on_hand = $request->q_onhand;
		$item->reorder_point = $request->reorder_point;
		$item->description = $request->description;
		$item->rate = $request->sales_price_rate;
		$item->income_account = $request->income_account;
		$item->image_path = $upload;
		$item->save();

		Session::flash('success', 'Updated successfully!');
		return redirect(route('products_services'));
	}

	public function createService(Request $request){
		$service = null;
		if(isset($request->id)){
			$service = ProductsServices::with('itemDetails','category')->find($request->id);
		}
		return view('sales.create_service')->with([
			'title' 	=> 'Products & Services '.' - '.config('app.name'),
			'nav' 		=> ['sales', 'products and services'],
			'categories' => ProductsServicesCategory::orderBy('category_name', 'ASC')->get(),
			'service' => $service,
		]);
	}

	public function updateService(Request $request){
		$item = ProductsServices::with('itemDetails')->find($request->item_id);
		$upload = $item->image_path;
		if($request->file){
			if(!empty($item->image_path)){
				unlink($upload);
			}
			$upload = uploadImage($request->file, 'img/uploads');
		}			
		$item->name = $request->name;
		$item->type = 'item';
		$item->sku = $request->sku;
		$item->ps_category_id = $request->category;
		$item->description = $request->description;
		$item->rate = $request->sales_price_rate;
		$item->income_account = $request->income_account;
		$item->image_path = $upload;
		$item->save();

		Session::flash('success', 'Saved successfully!');
		return redirect(route('products_services'));
	}

	public function editService($id){
		return view('sales.edit_service')->with([
			'title' 	=> 'Products & Services '.' - '.config('app.name'),
			'nav' 		=> ['sales', 'products and services'],
			'service'	=> ProductsServices::with('itemDetails')->find($id),
			'categories' => ProductsServicesCategory::orderBy('category_name', 'ASC')->get(),
		]);
	}

	public function storeService(Request $request){
		$upload = uploadImage($request->file, 'img/uploads');
		$service = new ProductsServices;
		$service->name = $request->name;
		$service->type = 'service';
		$service->sku = $request->sku;
		$service->ps_category_id = $request->category;
		$service->description = $request->description;
		$service->rate = $request->sales_price_rate;
		$service->income_account = $request->income_account;
		$service->image_path = $upload;
		$service->save();

		Session::flash('success', 'Saved successfully!');
		return redirect(route('products_services'));
	}

	public function createProductCategory(Request $request){
		return view('sales.addnewcategory')->with([
			'title' 	=> 'Products & Services '.' - '.config('app.name'),
			'categories' => ProductsServicesCategory::orderBy('category_name', 'ASC')->get(),
		]);
	}

	public function storeProductCategory(Request $request){
		$data = (object)[];
		$cat = new ProductsServicesCategory;
		$cat->category_name = $request->category_name;
		$cat->save();

		$data->success = 1;
		$data->data = ProductsServicesCategory::orderBy('category_name', 'ASC')->get();

		// Session::flash('success', 'New category has been successfully added.');
		// return redirect(route('product.create'));
		return response()->json($data, 200);
	}

	public function deleteProductCategory(Request $request){
		$data = (object)[];
		ProductsServicesCategory::find($request->id)->delete();
		$data->success = 1;
		$data->data = ProductsServicesCategory::orderBy('category_name', 'ASC')->get();
		return response()->json($data, 200);
	}

	public function updateProductCategory(Request $request){
		$data = (object)[];
		$category = ProductsServicesCategory::find($request->id);
		$category->category_name = $request->category_name;
		$category->save();
		$data->success = 1;
		$data->data = ProductsServicesCategory::orderBy('category_name', 'ASC')->get();
		return response()->json($data, 200);
	}

	public function fetchProductCategories(){
		$data = (object)[];
		$data->success = 1;
		$data->data = ProductsServicesCategory::orderBy('category_name', 'ASC')->get();
		return response()->json($data, 200);
	}

}
 