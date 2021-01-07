<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\category;
use App\Models\CategoryMenu;
use App\Models\CategoryImage;
use App\Models\menu;
use Brian2694\Toastr\Facades\Toastr;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = category::orderBy('id', 'desc')->get();
        return view('backend.pages.category.manage', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'required|max:100|mimes:jpg,jpeg,png',
        ]);
        $category = new category;

        $category->name = $request->name;
        $category->price = $request->price;

        if ($request->image) {
            $image  = $request->file('image');
            $img    = time() . Str::random(12) . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/menu/' . $img);
            Image::make($image)->save($location);
            $category->image = $img;
        }

        $category->save();
        Toastr::success('Menu Created');

        return redirect()->route('categoryShow');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = category::find($id);
        return view('backend.pages.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(category $category, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|min:0',
            'image' => 'max:100|mimes:jpg,jpeg,png',
        ]);

        $category->name = $request->name;
        $category->price = $request->price;

        if ($request->image) {
            if (File::exists('images/menu/' . $category->image)) {
                File::delete('images/menu/' . $category->image);
            }
            $image  = $request->file('image');
            $img    = time() . Str::random(12) . '.' . $image->getClientOriginalExtension();
            $location = public_path('images/menu/' . $img);
            Image::make($image)->save($location);
            $category->image = $img;
        }

        $category->save();
        Toastr::success('Menu Updated');

        return redirect()->route('categoryShow');
    }


    public function add_food_view($id)
    {
        $category = category::find($id);
        $foods = menu::orderBy('id', 'desc')->where('status',true)->get();
        return view('backend.pages.category.add_food', compact('category', 'foods'));
    }

    public function add_food(Request $request, $id)
    {
        $request->validate([
            'foods' => 'required|array',
        ]);
        $category = category::find($id);
        if ($request['foods']) :

            foreach ($request['foods'] as $food) :
                $category->menu()->attach($food);
            endforeach;

            Toastr::success('Food added to the category');
            return back();
        endif;
    }

    public function add_food_image(Request $request, $id){
        $request->validate([
            'image' => 'required|max:100|mimes:jpg,jpeg,png',
        ]);
        $category = category::find($id);
        $category_image = new CategoryImage();
        $category_image->category_id = $category->id;
        if( $request->image ){
            $image  = $request->file('image');
            $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/food/' . $img);
            Image::make($image)->save($location);
            $category_image->image = $img;
        } 
        if( $category_image->save() ){
            Toastr::success('Food image added to the menu');
            return back();
        }
    }

    public function update_food_image(Request $request,$food, $category){
        $request->validate([
            'image' => 'max:100|mimes:jpg,jpeg,png',
        ]);
        $category_food = CategoryImage::find($food);
        $category_food->category_id = $category;
        if( $request->image ){
            if( File::exists('images/food/'. $category_food->image) ){
                File::delete('images/food/'. $category_food->image);
            }
            $image  = $request->file('image');
            $img    = time() .Str::random(12). '.' . $image->getClientOriginalExtension();
            $location = public_path('images/food/' . $img);
            Image::make($image)->save($location);
            $category_food->image = $img;
        }
        if( $category_food->save() ){
            Toastr::success('Food image updated to the menu');
            return back();
        }
    }

    public function delete_food_image($food, $category){
        $category_food = CategoryImage::find($food);
        if( $category_food->image ){
            if( File::exists('images/food/'. $category_food->image) ){
                File::delete('images/food/'. $category_food->image);
            }
        }
        if( $category_food->delete() ){
            Toastr::success('Food image deleted from menu');
            return back();
        }
    }

    public function delete_food_from_category($food, $category)
    {
        $category = category::find($category);
        $category->menu()->detach($food);
        Toastr::success('Food deleted from the category');
        return back();
    }

    public function category_day(Request $request, $id){
        $category = category::find($id);

        if( $request['days'] ):
            foreach( $request['days'] as $day ):
                $category->day()->attach($day);
            endforeach;
            Toastr::success('Day added to the category');
            return back();
        endif;
    }

    public function delete_day_from_category($day, $category){
        $category = category::find($category);
        $category->day()->detach($day);
        Toastr::success('Day deleted from the category');
        return back();
    }
}
