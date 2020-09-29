<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\CaseloadsImport;
use App\Imports\informsahelrisksImport;
use App\Imports\internallydisplacedpersonsImport;
use App\Imports\nutritionsImport;
use App\Imports\foodsecuritiesImport;
use App\Imports\cadre_harmonisesImport;
use App\Imports\displacements_lcb_Import;
use App\Imports\displacements_sahel_Import;
use App\Imports\displacements_sahel_central_Import;
use App\Imports\displacements_wca_Import;
use App\Imports\caseloads_lcb_Import;
use App\Imports\caseloads_sahel_Import;
use App\Imports\caseloads_sahel_central_Import;
use App\Imports\caseloads_wca_Import;
use Webpatser\Uuid\Uuid;


class localDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show_view_access_import(Request $request) 
    {
        if ($request->session()->has('authenticated')) {
            return redirect("/import");
        }else{
            return view('localdata.accessimport');
        }
    }
    public function show_view_access_manage(Request $request) 
    {
        if ($request->session()->has('authenticated')) {
            return redirect("/managezones");
        }else{
            return view('localdata.accessmanage');
        }
    }
    public function show_view_import() 
    {
        return view('localdata.import');
    }
    public function show_view_database() 
    {
        return view('localdata.database');
    }
    public function show_view_confirm_import($element) 
    {
        $elementName = "";
        switch ($element){
            case "caseloads":
                $elementName = "Caseloads";
            break;
            case "informSahel":
                $elementName = "Inform sahel";
            break;
            case "idps":
                $elementName = "Internally displaced persons";
            break;
            case "disp":
                $elementName = "Displacements";
            break;
            case "nutrition":
                $elementName = "Nutrition";
            break;
            case "ch":
                $elementName = "Cadre harmonisé";
            break;
            case "fs":
                $elementName = "Food security";
            break;
        }
        
        return view('localdata.confirmimport',['elementName'=>$elementName,'element'=>$element]);
    }
    public function import_caseloads() 
    {
        DB::statement('TRUNCATE caseloads CASCADE');

        DB::table('data_by_years')->where('t_category', '=', 'people_in_need')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'people_targeted')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'people_reached')->delete();

        Excel::import(new caseloads_lcb_Import, 'caseloads/lcb.xlsx');
        Excel::import(new caseloads_sahel_Import, 'caseloads/sahel.xlsx');
        Excel::import(new caseloads_sahel_central_Import, 'caseloads/sahel_central.xlsx');
        Excel::import(new caseloads_wca_Import, 'caseloads/wca.xlsx');
        return redirect('/import')->with('success', 'All good!');
    }
    public function import_inform_sahel() 
    {
        DB::statement('TRUNCATE inform_sahel_risks CASCADE');
        Excel::import(new informsahelrisksImport, 'inform_sahel.xlsx');
        return redirect('/import')->with('success', 'All good!');
    }

    public function import_internally_displaced_person() 
    {
        DB::statement('TRUNCATE internally_displaced_peoples CASCADE');
        Excel::import(new internallydisplacedpersonsImport, 'Internaly_displaced_persons.xlsx');
        return redirect('/import')->with('success', 'All good!');
    }
    public function import_nutrition() 
    {
        DB::statement('TRUNCATE nutrition CASCADE');

        DB::table('data_by_years')->where('t_category', '=', 'severe_acute_malnutrition')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'global_acute_malnutrition')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'moderate_acute_malnutrition')->delete();

        Excel::import(new nutritionsImport, 'nutrition.xlsx');
        return redirect('/import')->with('success', 'All good!');
    }
    public function import_cadre_harmonise() 
    {
        DB::statement('TRUNCATE cadre_harmonises CASCADE');

        DB::table('data_by_years')->where('t_category', '=', 'ch_Current_phase1')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'ch_Current_phase2')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'ch_Current_phase3')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'ch_Current_phase3_plus')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'ch_Current_phase4')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'ch_Current_phase5')->delete();

        DB::table('data_by_years')->where('t_category', '=', 'ch_Projected_phase1')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'ch_Projected_phase2')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'ch_Projected_phase3')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'ch_Projected_phase3_plus')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'ch_Projected_phase4')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'ch_Projected_phase5')->delete();


        Excel::import(new cadre_harmonisesImport, 'cadre_harmonise.xlsx');
        return redirect('/import')->with('success', 'All good!');
    }
    public function import_food_security() 
    {
        DB::statement('TRUNCATE food_securities CASCADE');
        Excel::import(new foodsecuritiesImport, 'food_security.xlsx');
        return redirect('/import')->with('success', 'All good!');
    }
    public function import_displacement() 
    {
        DB::statement('TRUNCATE displacements CASCADE');

        DB::table('data_by_years')->where('t_category', '=', 'Refugee')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'IDP')->delete();
        DB::table('data_by_years')->where('t_category', '=', 'Returnee')->delete();

        Excel::import(new displacements_lcb_Import, 'displacements/lcb.xlsx');
        Excel::import(new displacements_sahel_Import, 'displacements/sahel.xlsx');
        Excel::import(new displacements_sahel_central_Import, 'displacements/sahel_central.xlsx');
        Excel::import(new displacements_wca_Import, 'displacements/wca.xlsx');

        return redirect('/import')->with('success', 'All good!');
    }

    public function guide_import()
    {
        if($_POST['import']=="IMPORT"){
            $url="/import"."/".$_POST['element'];
            return redirect($url);
        }else{
            return back()->with('msg', 'Type IMPORT in all caps !');
        }
    }

    public function verifyaccessimport(Request $request)
    {
        if($_POST['password']=="1two3"){
            $request->session()->put('authenticated', 'true');
            return redirect("/import");
        }else{
            return back()->with('msg', 'Wrong password please try again on contact the administrator');
        }
    }

    public function verifyaccessmanage(Request $request)
    {
        if($_POST['password']=="1two3"){
            $request->session()->put('authenticated', 'true');
            return redirect("/managezones");
        }else{
            return back()->with('msg', 'Wrong password please try again on contact the administrator');
        }
    }
}
