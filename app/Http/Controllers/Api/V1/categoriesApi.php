<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\category;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\categoriesRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.40]
// Copyright Reserved  [it v 1.6.40]
class categoriesApi extends Controller{
	protected $selectColumns = [
		"id",
		"category_name",
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
            	$category = category::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$category]);
            }


            /**
             * Baboon Api Script By [it v 1.6.40]
             * Store a newly created resource in storage. Api
             * @return \Illuminate\Http\Response
             */
    public function store(categoriesRequest $request)
    {
    	$data = $request->except("_token");
    	
        $category = category::create($data); 

		  $category = category::with($this->arrWith())->find($category->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$category
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
                $category = category::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($category) || empty($category)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $category
              ]);  ;
            }


            /**
             * Baboon Api Script By [it v 1.6.40]
             * update a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new categoriesRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(categoriesRequest $request,$id)
            {
            	$category = category::find($id);
            	if(is_null($category) || empty($category)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              category::where("id",$id)->update($data);

              $category = category::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $category
               ]);
            }

            /**
             * Baboon Api Script By [it v 1.6.40]
             * destroy a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function destroy($id)
            {
               $categories = category::find($id);
            	if(is_null($categories) || empty($categories)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


              if(!empty($categories->image)){
               it()->delete($categories->image);
              }
               it()->delete("category",$id);

               $categories->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $categories = category::find($id);
	            	if(is_null($categories) || empty($categories)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	if(!empty($categories->image)){
                    	it()->delete($categories->image);
                    	}
                    	it()->delete("category",$id);
                    	$categories->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $categories = category::find($data);
	            	if(is_null($categories) || empty($categories)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	if(!empty($categories->image)){
                    	it()->delete($categories->image);
                    	}
                    	it()->delete("category",$data);

                    $categories->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}