@extends('layouts.adminLayout.admin_design')
@section('content')

<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Newsletter</a> <a href="#" class="current">View Newsletter</a> </div>
    <h1>Users</h1>
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
    <a href="{{ url('admin/export-newsletter-emails') }}" class="btn btn-primary btn-mini">Export</a>
  </div>
  <div class="container-fluid">
    <hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Newsletters</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Email</th>
                  <th>Status</th>
                  <th>Created At</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                @foreach($newsletters as $letter)
                <tr class="gradeX">
                  <td class="center">{{ $letter->id }}</td>
                  <td class="center">{{ $letter->email }}</td>
                  <td class="center">
                    @if($letter->status == 1)
                    <a href="{{ url('admin/update-newsletter-status/'. $letter->id.'/0') }}"><span style="color:green">Active</span></a>
                    @else
                    <a href="{{ url('admin/update-newsletter-status/'. $letter->id.'/1') }}"><span style="color:red">Inactive</span></a>
                    @endif
                  </td>
                  <td class="center">{{ $letter->created_at }}</td>
                  <td class="center">
                    <a href="{{ url('admin/edit-newsletter-subscriber/'.$letter->id) }}" class="btn btn-primary btn-mini">Edit</a> | 
                    <a href="{{ url('admin/delete-newsletter-subscriber/'.$letter->id) }}" class="btn btn-danger btn-mini">Del</a>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection