<?php

namespace App\Http\Middleware;

use App\Admin;
use Closure;
use Illuminate\Support\Facades\Route;
use Session;

class Adminlogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(empty(Session::has('adminSession'))){
            return redirect('/admin');
        } else {
            // Get Admin/Sub-Admin Details
            $adminDetails = Admin::where('username', Session::get('adminSession'))->first()->toArray();

            if( $adminDetails['type'] == "Admin" ) {
                $adminDetails['categories_access'] = 1;
                $adminDetails['products_access'] = 1;
                $adminDetails['orders_access'] = 1;
                $adminDetails['users_access'] = 1;
            }
            Session::put('adminDetails', $adminDetails);

            //Get current Path
            $currentPath = Route::getFacadeRoot()->current()->uri();

            if( $currentPath == 'admin/view-categories' && Session::get('adminDetails')['categories_access'] == 0 ) {
                return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module!');
            }
            if( $currentPath == 'admin/add-category' && Session::get('adminDetails')['categories_access'] == 0 ) {
                return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module!');
            }
            if( $currentPath == 'admin/view-products' && Session::get('adminDetails')['products_access'] == 0 ) {
                return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module!');
            }
            if( $currentPath == 'admin/add-products' && Session::get('adminDetails')['products_access'] == 0 ) {
                return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module!');
            }
            if( $currentPath == 'admin/view-orders' && Session::get('adminDetails')['orders_access'] == 0 ) {
                return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module!');
            }
            if( $currentPath == 'admin/view-orders-charts' && Session::get('adminDetails')['orders_access'] == 0 ) {
                return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module!');
            }
            if( $currentPath == 'admin/view-order-invoice' && Session::get('adminDetails')['orders_access'] == 0 ) {
                return redirect('/admin/dashboard')->with('flash_message_error', 'You have no access for this module!');
            }
        }
        return $next($request);
    }
}
