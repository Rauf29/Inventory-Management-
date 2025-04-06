<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerController extends Controller {
    public function CreateCustomer( Request $request ) {
        $user_id = $request->header( 'id' );
        $request->validate( [
            'name'   => 'required',
            'email'  => 'required|email|unique:users,email',
            'mobile' => 'required',
        ] );
        Customer::create( [
            'user_id' => $user_id,
            'name'    => $request->name,
            'email'   => $request->email,
            'mobile'  => $request->mobile,
        ] );
        // return response()->json( [
        //     'status'  => 'Success',
        //     'message' => 'Customer Created Successfully',
        // ], 200 );
        $data = ['message' => 'Customer created successfully', 'status' => true, 'error' => ''];
        return redirect( '/CustomerPage' )->with( $data );
    }
    public function CustomerList( Request $request ) {
        $user_id = $request->header( 'id' );
        $customers = Customer::where( 'user_id', $user_id )->get();
        return $customers;
    }

    public function CustomerById( Request $request ) {
        $user_id = $request->header( 'id' );
        $customer = Customer::where( 'user_id', $user_id )->where( 'id', $request->id )->first();
        return $customer;
    }
    public function CustomerUpdate( Request $request ) {
        $user_id = $request->header( 'id' );
        $customer = Customer::where( 'user_id', $user_id )->where( 'id', $request->id )->update( [
            'name'   => $request->input( 'name' ),
            'email'  => $request->input( 'email' ),
            'mobile' => $request->input( 'mobile' ),
        ] );
        // return response()->json( [
        //     'status'  => 'Success',
        //     'message' => 'Customer Updated Successfully',
        // ] );
        $data = ['message' => 'Customer updated successfully', 'status' => true, 'error' => ''];
        return redirect( '/CustomerPage' )->with( $data );
    }
    public function CustomerDelete( Request $request, $id ) {
        $user_id = $request->header( 'id' );
        Customer::where( 'user_id', $user_id )->where( 'id', $id )->delete();
        // return response()->json( [
        //     'status'  => 'Success',
        //     'message' => 'Customer Deleted Successfully',
        // ] );
        $data = ['message' => 'Customer Deleted successfully', 'status' => true, 'error' => ''];
        return redirect( '/CustomerPage' )->with( $data );
    }

    public function CustomerPage( Request $request ) {
        $user_id = $request->header( 'id' );
        $customers = Customer::where( 'user_id', $user_id )->get();
        return Inertia::render( 'CustomerPage', ['customers' => $customers] );
    }

    public function CustomerSavePage( Request $request ) {
        $user_id = $request->header( 'id' );
        $id = $request->query( 'id' );
        $customer = Customer::where( 'id', $id )->where( 'user_id', $user_id )->first();
        return Inertia::render( 'CustomerSavePage', ['customer' => $customer] );
    }

}
