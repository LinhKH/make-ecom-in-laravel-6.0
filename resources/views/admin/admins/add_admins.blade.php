@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Admins</a> <a href="#" class="current">Add Admins</a> </div>
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
            <h5>Add Admins / Sub-Admins</h5>
          </div>
          <div class="widget-content nopadding">
            <form class="form-horizontal" method="post" action="{{ url('admin/add-admins') }}" name="add_admin" id="add_admin" novalidate="novalidate">{{ csrf_field() }}
              <div class="control-group">
                <label class="control-label">Type</label>
                <div class="controls" style="width:244px;">
                  <select name="type" id="type">
                    <option value="Admin">Admin</option>
                    <option value="Sub Admin">Sub Admin</option>
                  </select>
                </div>
              </div>
              
              <div class="control-group">
                <label class="control-label">Username</label>
                <div class="controls">
                  <input type="text" name="username" id="username">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Password</label>
                <div class="controls">
                  <input type="password" name="password" id="password">
                </div>
              </div>
              <div class="control-group" id="access">
                <label class="control-label">Access</label>
                <div class="controls">
                  <input type="checkbox" name="categories_view_access" id="categories_view_access" value="1">&nbsp;View Categories&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="categories_edit_access" id="categories_edit_access" value="1">&nbsp;View and Edit Categories&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="categories_full_access" id="categories_full_access" value="1">&nbsp;View,Edit and Delete Categories&nbsp;&nbsp;&nbsp;<br>

                  <input type="checkbox" name="products_view_access" id="products_view_access" value="1">&nbsp;Products View Only&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="products_edit_access" id="products_edit_access" value="1">&nbsp;Products View, Edit&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="products_full_access" id="products_full_access" value="1">&nbsp;Products View, Edit, Delete&nbsp;&nbsp;&nbsp;<br>

                  <input type="checkbox" name="orders_view_access" id="orders_view_access" value="1">&nbsp;Orders View Only&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="orders_edit_access" id="orders_edit_access" value="1">&nbsp;Orders View, Edit Only&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="orders_full_access" id="orders_full_access" value="1">&nbsp;Orders View, Edit, Delete&nbsp;&nbsp;&nbsp;<br>

                  <input type="checkbox" name="users_view_access" id="users_view_access" value="1">&nbsp;Users View Only&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="users_edit_access" id="users_edit_access" value="1">&nbsp;Users View, Edit Only&nbsp;&nbsp;&nbsp;
                  <input type="checkbox" name="users_full_access" id="users_full_access" value="1">&nbsp;Users View, Edit, Delete&nbsp;&nbsp;&nbsp;
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" value="1">
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Add Admins" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection