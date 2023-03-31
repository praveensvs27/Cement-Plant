<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plant;
use App\Models\SiteCreation;
class Map1Controller extends Controller
{
    public function map1()
    {
        $sites = SiteCreation::select('id','site_name','latitude','longitude')->orderBy('site_name')->get();
        $plants =Plant::join('plant_companies', 'plant_companies.id', '=', 'plants.company_id')->join('plant_groups', 'plant_groups.id', '=', 'plant_companies.group_id')->orderBy('plants.id')->get(['plant_groups.group','plant_companies.company','plants.plant','plants.city','plants.latitude','plants.longitude']);
        return view('map1',['sites'=>$sites,'plants'=>$plants]);
    }
}
