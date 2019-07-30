<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PokemonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      //
      return view('index', compact('response'));
    }

    public function getData($data)
    {
        $result_front = [];
        foreach ($data as $key) {
            
            $ch = curl_init();

            $timeout = 5;

            curl_setopt($ch, CURLOPT_URL, $key);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $data_front = curl_exec($ch);

            $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

            curl_close($ch);
            array_push($result_front,$data_front);

        }
        return $result_front;
    }

    public function search(Request $request){
        $ch = curl_init();

        $timeout = 5;

        curl_setopt($ch, CURLOPT_URL, env('URL_POKEMON'));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);

        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($http_code != 200) {
            return json_encode('An error has occured.');
        }
        $results = json_decode($data,true);
        $resultado = [];

        foreach ($results['results'] as $key => $value)
        {
                if (strpos($value['name'], $request->name) !== false) {
                    array_push($resultado,$value['url']);   
                }           
        }
        $callback = PokemonController::getData($resultado);

        $response = [];
        $tmp = [];
        $output = [];

        foreach ($callback as $key => $value) {
                if(json_decode($value,true)["sprites"]["front_default"]==""){
                    $img = 'http://doublegtoys.com/wp-content/uploads/2018/01/PokeBall-01-365x365.jpg';
                }else{
                    $img = json_decode($value,true)["sprites"]["front_default"];
                }
              $output[$key]='<div class="card" style="width: 10rem;">';
              $output[$key].='  <img class="card-img-top" src="'.$img.'" alt="Card image cap">';
              $output[$key].='  <div class="card-footer">';
              $output[$key].='    <small class="text-muted">'.json_decode($value,true)["name"].'</small>';
              $output[$key].='  </div>';
              $output[$key].='</div>';             
        }
        return response()->json($output);
    }

}