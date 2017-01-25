<?php

namespace Mulu\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Mulu\Agent;
use Mulu\Contact;

class Controller extends BaseController
{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /**
     * Get coordinates of the users.
     *
     * @return string $zipCode zip code of the user
     *
     * @param array $coordinates coordinates
     */

    private function getCoordinates($zipCode)
    {

        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL            => 'http://maps.googleapis.com/maps/api/geocode/json?address='.$zipCode,
            CURLOPT_USERAGENT      => 'Codular Sample cURL Request'
        ]);
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Close request to clear up some resources
        curl_close($curl);

        $result = json_decode($resp, true);

        $coordinates= $result['results'][0]['geometry']['location'];
        $coordinates=$coordinates['lat'].','.$coordinates['lng'];
        return $coordinates;
    }


    /**
     * @return string
     */
    public function match(Request $data)
    {
        // get zip codes agents
        $zip_agent_one = $data->get('agent1');
        $zip_agent_two = $data->get('agent2');


        // get coodinates for the agent one
        $coor_agent_one = $this->getCoordinates($zip_agent_one);

        // save agent one
        $agent_one=new Agent();
        $agent_one->name='Agent One';
        $agent_one->zip_code=$zip_agent_one;
        $agent_one->coordinates=$coor_agent_one;
        $agent_one->save();

        // get coodinates for the agent two
        $coor_agent_two = $this->getCoordinates($zip_agent_two);

        // save agent two
        $agent_two=new Agent();
        $agent_two->name='Agent Two';
        $agent_two->zip_code=$zip_agent_two;
        $agent_two->coordinates=$coor_agent_two;
        $agent_two->save();

        // get contacts list
        $contacts = Contact::all();
        // create array of the agents
        $arrayAgenr1=array();
        $arrayAgenr2=array();
        foreach ($contacts as $k => $val) {
            // validate if exit coordinates of the contact
            if($val->coordinates){
                $coodinates=$val->coordinates;
            }else{
                // generate coodinates of the contact
                $coodinates=$this->updateCoordinates($val);
            }
            // get distance between agents and contact
            $distance1=$this->distance($coor_agent_one,$coodinates , 'K');
            $distance2=$this->distance($coor_agent_two,$coodinates , 'K');
            // validate the shorter distance
            if ($distance1<$distance2){
                array_push($arrayAgenr1, $val);
            }else{
                array_push($arrayAgenr2, $val);
            }

        }
        // return view
        return view('results', [
            'agent1' => $arrayAgenr1,
            'agent2' => $arrayAgenr2
        ]);
    }

    /**
     * @return string
     */
    private function updateCoordinates($contact)
    {
        $coordinates=$this->getCoordinates($contact->zip_code);
        $contact=Contact::find($contact->id);
        $contact->coordinates=$coordinates;
        $contact->save();

        return $coordinates;
    }



    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    /*::                                                                         :*/
    /*::  This routine calculates the distance between two points (given the     :*/
    /*::  latitude/longitude of those points). It is being used to calculate     :*/
    /*::  the distance between two locations using GeoDataSource(TM) Products    :*/
    /*::                                                                         :*/
    /*::  Definitions:                                                           :*/
    /*::    South latitudes are negative, east longitudes are positive           :*/
    /*::                                                                         :*/
    /*::  Passed to function:                                                    :*/
    /*::    lat1, lon1 = Latitude and Longitude of point 1 (in decimal degrees)  :*/
    /*::    lat2, lon2 = Latitude and Longitude of point 2 (in decimal degrees)  :*/
    /*::    unit = the unit you desire for results                               :*/
    /*::           where: 'M' is statute miles (default)                         :*/
    /*::                  'K' is kilometers                                      :*/
    /*::                  'N' is nautical miles                                  :*/
    /*::  Worldwide cities and other features databases with latitude longitude  :*/
    /*::  are available at http://www.geodatasource.com                          :*/
    /*::                                                                         :*/
    /*::  For enquiries, please contact sales@geodatasource.com                  :*/
    /*::                                                                         :*/
    /*::  Official Web site: http://www.geodatasource.com                        :*/
    /*::                                                                         :*/
    /*::         GeoDataSource.com (C) All Rights Reserved 2015		   		     :*/
    /*::                                                                         :*/
    /*::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
    private function distance($coordinate1, $coordinate2, $unit) {
        $coordinate1 = explode(',',$coordinate1);
        $coordinate2 = explode(',',$coordinate2);
        $lon1=$coordinate1[0];
        $lat1=$coordinate1[1];
        $lon2=$coordinate2[0];
        $lat2=$coordinate2[1];

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        if ($unit == "K") {
            return ($miles * 1.609344);
        } else if ($unit == "N") {
            return ($miles * 0.8684);
        } else {
            return $miles;
        }
    }

}


