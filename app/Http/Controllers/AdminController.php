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
                if ($data['type'] == 'Admin') {
                    $admin->type = !empty($data['type']) ? $data['type'] : null;
                    $admin->username = !empty($data['username']) ? $data['username'] : null;
                    $admin->password = !empty($data['password']) ? md5($data['password']) : null;
                    $admin->status = !empty($data['status']) ? $data['status'] : null;
                    $admin->save();
                    return redirect()->back()->with('flash_message_success', 'Admin added successfully.');
                } else if ($data['type'] == 'Sub Admin') {
                    $admin->type = !empty($data['type']) ? $data['type'] : null;
                    $admin->username = !empty($data['username']) ? $data['username'] : null;
                    $admin->password = !empty($data['password']) ? md5($data['password']) : null;
                    $admin->status = !empty($data['status']) ? $data['status'] : null;
                    $admin->categories_view_access = !empty($data['categories_view_access']) ? $data['categories_view_access'] : 0;
                    $admin->categories_edit_access = !empty($data['categories_edit_access']) ? $data['categories_edit_access'] : 0;
                    if(empty($data['categories_full_access'])) {
                        $admin->categories_full_access = 0;
                    } else {
                        if($data['categories_full_access'] == 1) {
                            $admin->categories_view_access = 1;
                            $admin->categories_edit_access = 1; 
                            $admin->categories_full_access = 1; 
                        }
                    }

                    $admin->products_view_access = !empty($data['products_view_access']) ? $data['products_view_access'] : 0;
                    $admin->products_edit_access = !empty($data['products_edit_access']) ? $data['products_edit_access'] : 0;
                    if(empty($data['products_full_access'])) {
                        $admin->products_full_access = 0;
                    } else {
                        if($admin['products_full_access'] == 1) {
                            $admin->products_view_access = 1;
                            $admin->products_edit_access = 1; 
                            $admin->products_full_access = 1; 
                        }
                    }

                    $admin->orders_view_access = !empty($data['orders_view_access']) ? $data['orders_view_access'] : 0;
                    $admin->orders_edit_access = !empty($data['orders_edit_access']) ? $data['orders_edit_access'] : 0;
                    if(empty($data['orders_full_access'])) {
                        $admin->orders_full_access = 0;
                    } else {
                        if($data['orders_full_access'] == 1) {
                            $admin->orders_view_access = 1;
                            $admin->orders_edit_access = 1; 
                            $admin->orders_full_access = 1; 
                        }
                    }

                    $admin->users_view_access = !empty($data['users_view_access']) ? $data['users_view_access'] : 0;
                    $admin->users_edit_access = !empty($data['users_edit_access']) ? $data['users_edit_access'] : 0;
                    if(empty($admin->users_full_access)) {
                        $admin->users_full_access = 0;
                    } else {
                        if($admin->users_full_access == 1) {
                            $admin->users_view_access = 1;
                            $admin->users_edit_access = 1; 
                            $admin->users_full_access = 1; 
                        }
                    }

                    $admin->save();
                    return redirect()->back()->with('flash_message_success', 'Sub-Admin added successfully.');
                }
            }
        }
        return view('admin.admins.add_admins');
    }

    public function editAdmins(Request $request,$id){
        $adminDetails = Admin::where('id',$id)->first();

		if($request->isMethod('post')){
            $data = $request->all();
            
            /* echo "<pre>"; print_r($data); die; */
            if(empty($data['status'])) {
                $data['status'] = 0;
            }
            if ($data['type'] == 'Admin') {
                Admin::where('username',$data['username'])->update(['password' =>md5($data['password']), 'status' => $data['status'] ]);
                return redirect()->back()->with('flash_message_success', 'Admin edited successfully.');
            } else if ($data['type'] == 'Sub Admin') {
                
                $data['categories_view_access'] = !empty($data['categories_view_access']) ? $data['categories_view_access'] : 0;
                $data['categories_edit_access'] = !empty($data['categories_edit_access']) ? $data['categories_edit_access'] : 0;
                if(empty($data['categories_full_access'])) {
                    $data['categories_full_access'] = 0;
                } else {
                    if($data['categories_full_access'] == 1) {
                        $data['categories_view_access'] = 1;
                        $data['categories_edit_access'] = 1; 
                    }
                }

                $data['products_view_access'] = !empty($data['products_view_access']) ? $data['products_view_access'] : 0;
                $data['products_edit_access'] = !empty($data['products_edit_access']) ? $data['products_edit_access'] : 0;
                if(empty($data['products_full_access'])) {
                    $data['products_full_access'] = 0;
                } else {
                    if($data['products_full_access'] == 1) {
                        $data['products_view_access'] = 1;
                        $data['products_edit_access'] = 1; 
                    }
                }

                $data['orders_view_access'] = !empty($data['orders_view_access']) ? $data['orders_view_access'] : 0;
                $data['orders_edit_access'] = !empty($data['orders_edit_access']) ? $data['orders_edit_access'] : 0;
                if(empty($data['orders_full_access'])) {
                    $data['orders_full_access'] = 0;
                } else {
                    if($data['orders_full_access'] == 1) {
                        $data['orders_view_access'] = 1;
                        $data['orders_edit_access'] = 1; 
                    }
                }

                $data['users_view_access'] = !empty($data['users_view_access']) ? $data['users_view_access'] : 0;
                $data['users_edit_access'] = !empty($data['users_edit_access']) ? $data['users_edit_access'] : 0;
                if(empty($data['users_full_access'])) {
                    $data['users_full_access'] = 0;
                } else {
                    if($data['users_full_access'] == 1) {
                        $data['users_view_access'] = 1;
                        $data['users_edit_access'] = 1; 
                    }
                }

                Admin::where('username',$data['username'])->update([ 
                    'password' => md5($data['password']), 
                    'status' => $data['status'],
                    'categories_view_access' => $data['categories_view_access'],
                    'categories_edit_access' => $data['categories_edit_access'],
                    'categories_full_access' => $data['categories_full_access'],

                    'products_view_access' => $data['products_view_access'],
                    'products_edit_access' => $data['products_edit_access'],
                    'products_full_access' => $data['products_full_access'],

                    'orders_view_access' => $data['orders_view_access'],
                    'orders_edit_access' => $data['orders_edit_access'],
                    'orders_full_access' => $data['orders_full_access'],

                    'users_view_access' => $data['users_view_access'],
                    'users_edit_access' => $data['users_edit_access'],
                    'users_full_access' => $data['users_full_access'],
                ]);
                return redirect()->back()->with('flash_message_success', 'Sub-Admin edited successfully.');
            }

		}
		$adminDetails = Admin::where('id',$id)->first();
		return view('admin.admins.edit_admins')->with(compact('adminDetails'));
    }

    public function deleteAdmins($id){
        Admin::where('id',$id)->delete();
        return redirect()->back()->with('flash_message_success','Admins/Sub-Admins has been deleted successfully!');
	}
}
