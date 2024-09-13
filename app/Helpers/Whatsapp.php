<?php 

namespace App\Helpers;
 
class Whatsapp {
    public static function send($no, $mess) {
        $curl = curl_init();
        if(strpos(substr($no,0,3), '08') !== false){
        	$awal = str_replace("08", "628", substr($no,0,3));
        	$no = $awal. substr($no,3);
        }
        $data = [
            'target' => $no,
            'message' => $mess
        ];
        
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array(
                "Authorization: 1TWK#RWrHiRt9exsaUum",
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($curl, CURLOPT_URL, "https://api.fonnte.com/send");
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}
