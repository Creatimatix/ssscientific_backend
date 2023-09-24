<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::with('parentCategory')->get()->all();
        return view('admin.category.index',[
            'categories' => $categories
        ]);
    }

    public function create(){
        $parentCategories = Category::where('status', 1)->get()->all();
        return view('admin.category.create',[
            'parentCategories' => $parentCategories
        ]);
    }
    public function store(Request $request){
        $category_name = $request->get('category_name');
        $id_parent = $request->get('id_parent');
        $status = $request->get('status');

        $request->validate([
            'category_name' => 'required|unique:categories,category_name',
            'status' => 'required'
        ]);

        $category = new Category();
        $category->category_name = $category_name;
        $category->id_parent = $id_parent;
        $category->status = $status;
        $category->save();
        return redirect()->route('categories')->with('categorySuccessMsg','Category Created Successfully.');
    }

    public function edit(Request $request,$category = null){
        $catData = Category::where('id',$category)->with('parentCategory')->get()->first();
        $parentCategories = Category::where('status', 1)->where('id','!=', $category)->get()->all();
        if($catData){
            return view('admin.category.edit',[
                'category' => $catData,
                'parentCategories' => $parentCategories
            ]);
        }
    }

    public function update(Request $request){
        $category_id = $request->get('id_category');
        $category_name = $request->get('category_name');
        $id_parent = $request->get('id_parent');
        $status = $request->get('status');

        $category = Category::where('id',$category_id)->get()->first();

        if(!$category){
            return redirect()->route('categories')->with('categoryErrorMsg','Invalid request.');
        }

        $request->validate([
            'category_name' => 'required|unique:categories,category_name,'.$category_id,
            'status' => 'required'
        ]);

        $category->category_name = $category_name;
        $category->id_parent = $id_parent;
        $category->status = $status;
        $category->save();
        return redirect()->back()->with('categorySuccessMsg','Category updated Successfully.');
    }

    public function destroy(Category $category){
        if($category){
            $category->delete();
            return redirect()->back()->with('categorySuccessMsg','Record Deleted Successfully.');
        }else{
            return redirect()->back()->with('categoryErrorMsg','Invalid request.');
        }
    }
}
