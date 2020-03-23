<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\User;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(Request $request)
    {
        if (!empty(Session::has('adminSession'))) {
            return redirect()->back();
        }
        if ($request->isMethod('post')) {
            $data = $request->input();
            $adminCount = Admin::where(['username' => $data['username'], 'password' => md5($data['password']), 'status' => 1])->count();
            if ($adminCount > 0) {
                //echo "Success"; die;
                Session::put('adminSession', $data['username']);
                return redirect('/admin/dashboard');
            } else {
                //echo "failed"; die;
                return redirect('/admin')->with('flash_message_error', 'Invalid Username or Password');
            }
        }
        return view('admin.admin_login');
    }

    public function dashboard()
    {
        /*if(Session::has('adminSession')){
            // Perform all actions
        }else{
            //return redirect()->action('AdminController@login')->with('flash_message_error', 'Please Login');
            return redirect('/admin')->with('flash_message_error','Please Login');
        }*/
        return view('admin.dashboard');
    }

    public function settings()
    {

        $adminDetails = Admin::where(['username' => Session::get('adminSession')])->first();

        //echo "<pre>"; print_r($adminDetails); die;

        return view('admin.settings')->with(compact('adminDetails'));
    }

    public function chkPassword(Request $request)
    {
        $data = $request->all();
        //echo "<pre>"; print_r($data); die;
        $adminCount = Admin::where(['username' => Session::get('adminSession'), 'password' => md5($data['current_pwd'])])->count();
        if ($adminCount == 1) {
            //echo '{"valid":true}';die;
            echo "true";
            die;
        } else {
            //echo '{"valid":false}';die;
            echo "false";
            die;
        }
    }

    public function updatePassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $adminCount = Admin::where(['username' => Session::get('adminSession'), 'password' => md5($data['current_pwd'])])->count();

            if ($adminCount == 1) {
                // here you know data is valid
                $password = md5($data['new_pwd']);
                Admin::where('username', Session::get('adminSession'))->update(['password' => $password]);
                return redirect('/admin/settings')->with('flash_message_success', 'Password updated successfully.');
            } else {
                return redirect('/admin/settings')->with('flash_message_error', 'Current Password entered is incorrect.');
            }
        }
    }

    public function logout()
    {
        Session::flush();
        return redirect('/admin')->with('flash_message_success', 'Logged out successfully.');
    }

    public function viewAdmins()
    {
        $admins = Admin::get();
        $admins = json_decode(json_encode($admins));

        return view('admin.admins.view_admins')->with(compact('admins'));
    }

    public function addAdmins(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            $adminCount = Admin::where(['username' => $data['username']])->count();
            if ($adminCount > 0) {
                return redirect()->back()->with('flash_message_error', 'Admin Username already exists! Please choose another.');
            } else {
                $admin = new Admin;
                if($data['type'] == 'Admin') {
                    $admin->type = isset($data['type']) ? $data['type'] : null;
                    $admin->username = isset($data['username']) ? $data['username'] : null;
                    $admin->password = isset($data['password']) ? md5($data['password']) : null;
                    $admin->status = isset($data['status']) ? $data['status'] : null;
                    $admin->save();
                    return redirect()->back()->with('flash_message_success', 'Admin added successfully.');
                } else if($data['type'] == 'Sub Admin') {
                    $admin->type = isset($data['type']) ? $data['type'] : null;
                    $admin->username = isset($data['username']) ? $data['username'] : null;
                    $admin->password = isset($data['password']) ? md5($data['password']) : null;
                    $admin->status = isset($data['status']) ? $data['status'] : null;
                    $admin->categories_access = isset($data['categories_access']) ? $data['categories_access'] : 0;
                    $admin->products_access = isset($data['products_access']) ? $data['products_access'] : 0;
                    $admin->orders_access = isset($data['orders_access']) ? $data['orders_access'] : 0;
                    $admin->users_access = isset($data['users_access']) ? $data['users_access'] : 0;
                    $admin->save();
                    return redirect()->back()->with('flash_message_success', 'Sub-Admin added successfully.');
                }
            }
        }
        return view('admin.admins.add_admins');
    }
}
