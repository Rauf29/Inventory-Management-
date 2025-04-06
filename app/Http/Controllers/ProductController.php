<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller {
    public function CreateProduct( Request $request ) {
        $user_id = $request->header( 'id' );
        $request->validate( [
            'name'        => 'required',
            'category_id' => 'required',
            'price'       => 'required',
            'unit'        => 'required',
            "image"       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ] );
        $data = [
            'name'        => $request->input( 'name' ),
            'category_id' => $request->input( 'category_id' ),
            'user_id'     => $user_id,
            'price'       => $request->input( 'price' ),
            'unit'        => $request->input( 'unit' ),
        ];
        if ( $request->hasFile( 'image' ) ) {
            $image = $request->file( 'image' );
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $filePath = 'uploads/' . $fileName;
            $image->move( public_path( 'uploads' ), $fileName );
            $data['image'] = $filePath;
        }
        $product = Product::create( $data );
        // return response()->json( [
        //     'status'  => 'Success',
        //     'message' => 'Product Created Successfully',
        //     'data'    => $product,
        // ] );

        $data = ['message' => 'Product created successfully', 'status' => true, 'error' => ''];
        return redirect( '/ProductPage' )->with( $data );
    }

    public function ProductList( Request $request ) {
        $user_id = $request->header( 'id' );
        $products = Product::where( 'user_id', $user_id )->get();
        return response()->json( [
            'data' => $products,
        ] );
    }
    public function ProductById( Request $request ) {
        $user_id = $request->header( 'id' );
        $product = Product::where( 'user_id', $user_id )->where( 'id', $request->id )->first();
        return $product;
    }
    public function ProductUpdate( Request $request ) {
        $user_id = $request->header( 'id' );

        $request->validate( [
            'name'        => 'required',
            'category_id' => 'required',
            'price'       => 'required',
            'unit'        => 'required',

        ] );

        $product = Product::where( 'user_id', $user_id )->findOrFail( $request->id );

        $product->name = $request->input( 'name' );
        $product->category_id = $request->input( 'category_id' );
        $product->price = $request->input( 'price' );
        $product->unit = $request->input( 'unit' );

        if ( $request->hasFile( 'image' ) ) {
            if ( $product->image && file_exists( public_path( $product->image ) ) ) {
                unlink( public_path( $product->image ) );
            }
            $request->validate( [
                "image" => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ] );
            $image = $request->file( 'image' );
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $filePath = 'uploads/' . $fileName;
            $image->move( public_path( 'uploads' ), $fileName );
            $product->image = $filePath;
        }

        $product->save();

        // return response()->json( [
        //     'status'  => 'Success',
        //     'message' => 'Product Updated Successfully',
        //     'data'    => $product,
        // ] );

        $data = ['message' => 'Product updated successfully', 'status' => true, 'error' => ''];
        return redirect( '/ProductPage' )->with( $data );
    }
    public function ProductDelete( Request $request, $id ) {
        try {
            // $user_id = $request->header('id');
            $product = Product::findOrFail( $id );
            if ( $product->image && file_exists( public_path( $product->image ) ) ) {
                unlink( public_path( $product->image ) );
            }

            $product->delete();
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Product Deleted successfully'
            // ]);
            $data = ['message' => 'Product Deleted successfully', 'status' => true, 'error' => ''];
            return redirect()->back()->with( $data );
        } catch ( Exception $e ) {
            // return response()->json([
            //     'status' => 'failed',
            //     'message' => $e->getMessage()
            // ]);
            $data = ['message' => 'Something went wrong', 'status' => false, 'error' => $e->getMessage()];
            return redirect()->back()->with( $data );
        }

    }

    public function ProductPage( Request $request ) {
        $user_id = $request->header( 'id' );
        $products = Product::where( 'user_id', $user_id )
            ->with( 'category' )->latest()->get();
        return Inertia::render( 'ProductPage', ['products' => $products] );
    }

    public function ProductSavePage( Request $request ) {
        $user_id = $request->header( 'id' );
        $product_id = $request->query( 'id' );
        $product = Product::where( 'id', $product_id )->where( 'user_id', $user_id )->first();
        $categories = Category::where( 'user_id', $user_id )->get();
        return Inertia::render( 'ProductSavePage', ['product' => $product, 'categories' => $categories] );
    }
}
