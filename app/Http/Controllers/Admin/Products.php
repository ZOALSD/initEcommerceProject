<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\ProductsDataTable;
use Carbon\Carbon;
use App\Models\Product;

use App\Http\Controllers\Validations\ProductsRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.40]
// Copyright Reserved  [it v 1.6.40]
class Products extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:products_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:products_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:products_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:products_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            /**
             * Baboon Script By [it v 1.6.40]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(ProductsDataTable $products)
            {
               return $products->render('admin.products.index',['title'=>trans('admin.products')]);
            }


            /**
             * Baboon Script By [it v 1.6.40]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {
            	
               return view('admin.products.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.40]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(ProductsRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['image'] = "";
		  		$products = Product::create($data); 
               if(request()->hasFile('image')){
              $products->image = it()->upload('image','products/'.$products->id);
              $products->save();
              }
                $redirect = isset($request["add_back"])?"/create":"";
                return redirectWithSuccess(aurl('products'.$redirect), trans('admin.added')); }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.40]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$products =  Product::find($id);
        		return is_null($products) || empty($products)?
        		backWithError(trans("admin.undefinedRecord"),aurl("products")) :
        		view('admin.products.show',[
				    'title'=>trans('admin.show'),
					'products'=>$products
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.40]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$products =  Product::find($id);
        		return is_null($products) || empty($products)?
        		backWithError(trans("admin.undefinedRecord"),aurl("products")) :
        		view('admin.products.edit',[
				  'title'=>trans('admin.edit'),
				  'products'=>$products
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.40]
             * update a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response
             */
            public function updateFillableColumns() {
				$fillableCols = [];
				foreach (array_keys((new ProductsRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(ProductsRequest $request,$id)
            {
              // Check Record Exists
              $products =  Product::find($id);
              if(is_null($products) || empty($products)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("products"));
              }
              $data = $this->updateFillableColumns(); 
               if(request()->hasFile('image')){
              it()->delete($products->image);
              $data['image'] = it()->upload('image','products');
               } 
              Product::where('id',$id)->update($data);
              $redirect = isset($request["save_back"])?"/".$id."/edit":"";
              return redirectWithSuccess(aurl('products'.$redirect), trans('admin.updated'));
            }

            /**
             * Baboon Script By [it v 1.6.40]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$products = Product::find($id);
		if(is_null($products) || empty($products)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("products"));
		}
               		if(!empty($products->image)){
			it()->delete($products->image);		}

		it()->delete('product',$id);
		$products->delete();
		return redirectWithSuccess(aurl("products"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$products = Product::find($id);
				if(is_null($products) || empty($products)){
					return backWithError(trans('admin.undefinedRecord'),aurl("products"));
				}
                    					if(!empty($products->image)){
				  it()->delete($products->image);
				}
				it()->delete('product',$id);
				$products->delete();
			}
			return redirectWithSuccess(aurl("products"),trans('admin.deleted'));
		}else {
			$products = Product::find($data);
			if(is_null($products) || empty($products)){
				return backWithError(trans('admin.undefinedRecord'),aurl("products"));
			}
                    
			if(!empty($products->image)){
			 it()->delete($products->image);
			}			it()->delete('product',$data);
			$products->delete();
			return redirectWithSuccess(aurl("products"),trans('admin.deleted'));
		}
	}
            

}