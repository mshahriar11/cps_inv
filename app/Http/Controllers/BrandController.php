<?php

namespace App\Http\Controllers;

use App\Brand;
use Exception;
use Illuminate\Http\Request;

class BrandController extends Controller
{


    //brand_all function start
    public function brand_all(){
        try{
            $brands = Brand::orderBy("id","desc")->select("id","name","is_active")->paginate(10);

            return view("admin.brand.index", compact('brands'));
        }
        catch( Exception $e ){
            return back()->with('error', $e->getMessage());
        }
    } 
    //brand_all function end

    //create_brand_page function start
    public function create_brand_page(){
        try{
            return view("admin.brand.create");
        }
        catch( Exception $e ){
            return back()->with('error', $e->getMessage());
        }
    }
    //create_brand_page function end


    //create_brand function start
    public function create_brand(Request $request){
        $request->validate([
            'name' => 'required|unique:brands,name'
        ]);

        $brand = new Brand();

        $brand->name = $request->name;
        $brand->is_active = true;

        if( $brand->save() ){
            return redirect()->route('admin.brand.all')->with('success','New brand created');
        }
    } 
    //create_brand function end


    //edit_brand_page function start
    public function edit_brand_page(Request $request, $id){
        try{
            $brand = Brand::where("id", decrypt($id))->first();

            if( $brand ){
                return view("admin.brand.edit", compact('brand'));
            }
            else{
                return back()->with('warning','No brand found');
            }
        }
        catch( Exception $e ){
            return back()->with('error', $e->getMessage());
        }
    }
    //edit_brand_page function end


    //edit_brand function start
    public function edit_brand(Request $request, $id){
        $id = decrypt($id);
        $request->validate([
            'name' => 'required|unique:brands,name,'. $id,
            'is_active' => 'required'
        ]);

        $brand = Brand::find($id);

        if( $brand ){
            $brand->name = $request->name;
            $brand->is_active = $request->is_active;

            if( $brand->save() ){
                return redirect()->route('admin.brand.all')->with('success','Brand updated');
            }
        }
        else{
            return back()->with('warning','No brand found');
        }
        
    } 
    //edit_brand function end
}
