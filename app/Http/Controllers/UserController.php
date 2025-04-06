<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller {
    public function UserRegistration( Request $request ) {
        try {
            $request->validate( [
                'name'     => 'required',
                'email'    => 'required|email|unique:users,email',
                'mobile'   => 'required',
                'password' => 'required',
            ] );
            $user = User::create( [
                'name'     => $request->input( 'name' ),
                'email'    => $request->input( 'email' ),
                'mobile'   => $request->input( 'mobile' ),
                'password' => $request->input( 'password' ),
            ] );
            // return response()->json( [
            //     'status'  => "Success",
            //     'message' => 'User Created Successfully',
            //     'data'    => $user,
            // ] );

            $data = [
                'message' => 'User Created Successfully', 'status' => true,
                'error'   => ''];
            return redirect( '/login' )->with( $data );
        } catch ( \Exception $e ) {
            // return response()->json( [
            //     'status'  => "Error",
            //     'message' => $e->getMessage(),
            // ] );

            $data = [
                'message' => 'Something went wrong', 'status' => false,
                'error'   => '',
            ];
            return redirect( '/registration' )->with( $data );

        }
    }

    public function UserLogin( Request $request ) {
        $count = User::where( 'email', $request->input( 'email' ) )->where( 'password', $request->input( 'password' ) )->select( 'id' )->first();
        if ( $count !== null ) {
            // User login -> JWt token issue
            // $token = JWTToken::CreateToken( $request->input( 'email' ), $count->id )
            // return response()->json( [
            //     'status'  => "Success",
            //     'message' => 'User Login Successfully',
            //     'token'   => $token,
            // ], 200 )->cookie( 'token', $token, 60 * 60 * 24 );

            $email = $request->input( 'email' );
            $user_id = $count->id;
            $request->session()->put( 'email', $email );
            $request->session()->put( 'user_id', $user_id );

            $data = [
                'message' => 'User Login Successfully', 'status' => true,
                'error'   => '',
            ];
            return redirect( '/DashboardPage' )->with( $data );
        } else {
            // return response()->json( [
            //     'status'  => "Error",
            //     'message' => 'Unauthorized',
            // ], 500 );
            $data = [
                'message' => 'Login Failed', 'status' => false,
                'error'   => '',
            ];
            return redirect( '/login' )->with( $data );
        }
    }
    public function DashboardPage( Request $request ) {
        // $user = $request->header( 'email' );
        // return response()->json( [
        //     'status'  => "Success",
        //     'message' => 'User Login Successfully',
        //     'user'    => $user,
        // ], 200 );

        $user_id = request()->header( 'id' );

        $product = Product::where( 'user_id', $user_id )->count();
        $category = Category::where( 'user_id', $user_id )->count();
        $customer = Customer::where( 'user_id', $user_id )->count();
        $invoice = Invoice::where( 'user_id', $user_id )->count();
        $total = Invoice::where( 'user_id', $user_id )->sum( 'total' );
        $vat = Invoice::where( 'user_id', $user_id )->sum( 'vat' );
        $payable = Invoice::where( 'user_id', $user_id )->sum( 'payable' );
        $discount = Invoice::where( 'user_id', $user_id )->sum( 'discount' );

        $data = [
            'product'  => $product,
            'category' => $category,
            'customer' => $customer,
            'invoice'  => $invoice,
            'total'    => round( $total ),
            'vat'      => round( $vat ),
            'payable'  => round( $payable ),
            'discount' => $discount,
        ];

        return Inertia::render( 'DashboardPage', ['list' => $data] );
    }

    public function UserLogout( Request $request ) {
        // return response()->json( [
        //     'status'  => "Success",
        //     'message' => 'User Logout Successfully',
        // ], 200 )->cookie( 'token', '', -1 );

        $request->session()->forget( 'email' );
        $request->session()->forget( 'user_id' );
        $data = [
            'message' => 'User Logout Successfully', 'status' => true,
            'error'   => '',
        ];
        return redirect( '/login' )->with( $data );
    }
    public function SendOTPCode( Request $request ) {
        $email = $request->input( 'email' );
        $otp = rand( 1000, 9999 );
        $count = User::where( 'email', $email )->count();
        if ( $count > 0 ) {
            // Mail::to($email)->send(new OTPMail($otp));
            User::where( 'email', $email )->update( ['otp' => $otp] );
            $request->session()->put( 'email', $email );
            // return response()->json([
            //     'status' => 'success',
            //     'message' => "4 Digit {$otp} OTP send successfully",
            // ],200);

            $data = ["message" => "4 Digit {$otp} OTP send successfully", "status" => true, "error" => ''];
            return redirect( '/verify-otp' )->with( $data );
        } else {
            // return response()->json([
            //     'status' => 'fail',
            //     'message' => 'unauthorized'
            // ]);

            $data = ['message' => 'unauthorized', 'status' => false, 'error' => ''];
            return redirect( '/registration' )->with( $data );
        }
    }

    public function VerifyOTPCode( Request $request ) {
        // $email = $request->input('email');
        $email = $request->session()->get( 'email' );
        $otp = $request->input( 'otp' );

        $count = User::where( 'email', $email )->where( 'otp', $otp )->count();

        if ( $count == 1 ) {
            User::where( 'email', $email )->update( ['otp' => 0] );

            // $token = JWTToken::CreateTokenForSetPassword($request->input('email'));

            $request->session()->put( 'otp_verify', 'yes' );

            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'OTP verification successfully',
            // ],200)->cookie('token', $token, 60 * 24 * 30);

            $data = ["message" => "OTP verification successfully", "status" => true, "error" => ''];
            return redirect( '/reset-password' )->with( $data );
        } else {
            // return response()->json([
            //     'status' => 'fail',
            //     'message' => 'unauthorized'
            // ]);
            $data = ['message' => 'unauthorized', 'status' => false, 'error' => ''];
            return redirect( '/login' )->with( $data );
        }
    }
    public Function ResetPassword( Request $request ) {
        try {
            // $email = $request->header('email');
            $email = $request->session()->get( 'email', 'default' );
            $password = $request->input( 'password' );

            $otp_verify = $request->session()->get( 'otp_verify', 'default' );
            if ( $otp_verify === 'yes' ) {
                User::where( 'email', $email )->update( ['password' => $password] );
                $request->session()->flush();

                $data = ['message' => 'Password reset successfully', 'status' => true, 'error' => ''];
                return redirect( '/login' )->with( $data );
            } else {
                $data = ['message' => 'Request fail', 'status' => false, 'error' => ''];
                return redirect( '/reset-password' )->with( $data );
            }
            // return response()->json([
            //     'status' => 'success',
            //     'message' => 'Password reset successfully',
            // ],200);

        } catch ( Exception $e ) {
            // return response()->json([
            //     'status' => 'fail',
            //     'message' => 'somthing went wrong'
            // ]);
            $data = ['message' => $e->getMessage(), 'status' => false, 'error' => ''];
            return redirect( '/reset-password' )->with( $data );
        }
    }

    // Method for pages
    public function LoginPage() {
        return Inertia::render( 'LoginPage' );
    }
    public function RegistrationPage() {
        return Inertia::render( 'RegistrationPage' );
    }
    public function SendOTPPage() {
        return Inertia::render( 'SendOTPPage' );
    }
    public function VerifyOTPPage() {
        return Inertia::render( 'VerifyOTPPage' );
    }
    public function ResetPasswordPage() {
        return Inertia::render( 'ResetPasswordPage' );
    }

    public function ProfilePage( Request $request ) {
        $email = request()->header( 'email' );

        $user = User::where( 'email', $email )->first();
        return Inertia::render( 'ProfilePage', ['user' => $user] );
    }

    public function UserUpdate( Request $request ) {
        $email = request()->header( 'email' );
        User::where( 'email', $email )->update( [
            'name'   => $request->input( 'name' ),
            'email'  => $request->input( 'email' ),
            'mobile' => $request->input( 'mobile' ),
        ] );
        $data = ['message' => 'Profile update successfully', 'status' => true, 'error' => ''];
        return redirect()->back()->with( $data );
    }
}
