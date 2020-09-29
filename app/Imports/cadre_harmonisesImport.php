<?php

namespace App\Imports;

use App\cadre_harmonise;
use Maatwebsite\Excel\Concerns\ToModel;
use Webpatser\Uuid\Uuid;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\OnEachRow;

class cadre_harmonisesImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function model (array $row)
    {
        if (!isset($row[0])) {
            return null;
        }else{
            if($row[0]!="Country"){
                $UNIX_DATE = ($row[16] - 25569) * 86400;
                $date = gmdate("Y/m/d", $UNIX_DATE);

                $cadre_harmonise = new cadre_harmonise;
                $cadre_harmonise->ch_id = (string)Uuid::generate();
                $cadre_harmonise->ch_country=$row[0];
                $cadre_harmonise->ch_adm0_pcode_iso3=$row[1];
                $cadre_harmonise->ch_admin1_name=$row[2];
                $cadre_harmonise->ch_admin1_pcode_iso3=$row[3];
                $cadre_harmonise->ch_admin2_name=$row[4];
                $cadre_harmonise->ch_admin2_pcode_iso3=$row[5];
                $cadre_harmonise->ch_ipc_level=$row[6];
                $cadre_harmonise->ch_phase1=($row[7]==NULL || is_float($row[7])==false) ? 0 : $row[7];
                $cadre_harmonise->ch_phase2=($row[8]==NULL || is_float($row[8])==false) ? 0 : $row[8];
                $cadre_harmonise->ch_phase3=($row[9]==NULL || is_float($row[9])==false) ? 0 : $row[9];
                $cadre_harmonise->ch_phase4=($row[10]==NULL || is_float($row[10])==false) ? 0 : $row[10];
                $cadre_harmonise->ch_phase5=($row[11]==NULL || is_float($row[11])==false) ? 0 : $row[11];
                $cadre_harmonise->ch_phase35=($row[12]==NULL || is_float($row[12])==false) ? 0 : $row[12];
                $cadre_harmonise->ch_exercise_month=$row[13];
                $cadre_harmonise->ch_exercise_year=$row[14];
                $cadre_harmonise->ch_situation=$row[15];
                $cadre_harmonise->ch_date=$date;

                $cadre_harmonise->save();
            }
        }
    }

}
