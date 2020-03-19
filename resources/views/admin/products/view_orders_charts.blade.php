<?php

$current_month = date('M');
$last_month = date('M', strtotime("-1 month"));
$last_to_last_month = date('M', strtotime("-2 month"));

$dataPoints = array(
  array("y" => $last_to_month_orders, "label" => $last_to_last_month),
  array("y" => $last_month_orders, "label" => $last_month),
  array("y" => $current_month_orders, "label" => $current_month),
);

?>
@extends('layouts.adminLayout.admin_design')
@section('content')
<script>
  window.onload = function() {

    var chart = new CanvasJS.Chart("chartContainer", {
      animationEnabled: true,
      theme: "light2",
      title: {
        text: "Orders Reporting"
      },
      axisY: {
        title: "Number of Orders"
      },
      data: [{
        type: "column",
        yValueFormatString: "#,##0.## orders",
        dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
      }]
    });
    chart.render();

  }
</script>
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">View Orders Charts</a> </div>
    <h1>Orders Charts</h1>
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
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>Users Reporting</h5>
          </div>
          <div class="widget-content nopadding">
            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>