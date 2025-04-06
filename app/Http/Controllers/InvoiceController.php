<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class InvoiceController extends Controller {
    public function InvoiceCreate( Request $request ) {
        DB::beginTransaction();
        try {
            $user_id = $request->header( 'id' );
            $data = [
                'user_id'     => $user_id,
                'customer_id' => $request->customer_id,
                'total'       => $request->total,
                'vat'         => $request->vat,
                'payable'     => $request->payable,
                'discount'    => $request->discount,

            ];
            $invoice = Invoice::create( $data );
            $products = $request->input( 'products' );
            foreach ( $products as $product ) {
                $existUnit = Product::where( 'id', $product['id'] )->first();
                if ( !$existUnit ) {
                    return response()->json( [
                        'status'  => 'Error',
                        'message' => "Product woth ID {$product['id']} Not Found",
                    ] );

                }
                if ( $existUnit->unit < $product['unit'] ) {
                    return response()->json( [
                        'status'  => 'Error',
                        'message' => "Only {$existUnit->unit} Unit Available",
                    ] );
                }
                InvoiceProduct::create( [
                    'invoice_id' => $invoice->id,
                    'product_id' => $product['id'],
                    'user_id'    => $user_id,
                    'qty'        => $product['unit'],
                    'sale_price' => $product['price'],

                ] );
                Product::where( 'id', $product['id'] )->update( [
                    'unit' => $existUnit->unit - $product['unit'],
                ] );
            }

            DB::commit();
            // return response()->json( [
            //     'status'  => 'Success',
            //     'message' => 'Invoice Created Successfully',
            // ] );
            $data = ['message' => 'Invoice created successfully', 'status' => true, 'error' => ''];
            return redirect( '/InvoiceListPage' )->with( $data );

        } catch ( \Exception $e ) {
            DB::rollBack();
            // return response()->json( [
            //     'status'  => 'Failed',
            //     'message' => $e->getMessage(),
            // ] );
            $data = ['message' => 'Something went wrong', 'status' => false, 'error' => $e->getMessage()];
            return redirect()->back()->with( $data );
        }
    }
    public function InvoiceList() {
        $user_id = request()->header( 'id' );
        $invoices = Invoice::with( 'customer' )->where( 'user_id', $user_id )->get();
        return $invoices;
    }

    public function InvoiceDetails( Request $request ) {
        $user_id = $request->header( 'id' );

        $customerDetails = Customer::where( 'user_id', $user_id )->where( 'id', $request->customer_id )->first();
        $invoiceDetails = Invoice::where( 'user_id', $user_id )->where( 'id', $request->invoice_id )->first();
        $invoiceProducts = InvoiceProduct::where( 'invoice_id', $request->invoice_id )->with( 'product' )->get();
        return [
            'customerDetails' => $customerDetails,
            'invoiceDetails'  => $invoiceDetails,
            'invoiceProducts' => $invoiceProducts,
        ];

    }
    public function InvoiceDelete( Request $request, $id ) {
        DB::beginTransaction();
        try {
            $user_id = $request->header( 'id' );
            InvoiceProduct::where( "invoice_id", $id )->where( "user_id", $user_id )->delete();
            Invoice::where( 'user_id', $user_id )->where( 'id', $id )->delete();
            DB::commit();
            // return response()->json( [
            //     'status'  => 'Success',
            //     'message' => 'Invoice Deleted Successfully',
            // ] );
            $data = ['message' => 'Invoice deleted successfully', 'status' => true, 'error' => ''];
            return redirect()->back()->with( $data );
        } catch ( \Exception $e ) {
            DB::rollBack();
            // return response()->json( [
            //     'status'  => 'Failed',
            //     'message' => $e->getMessage(),
            // ] );
            $data = ['message' => 'Something went wrong', 'status' => false, 'error' => $e->getMessage()];
            return redirect()->back()->with( $data );
        }
    }

    public function InvoiceListPage( Request $request ) {
        $user_id = request()->header( 'id' );
        $list = Invoice::where( 'user_id', $user_id )
            ->with( 'customer', 'invoiceProduct.product' )->get();
        return Inertia::render( 'InvoiceListPage', ['list' => $list] );
    }
}
