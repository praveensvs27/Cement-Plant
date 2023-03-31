<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StateCreation;
use App\Models\PlantGroup;
use Illuminate\Support\Facades\DB;
class Map2Controller extends Controller
{
    public function map2()
    {
        $states = StateCreation::select('state_id','state_name')->get();
        $groups = PlantGroup::select('id','group')->get();
        return view('map2',['states'=>$states,'groups'=>$groups]);
    }
    public function retrieve_db_group_cnt_table(Request $request)
    {
        $state_id=$request->input('state_id');$state_id=($state_id!="")?" and plants.state_id in (".$state_id.")":"";
        $group_id=$request->input('group_id');$group_id=($group_id!="")?" and plant_companies.group_id in (".$group_id.")":"";
        $tb_list=DB::select("SELECT plant_companies.group_id,count(*) as group_cnt FROM plant_companies INNER JOIN plants where plant_companies.id=plants.company_id".$state_id.$group_id." GROUP by plant_companies.group_id");
        return response()->json($tb_list);
    }
    public function retrieve_db_plant_loc_stgr_table(Request $request)
    {
        $state_id=$request->input('state_id');
        $group_id=$request->input('group_id');
        $company_id="";if($group_id!=""){$company_id1=DB::select("SELECT GROUP_CONCAT(id SEPARATOR ',') as id from plant_companies where group_id in (".$group_id.")");$company_id=$company_id1[0]->id;}
        if(($state_id!="")||($company_id!=""))
        {
            $tb_list=DB::select("SELECT plant,(select company from plant_companies where id=plants.company_id) as company,(select plant_groups.group from plant_groups where id=(select group_id from plant_companies where id=plants.company_id)) as group1,latitude,longitude FROM plants WHERE ".(($state_id!="")?"state_id in (".$state_id.")":"").(($company_id!="")?(($state_id!="")?" and ":"")."company_id in (".$company_id.")":""));
            return response()->json($tb_list);
        }
    }
}
