<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Product;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\ProductsRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.40]
// Copyright Reserved  [it v 1.6.40]
class ProductsApi extends Controller{
	protected $selectColumns = [
		"id",
		"name",
		"price",
		"category_id",
		"image",
		"description",
	];

            /**
             * Display the specified releationshop.
             * Baboon Api Script By [it v 1.6.40]
             * @return array to assign with index & show methods
             */
            public function arrWith(){
               return ['category_id',];
            }


            /**
             * Baboon Api Script By [it v 1.6.40]
             * Display a listing of the resource. Api
             * @return \Illuminate\Http\Response
             */
            public function index()
            {
            	$Product = Product::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$Product]);
            }


            /**
             * Baboon Api Script By [it v 1.6.40]
             * Store a newly created resource in storage. Api
             * @return \Illuminate\Http\Response
             */
    public function store(ProductsRequest $request)
    {
    	$data = $request->except("_token");
    	
                $data["image"] = "";
        $Product = Product::create($data); 
               if(request()->hasFile("image")){
              $Product->image = it()->upload("image","products/".$Product->id);
              $Product->save();
              }

		  $Product = Product::with($this->arrWith())->find($Product->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$Product
        ]);
    }


            /**
             * Display the specified resource.
             * Baboon Api Script By [it v 1.6.40]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
                $Product = Product::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($Product) || empty($Product)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $Product
              ]);  ;
            }


            /**
             * Baboon Api Script By [it v 1.6.40]
             * update a newly created resource in storage.
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
            	$Product = Product::find($id);
            	if(is_null($Product) || empty($Product)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
               if(request()->hasFile("image")){
              it()->delete($Product->image);
              $data["image"] = it()->upload("image","products/".$Product->id);
               }
              Product::where("id",$id)->update($data);

              $Product = Product::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $Product
               ]);
            }

            /**
             * Baboon Api Script By [it v 1.6.40]
             * destroy a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function destroy($id)
            {
               $products = Product::find($id);
            	if(is_null($products) || empty($products)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


              if(!empty($products->image)){
               it()->delete($products->image);
              }
               it()->delete("product",$id);

               $products->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $products = Product::find($id);
	            	if(is_null($products) || empty($products)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	if(!empty($products->image)){
                    	it()->delete($products->image);
                    	}
                    	it()->delete("product",$id);
                    	$products->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $products = Product::find($data);
	            	if(is_null($products) || empty($products)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	if(!empty($products->image)){
                    	it()->delete($products->image);
                    	}
                    	it()->delete("product",$data);

                    $products->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}