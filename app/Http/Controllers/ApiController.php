<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Session;
use App\Http\Controllers\http\Client;
use App\Models\Register;

class ApiController extends Controller
{

    public function formsubmit(Request $request)
    {

        $register = $request->all();
        $dateSelected = explode(" - ", $register['daterange']);
       
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.nasa.gov/neo/rest/v1/feed?start_date='.date("Y-m-d", strtotime($dateSelected[0])).'&end_date='.date("Y-m-d", strtotime($dateSelected[1])).'&api_key=4FF1eDw9tATrlNovWoQBflGFt8GlJr1kmwUa7UDN',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        $response = json_decode($response,true);
        curl_close($curl);

        $fastestAsteroidArr = [];
        $closestAsteroidArr = [];
        $asteriodSizeArr = [];
        $asteroidData = [];
        $asteroidArr = [];
        $c=1;
        foreach ($response['near_earth_objects'] as $key => $value) {
             $fastestAsteroid = array_reduce($value, function($a, $b) { 
              return $a > $b['close_approach_data'][0]['relative_velocity']['kilometers_per_hour'] ? $a : $b['close_approach_data'][0]['relative_velocity']['kilometers_per_hour'].", ID: ".$b['id']; 
              });

             array_push($fastestAsteroidArr,$fastestAsteroid);

             $closestAsteroid = array_reduce($value, function($a, $b) { 
              return $b['close_approach_data'][0]['miss_distance']['miles'] > $a  ? $b['close_approach_data'][0]['miss_distance']['miles'].", ID: ".$b['id'] : $a; 
              });

             array_push($closestAsteroidArr,$closestAsteroid);
             $count = count($value);

                $sum = array_sum(array_map(function($item){
                    return $item['close_approach_data'][0]['miss_distance']['kilometers'];
                }, $value));

                
             array_push($asteriodSizeArr,$sum);
             $averageSizeOfAsteroid = sprintf('%1.2f', $sum / $count);
             $expfastestAsteroid = explode(", ID: ", $fastestAsteroid);
             $expclosestAsteroid = explode(", ID: ", $closestAsteroid);

            $asteroidData[] = array($c,floatval($expfastestAsteroid[0]),floatval($expclosestAsteroid[0]),floatval($averageSizeOfAsteroid));

             $c += 1;
        }

        $totalCount = count($response['near_earth_objects']);
        $avgAsteroid = sprintf('%1.2f', array_sum($closestAsteroidArr) / $totalCount);

       
       
       return view("asteroid",compact('asteroidData','fastestAsteroidArr','closestAsteroidArr','asteriodSizeArr','avgAsteroid'));

      
    }


    
     


}

?>