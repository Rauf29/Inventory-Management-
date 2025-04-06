<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller {
    public function CreateCategory( Request $request ) {
        $user_id = $request->header( 'id' );
        Category::create( [
            'name'    => $request->name,
            'user_id' => $user_id,
        ] );
        // return response()->json( [
        //     'status'  => 'Success',
        //     'message' => 'Category Created Successfully',
        // ], 200 );
        $data = [
            'message' => 'Category Created Successfully', 'status' => true,
            'error'   => '',
        ];
        return redirect( '/CategoryPage' )->with( $data );
    }
    public function CategoryList( Request $request ) {
        $user_id = $request->header( 'id' );
        $categories = Category::where( 'user_id', $user_id )->get();
        return $categories;
    }

    public function CategoryById( Request $request ) {
        $user_id = $request->header( 'id' );
        $category = Category::where( 'user_id', $user_id )->where( 'id', $request->id )->first();
        return $category;
    }
    public function CategoryUpdate( Request $request ) {
        $user_id = $request->header( 'id' );
        $category = Category::where( 'user_id', $user_id )->where( 'id', $request->id )->update( [
            'name' => $request->name,
        ] );
        // return response()->json( [
        //     'status'  => 'Success',
        //     'message' => 'Category Updated Successfully',
        // ] );
        $data = ['message' => 'Category Updated Successfully', 'status' => true, 'error' => ''];
        return redirect( '/CategoryPage' )->with( $data );
    }
    public function CategoryDelete( Request $request, $id ) {
        $user_id = $request->header( 'id' );
        Category::where( 'user_id', $user_id )->where( 'id', $id )->delete();
        // return response()->json( [
        //     'status'  => 'Success',
        //     'message' => 'Category Deleted Successfully',
        // ] );
        $data = ['message' => 'Category Deleted Successfully', 'status' => true, 'error' => ''];
        return redirect( '/CategoryPage' )->with( $data );
    }
    public function CategorySavePage( Request $request ) {
        $category_id = $request->query( 'id' );
        $user_id = $request->header( 'id' );
        $category = Category::where( 'id', $category_id )->where( 'user_id', $user_id )->first();
        return Inertia::render( 'CategorySavePage', ['category' => $category] );
    }

    // pages
    public function CategoryPage( Request $request ) {
        $user_id = $request->header( 'id' );
        $categories = Category::where( 'user_id', $user_id )->get();
        return Inertia::render( 'CategoryPage', [
            'categories' => $categories,
        ] );
    }
}
