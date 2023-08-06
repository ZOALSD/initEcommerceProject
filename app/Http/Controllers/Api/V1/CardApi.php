<?php
namespace App\Http\Controllers\Api\V1;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Cards;
use Validator;
use App\Http\Controllers\ValidationsApi\V1\CardRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.40]
// Copyright Reserved  [it v 1.6.40]
class CardApi extends Controller{
	protected $selectColumns = [
		"id",
	];

            /**
             * Display the specified releationshop.
             * Baboon Api Script By [it v 1.6.40]
             * @return array to assign with index & show methods
             */
            public function arrWith(){
               return [];
            }


            /**
             * Baboon Api Script By [it v 1.6.40]
             * Display a listing of the resource. Api
             * @return \Illuminate\Http\Response
             */
            public function index()
            {
            	$Cards = Cards::select($this->selectColumns)->with($this->arrWith())->orderBy("id","desc")->paginate(15);
               return successResponseJson(["data"=>$Cards]);
            }


            /**
             * Baboon Api Script By [it v 1.6.40]
             * Store a newly created resource in storage. Api
             * @return \Illuminate\Http\Response
             */
    public function store(CardRequest $request)
    {
    	$data = $request->except("_token");
    	
        $Cards = Cards::create($data); 

		  $Cards = Cards::with($this->arrWith())->find($Cards->id,$this->selectColumns);
        return successResponseJson([
            "message"=>trans("admin.added"),
            "data"=>$Cards
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
                $Cards = Cards::with($this->arrWith())->find($id,$this->selectColumns);
            	if(is_null($Cards) || empty($Cards)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}

                 return successResponseJson([
              "data"=> $Cards
              ]);  ;
            }


            /**
             * Baboon Api Script By [it v 1.6.40]
             * update a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function updateFillableColumns() {
				       $fillableCols = [];
				       foreach (array_keys((new CardRequest)->attributes()) as $fillableUpdate) {
  				        if (!is_null(request($fillableUpdate))) {
						  $fillableCols[$fillableUpdate] = request($fillableUpdate);
						}
				       }
  				     return $fillableCols;
  	     		}

            public function update(CardRequest $request,$id)
            {
            	$Cards = Cards::find($id);
            	if(is_null($Cards) || empty($Cards)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
  			       }

            	$data = $this->updateFillableColumns();
                 
              Cards::where("id",$id)->update($data);

              $Cards = Cards::with($this->arrWith())->find($id,$this->selectColumns);
              return successResponseJson([
               "message"=>trans("admin.updated"),
               "data"=> $Cards
               ]);
            }

            /**
             * Baboon Api Script By [it v 1.6.40]
             * destroy a newly created resource in storage.
             * @return \Illuminate\Http\Response
             */
            public function destroy($id)
            {
               $card = Cards::find($id);
            	if(is_null($card) || empty($card)){
            	 return errorResponseJson([
            	  "message"=>trans("admin.undefinedRecord")
            	 ]);
            	}


              if(!empty($card->image)){
               it()->delete($card->image);
              }
               it()->delete("cards",$id);

               $card->delete();
               return successResponseJson([
                "message"=>trans("admin.deleted")
               ]);
            }



 			public function multi_delete()
            {
                $data = request("selected_data");
                if(is_array($data)){
                    foreach($data as $id){
                    $card = Cards::find($id);
	            	if(is_null($card) || empty($card)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}

                    	if(!empty($card->image)){
                    	it()->delete($card->image);
                    	}
                    	it()->delete("cards",$id);
                    	$card->delete();
                    }
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }else {
                    $card = Cards::find($data);
	            	if(is_null($card) || empty($card)){
	            	 return errorResponseJson([
	            	  "message"=>trans("admin.undefinedRecord")
	            	 ]);
	            	}
 
                    	if(!empty($card->image)){
                    	it()->delete($card->image);
                    	}
                    	it()->delete("cards",$data);

                    $card->delete();
                    return successResponseJson([
                     "message"=>trans("admin.deleted")
                    ]);
                }
            }

            
}