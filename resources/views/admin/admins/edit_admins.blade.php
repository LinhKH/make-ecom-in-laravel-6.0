@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Admins</a> <a href="#" class="current">Edit Admins</a> </div>
    <h1>Admins</h1>
    @if(Session::has('flash_message_error'))
    <div class="alert alert-error alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{!! session('flash_message_error') !!}</strong>
    </div>
    @endif
    @if(Session::has('flash_message_success'))
    <div class="alert alert-success alert-block">
      <button type="button" class="close" data-dismiss="alert">×</button>
      <strong>{!! session('flash_message_success') !!}</strong>
    </div>
    @endif
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Admins / Sub-Admins</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ url('admin/edit-admins/'. $adminDetails->id) }}" name="edit_admin" id="edit_admin" novalidate="novalidate">{{ csrf_field() }}
              <div class="control-group">
                <label class="control-label">Type</label>
                <div class="controls" style="width:244px;">
                  <!-- <select name="type" id="type">
                    <option value="Admin">Admin</option>
                    <option value="Sub Admin">Sub Admin</option>
                  </select> -->
                  <input type="text" readonly name="type" id="type" value="{{ $adminDetails->type }}" >
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label">Username</label>
                <div class="controls">
                  <input type="text" name="username" id="username" value="{{ $adminDetails->username }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Password</label>
                <div class="controls">
                  <input type="password" readonly name="password" id="password" value="{{ $adminDetails->password }}">
                </div>
              </div>
              @if($adminDetails->type == 'Sub Admin')
              <div class="control-group" >
                <label class="control-label">Access</label>
                <div class="controls">
                  <input type="checkbox" name="categories_view_access" id="categories_view_access" value="1" @if($adminDetails->categories_view_access == '1') checked @endif >&nbsp;Categories View Only&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="categories_edit_access" id="categories_edit_access" value="1" @if($adminDetails->categories_edit_access == '1') checked @endif >&nbsp;Categories View And Edit Only&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="categories_full_access" id="categories_full_access" value="1" @if($adminDetails->categories_full_access == '1') checked @endif >&nbsp;Categories View, Edit And Delete&nbsp;&nbsp;&nbsp;<br>
                  <input type="checkbox" name="products_view_access" id="products_view_access" value="1" @if($adminDetails->products_view_access == '1') checked @endif >&nbsp;Products View Only&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="products_edit_access" id="products_edit_access" value="1" @if($adminDetails->products_edit_access == '1') checked @endif >&nbsp;Products View, Edit Only&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="products_full_access" id="products_full_access" value="1" @if($adminDetails->products_full_access == '1') checked @endif >&nbsp;Products View,Edit,Delete&nbsp;&nbsp;&nbsp;<br>
                  <input type="checkbox" name="orders_view_access" id="orders_view_access" value="1" @if($adminDetails->orders_view_access == '1') checked @endif >&nbsp;Orders View Only&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="orders_edit_access" id="orders_edit_access" value="1" @if($adminDetails->orders_edit_access == '1') checked @endif >&nbsp;Orders View, Edit Only&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="orders_full_access" id="orders_full_access" value="1" @if($adminDetails->orders_full_access == '1') checked @endif >&nbsp;Orders View,Edit, Delete&nbsp;&nbsp;&nbsp;<br>
                  <input type="checkbox" name="users_view_access" id="users_view_access" value="1" @if($adminDetails->users_view_access == '1') checked @endif >&nbsp;Users View Only&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="users_edit_access" id="users_edit_access" value="1" @if($adminDetails->users_edit_access == '1') checked @endif >&nbsp;Users View,Edit Only&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="users_full_access" id="users_full_access" value="1" @if($adminDetails->users_full_access == '1') checked @endif >&nbsp;Users View, Edit, Delete&nbsp;&nbsp;&nbsp;
                </div>
              </div>
              @endif
              <div class="control-group">
                <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1" @if($adminDetails->status == '1') checked @endif >
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Edit Admins" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection