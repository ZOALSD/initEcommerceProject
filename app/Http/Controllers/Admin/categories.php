<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\DataTables\categoriesDataTable;
use Carbon\Carbon;
use App\Models\category;

use App\Http\Controllers\Validations\categoriesRequest;
// Auto Controller Maker By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.40]
// Copyright Reserved  [it v 1.6.40]
class categories extends Controller
{

	public function __construct() {

		$this->middleware('AdminRole:categories_show', [
			'only' => ['index', 'show'],
		]);
		$this->middleware('AdminRole:categories_add', [
			'only' => ['create', 'store'],
		]);
		$this->middleware('AdminRole:categories_edit', [
			'only' => ['edit', 'update'],
		]);
		$this->middleware('AdminRole:categories_delete', [
			'only' => ['destroy', 'multi_delete'],
		]);
	}

	

            /**
             * Baboon Script By [it v 1.6.40]
             * Display a listing of the resource.
             * @return \Illuminate\Http\Response
             */
            public function index(categoriesDataTable $categories)
            {
               return $categories->render('admin.categories.index',['title'=>trans('admin.categories')]);
            }


            /**
             * Baboon Script By [it v 1.6.40]
             * Show the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function create()
            {
            	
               return view('admin.categories.create',['title'=>trans('admin.create')]);
            }

            /**
             * Baboon Script By [it v 1.6.40]
             * Store a newly created resource in storage.
             * @param  \Illuminate\Http\Request  $request
             * @return \Illuminate\Http\Response Or Redirect
             */
            public function store(categoriesRequest $request)
            {
                $data = $request->except("_token", "_method");
            	$data['image'] = "";
		  		$categories = category::create($data); 
               if(request()->hasFile('image')){
              $categories->image = it()->upload('image','categories/'.$categories->id);
              $categories->save();
              }

			return successResponseJson([
				"message" => trans("admin.added"),
				"data" => $categories,
			]);
			 }

            /**
             * Display the specified resource.
             * Baboon Script By [it v 1.6.40]
             * @param  int  $id
             * @return \Illuminate\Http\Response
             */
            public function show($id)
            {
        		$categories =  category::find($id);
        		return is_null($categories) || empty($categories)?
        		backWithError(trans("admin.undefinedRecord"),aurl("categories")) :
        		view('admin.categories.show',[
				    'title'=>trans('admin.show'),
					'categories'=>$categories
        		]);
            }


            /**
             * Baboon Script By [it v 1.6.40]
             * edit the form for creating a new resource.
             * @return \Illuminate\Http\Response
             */
            public function edit($id)
            {
        		$categories =  category::find($id);
        		return is_null($categories) || empty($categories)?
        		backWithError(trans("admin.undefinedRecord"),aurl("categories")) :
        		view('admin.categories.edit',[
				  'title'=>trans('admin.edit'),
				  'categories'=>$categories
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
				foreach (array_keys((new categoriesRequest)->attributes()) as $fillableUpdate) {
					if (!is_null(request($fillableUpdate))) {
						$fillableCols[$fillableUpdate] = request($fillableUpdate);
					}
				}
				return $fillableCols;
			}

            public function update(categoriesRequest $request,$id)
            {
              // Check Record Exists
              $categories =  category::find($id);
              if(is_null($categories) || empty($categories)){
              	return backWithError(trans("admin.undefinedRecord"),aurl("categories"));
              }
              $data = $this->updateFillableColumns(); 
               if(request()->hasFile('image')){
              it()->delete($categories->image);
              $data['image'] = it()->upload('image','categories');
               } 
              category::where('id',$id)->update($data);

              $categories = category::find($id);
              return successResponseJson([
               "message" => trans("admin.updated"),
               "data" => $categories,
              ]);
			}

            /**
             * Baboon Script By [it v 1.6.40]
             * destroy a newly created resource in storage.
             * @param  $id
             * @return \Illuminate\Http\Response
             */
	public function destroy($id){
		$categories = category::find($id);
		if(is_null($categories) || empty($categories)){
			return backWithSuccess(trans('admin.undefinedRecord'),aurl("categories"));
		}
               		if(!empty($categories->image)){
			it()->delete($categories->image);		}

		it()->delete('category',$id);
		$categories->delete();
		return redirectWithSuccess(aurl("categories"),trans('admin.deleted'));
	}


	public function multi_delete(){
		$data = request('selected_data');
		if(is_array($data)){
			foreach($data as $id){
				$categories = category::find($id);
				if(is_null($categories) || empty($categories)){
					return backWithError(trans('admin.undefinedRecord'),aurl("categories"));
				}
                    					if(!empty($categories->image)){
				  it()->delete($categories->image);
				}
				it()->delete('category',$id);
				$categories->delete();
			}
			return redirectWithSuccess(aurl("categories"),trans('admin.deleted'));
		}else {
			$categories = category::find($data);
			if(is_null($categories) || empty($categories)){
				return backWithError(trans('admin.undefinedRecord'),aurl("categories"));
			}
                    
			if(!empty($categories->image)){
			 it()->delete($categories->image);
			}			it()->delete('category',$data);
			$categories->delete();
			return redirectWithSuccess(aurl("categories"),trans('admin.deleted'));
		}
	}
            

}