<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

// Auto Models By Baboon Script
// Baboon Maker has been Created And Developed By  [it v 1.6.40]
// Copyright Reserved  [it v 1.6.40]
class Product extends Model {

protected $table    = 'products';
protected $fillable = [
		'id',
		'admin_id',
        'name',
        'price',
        'category_id',

        'image',
        'description',
		'created_at',
		'updated_at',
	];

	/**
    * category_id relation method
    * @param void
    * @return object data
    */
   public function category_id(){
      return $this->hasOne(\App\Models\category::class,'id','category_id');
   }

 	/**
    * Static Boot method to delete or update or sort Data
    * @param void
    * @return void
    */
   protected static function boot() {
      parent::boot();
      // if you disable constraints should by run this static method to Delete children data
         static::deleting(function($product) {
			//$product->category_id()->delete();
         });
   }
		
}
