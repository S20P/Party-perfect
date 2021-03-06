<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\Services;
use App\Models\SupplierDetailsSlider;

class Supplier_services extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'supplier_services';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ['supplier_id','service_id','business_name','service_description','location','price_range','status','facebook_link','facebook_title','instagram_link','instagram_title','featured'];
    // protected $hidden = [];
    // protected $dates = [];

    protected $casts = [
        'location' => 'array',
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    public function getLocation() {

        $response = "";
        
        if($this->location!==null){
        $location_result =  Location::whereIn('id',$this->location)->select('location_name')->get();
      
        $locations = [];
        if($location_result &&  $location_result!=null){
        if(count($location_result)){
            foreach($location_result as $location){
               if($location != null){
                array_push($locations,$location->location_name);
               }
            }
        }   
      }

      if(count($locations)>0){
        $response = implode(",<br>",$locations);
      }
     else{
      $response = "";
     }

    }
     return $response;

       // return json_encode(implode(",",$locations));

      //$locations = json_encode($locations);
      // dd(implode(",",$locations));
     }

     public function getSupplier() {
        $name = "";
        $response = Supplier::where('id',$this->supplier_id)->value('name');
        if($response &&  $response!=null){
          $name =  $response; 
        }
        return $name;
     }

     public function getServices() {
      $name = "";
      $response = Services::where('id',$this->service_id)->value('name');
        if($response &&  $response!=null){
          $name =  $response; 
        }
        return $name;
     }
     
     public function price_range_display() {

        // 'options' =>[1=>"Low",2=>"Medium",3=>"High"],

          $price_range_callback = "";
          if($this->price_range==1){
            $price_range_callback = "Low";  
          }
          if($this->price_range==2){
            $price_range_callback = "Medium";  
          }
          if($this->price_range==3){
            $price_range_callback = "High";  
          }

        return $price_range_callback;
     }
     

     

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */


    public function Location()
    {
        return $this->hasOne('App\Models\Location','id');
    }
    
    public function Supplier()
    {
        return $this->hasOne('App\Models\Supplier','id');
    }

    public function Services()
    {
        return $this->hasOne('App\Models\Services','id');
    }

  


    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
