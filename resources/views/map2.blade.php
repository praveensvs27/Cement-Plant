@extends('layout/main_page')
@section('page_title','Plant Location')
@section('main_content')
<div class="container-fluid">
	<div class="row page-titles mx-0">
		<div class="col-sm-6 p-md-0">
			<div class="welcome-text">
				<h4>Plant Location</h4>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-9">
            <div id="map" style="width:100%;height: 500px;"></div>
		</div>
		<div class="col-md-3">
            <div class="form-group mb-0">
                <label class="text-label mb-0">State List</label>
                <div style="background-color: #fff;color:black;border:1px solid #eaeaea;height:200px;overflow-y: scroll;">
                    <ul class="list-group">
<?php
if(count($states)>0)
{ ?>
    <li class='list-group-item p-0 px-1'><div class='custom-control custom-checkbox'><input class='custom-control-input state_checkbox_list' id='state_checkbox_list-all' type='checkbox' onclick='state_checkbox_list_all(this.checked);'><label class='cursor-pointer font-italic d-block custom-control-label' for='state_checkbox_list-all'>All</label></div></li>
<?php
    for ($i=0;$i<count($states);$i++)
    {
        $data1=$states[$i];$id=$data1["state_id"];
        echo "<li class='list-group-item p-0 px-1'><div class='custom-control custom-checkbox'><input class='custom-control-input state_checkbox_list' id='state_checkbox_list-".$id."' type='checkbox' onclick='state_checkbox_list_change();'><label class='cursor-pointer font-italic d-block custom-control-label' for='state_checkbox_list-".$id."'>".$data1["state_name"]."</label></div></li>";
    }
}
?>
                    </ul>
                </div>
            </div>
            <div class="form-group mb-0">
                <label class="text-label mb-0">Group List</label>
                <div style="background-color: #fff;color:black;border:1px solid #eaeaea;height:200px;overflow-y: scroll;">
                    <ul class="list-group">
<?php
if(count($groups)>0)
{ ?>
    <li class='list-group-item p-0 px-1'><div class='custom-control custom-checkbox'><input class='custom-control-input group_checkbox_list' id='group_checkbox_list-all' type='checkbox' onclick='group_checkbox_list_all(this.checked);' checked><label class='cursor-pointer font-italic d-block custom-control-label' for='group_checkbox_list-all'>All (<span id='group_checkbox_list1-all'>0</span>)</label></div></li>
<?php
    for ($i=0;$i<count($groups);$i++)
    {
        $data1=$groups[$i];$id=$data1["id"];
        echo "<li class='list-group-item p-0 px-1'><div class='custom-control custom-checkbox'><input class='custom-control-input group_checkbox_list' id='group_checkbox_list-".$id."' type='checkbox' onclick='set_Map_Location_Id();'><label class='cursor-pointer font-italic d-block custom-control-label' for='group_checkbox_list-".$id."'>".$data1["group"]." (<span id='group_checkbox_list1-".$id."'>0</span>)</label></div></li>";
    }
}
?>
                    </ul>
                </div>
            </div>
		</div>
	</div>
</div>
@endsection
@section('footer_content')
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAJGUYUdhVOmp1DoDe640xRLCE7JjFZdMw"></script>
<script src="assets/js/page/map2.js"></script>
@endsection
