let map, activeInfoWindow, markers = [];
function initMap() {
    map = new google.maps.Map(document.getElementById("map"), {center: {lat: 11.3410,lng: 77.7172,},zoom: 6.5});
}
function initMarkers(initialMarkers) {
    for (let i = 0; i < markers.length; i++) {markers[i].setMap(null);}
    markers = [];
    for (let index = 0; index < initialMarkers.length; index++) {
        const markerData = initialMarkers[index];
        const marker = new google.maps.Marker({
            position: markerData.position,
            label: markerData.label,
            draggable: markerData.draggable,
            map
        });
        markers.push(marker);
        const infowindow = new google.maps.InfoWindow({content: `${markerData.msg}`,});
        marker.addListener("click", (event) => {
            if(activeInfoWindow) {activeInfoWindow.close();}
            infowindow.open({anchor: marker,shouldFocus: false,map});
            activeInfoWindow = infowindow;
        });
    }
}
function state_checkbox_list_all(ch)
{
    const state_checkbox_list = document.getElementsByClassName("state_checkbox_list");
    for (let i = 1; i < state_checkbox_list.length; i++) {
        state_checkbox_list[i].checked=ch;
    }
    state_checkbox_list_change();
}
function state_checkbox_list_change()
{
    var state_id="";
    const state_checkbox_list = document.getElementsByClassName("state_checkbox_list");
    for (let i = 1; i < state_checkbox_list.length; i++) {
        if(state_checkbox_list[i].checked)
        {state_id+=(state_id!=""?",":"")+(state_checkbox_list[i].id.split("-")[1]);}
    }
    var group_id="";
    const group_checkbox_list = document.getElementsByClassName("group_checkbox_list");
    for (let i = 1; i < group_checkbox_list.length; i++) {
        group_id+=(group_id!=""?",":"")+(group_checkbox_list[i].id.split("-")[1]);
        document.getElementById("group_checkbox_list1-"+(group_checkbox_list[i].id.split("-")[1])).innerHTML="0";
    }
    document.getElementById("group_checkbox_list1-all").innerHTML="0";
    //if(state_id!="")
    {
        var valu={state_id:state_id,group_id:group_id};
        jQuery.ajax({type: "GET",url: "/retrieve_db_group_cnt_table",data:valu,
            success: function(data) {
                var total_cnt=0;
                for (let i = 0; i < data.length; i++)
                {
                    var data1=data[i];var cnt=parseInt(data1["group_cnt"]);total_cnt+=cnt;
                    document.getElementById("group_checkbox_list1-"+data1["group_id"]).innerHTML=cnt;
                }
                document.getElementById("group_checkbox_list1-all").innerHTML=total_cnt;
            }
        });
    }
    set_Map_Location_Id();
}
function group_checkbox_list_all(ch)
{
    const group_checkbox_list = document.getElementsByClassName("group_checkbox_list");
    for (let i = 1; i < group_checkbox_list.length; i++) {
        group_checkbox_list[i].checked=ch;
    }
    set_Map_Location_Id();
}
function set_Map_Location_Id()
{
    var state_id="";
    const state_checkbox_list = document.getElementsByClassName("state_checkbox_list");
    for (let i = 1; i < state_checkbox_list.length; i++) {
        if(state_checkbox_list[i].checked)
        {state_id+=(state_id!=""?",":"")+(state_checkbox_list[i].id.split("-")[1]);}
    }
    var group_id="";
    const group_checkbox_list = document.getElementsByClassName("group_checkbox_list");
    for (let i = 1; i < group_checkbox_list.length; i++) {
        if(group_checkbox_list[i].checked)
        {group_id+=(group_id!=""?",":"")+(group_checkbox_list[i].id.split("-")[1]);}
    }
    var valu={state_id:state_id,group_id:group_id};
    jQuery.ajax({type: "GET",url: "/retrieve_db_plant_loc_stgr_table",data:valu,
        success: function(data) {
            const initialMarkers = [];
            for (let i = 0; i < data.length; i++)
            {
                var data1=data[i];
                var latitude=parseFloat(data1["latitude"]);var longitude=parseFloat(data1["longitude"]);
                initialMarkers[i]={"position":{"lat":latitude,"lng":longitude},"label":{"color":"white"},"draggable":false,"msg":"<b style='color:black;'>Group name : "+data1["group1"]+"<br>Company name : "+data1["company"]+"<br>Plant name : "+data1["plant"]+"</b>"};
            }
            initMarkers(initialMarkers);
        }
    });
}
(function($) {
    initMap();
    state_checkbox_list_change();
    group_checkbox_list_all(true);
})(jQuery);
