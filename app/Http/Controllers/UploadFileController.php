<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Excel;
use App\Imports\Import;
use Illuminate\Support\Facades\DB;
use App\kf_indicator as kf_indicator;

class UploadFileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
       
        return view('uploadfile');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function importData(Request $request){
        $import = $request['import'];
        $jsonnn = json_encode($import);
        return $jsonnn;
    }

    public function test(){
        $import = '[{"sheetInfo":[{"feuille":"CASELOADS"},{"importInfo":[{"headerInfo":[{"headerName":"Country"},{"headerIndex":"0"},{"headerType":"location"},{"HeaderIndicator":"14"}]},{"headerInfo":[{"headerName":"PIN"},{"headerIndex":"1"},{"headerType":"keyFigure"},{"HeaderIndicator":"14"}]},{"headerInfo":[{"headerName":"PT"},{"headerIndex":"2"},{"headerType":"keyFigure"},{"HeaderIndicator":"14"}]},{"headerInfo":[{"headerName":"Year"},{"headerIndex":"3"},{"headerType":"date"},{"HeaderIndicator":"14"}]}]},{"sheetData":[["Country","PIN","PT","Year","Comment"],["BFA","939148","939148","2015"],["CMR","2070000","1600000","2015"],["CHD","3000000","2500000","2015"],["GAM","566868","314504","2015"],["MLI","2640000","1550000","2015"],["MRT","428000","397000","2015"],["NER","3300000","2500000","2015"],["NGA","4600000","2800000","2015"],["SEN","4300000","1100000","2015"],["CAR","2700000","2000000","2015"],["DRC","7000000","5200000","2015"],["BFA","1600000","833000","2016"],["CMR","2700000","1100000","2016"],["CHD","2300000","1800000","2016"],["GAM","182000","182000","2016"],["MLI","2500000","1000000","2016"],["MRT","468000","377000","2016"],["NER","2000000","1500000","2016"],["NGA","7000000","3900000","2016"],["SEN","620000","353000","2016"],["CAR","2300000","1900000","2016"],["DRC","7500000","6000000","2016"],["BFA","860625","477872","2017"],["CMR","2900000","1200000","2017"],["CHD","4700000","2600000","2017"],["MLI","3700000","1360000","2017"],["MRT","539000","416000","2017"],["NER","1900000","1500000","2017"],["NGA","8500000","6900000","2017"],["SEN","881000","379000","2017"],["CAR","2200000","1600000","2017"],["DRC","7300000","6700000","2017"],["BFA","954000","702000","2018"],["CMR","3300000","1300000","2018"],["CHD","4400000","1900000","2018"],["MLI","4100000","1560000","2018"],["MRT","830000","617500","2018","Not published (March 2018 version)"],["NER","2300000","1800000","2018"],["NGA","7700000","6100000","2018"],["SEN","814000","340000","2018"],["CAR","2500000","1900000","2018"],["DRC","13100000","10500000","2018"]]}]}]';
        $jsonnn = json_decode($import);
        //print_r( $jsonnn);
        

        foreach ($jsonnn as $sheetInfo){
            print_r("Sheet Info");
      
            //var_dump($sheetInfo);
            $sheetName = $sheetInfo->sheetInfo[0]->feuille;
            $headerInfo = $sheetInfo->sheetInfo[1]->headerInfo;
            



            //print_r();
            
        }

    }
    public function showUploadFile(Request $request){
        /*
        $file = $request->file('image');
     
        //Display File Name
        echo 'File Name: '.$file->getClientOriginalName();
        echo '<br>';
     
        //Display File Extension
        echo 'File Extension: '.$file->getClientOriginalExtension();
        echo '<br>';
     
        //Display File Real Path
        echo 'File Real Path: '.$file->getRealPath();
        echo '<br>';
     
        //Display File Size
        echo 'File Size: '.$file->getSize();
        echo '<br>';
     
        //Display File Mime Type
        echo 'File v Mime Type: '.$file->getMimeType();
     
        //Move Uploaded File
        $destinationPath = 'uploads';
        //echo 'file xxx:'.$file->getClientOriginalName();
        $newFileName = date('YmdHis').".".$file->getClientOriginalExtension();
        $file->move($destinationPath,$newFileName);

        */
        $file = $request->file('image');
        if (file_exists(public_path() . '/uploads/20181128154924.xlsx')) {
            Excel::import(new Import, $file);
        } else {
            echo "no";
        }

       //echo asset('storage/20181128154924.xlsx');
     }


}
