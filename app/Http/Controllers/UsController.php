<?php

namespace App\Http\Controllers;

use App\Userstory;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Redirect;
use DB;

class UsController extends Controller
{
    public function create(){
        return view("UsForm")->with('us',[]);
    }
    public function modify($idUs){

        $us =DB::table('userstory')->where('id', '=', $idUs)->get() ;
        return view("UsForm")->with('us',head($us));
    }

    public function createConfirm(Request $r){

        $developer_id = 1;
        $project_id = DB::table('project')->where('developer_id', $developer_id)->first()->id;

        Userstory::create([
            "description" => $r->input('description'),
            "priority" => $r->input('priority'),
            "difficulty" => $r->input('difficulty'),
            "status" => 0,
            "project_id" => $project_id]);

        return Redirect::action("BacklogController@show");
    }
    public function modifyConfirm(Request $r){

        $us = Userstory::where('id', $r->input("us"))->first();

        $us->update([
            "description" => $r->input('description'),
            "priority" => $r->input('priority'),
            "difficulty" => $r->input('difficulty'),
            "status" => ($r->input("done"))?1:0
        ]);

        return Redirect::action("BacklogController@show");
    }

    public function remove($id) {

        $us = Userstory::where('id', $id)->first();
        if($us != null) $us->delete();

        return Redirect::action("BacklogController@show");
    }
}