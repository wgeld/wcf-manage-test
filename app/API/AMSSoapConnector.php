<?php

namespace App\API;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7;
use Illuminate\Http\JsonResponse;
use App\DeviceManagerAPI;
use App\Equipment;
use Carbon\Carbon;
use App\LocationIndex;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AMSSoapConnector
{
    /**
     * @return Client
     */
    public function client()
    {

        $accessToken = $this->getAccessToken();

        $client = new Client([
            //'base_uri' => 'http://10.32.1.116/api/alarms/',
            'base_uri' => 'https://wcfreports.wge.org/api/',
            'headers' => [
                //'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'Content-Type' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest',
                'Authorization' => 'Bearer ' . $accessToken
            ],
            'verify' => false
        ]);
        return $client;
    }

    /**
     * @return mixed|string
     */
    public function getAccessToken()
    {
        $client = new Client([
            //'base_uri' => 'http://10.32.1.116/',
            'base_uri' => 'https://wcfreports.wge.org/',
            'headers' => [
                //'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                'Content-Type' => 'application/json',
                'X-Requested-With' => 'XMLHttpRequest'
            ],
            'verify' => false
        ]);

        $url = 'api/auth/login';

        try {
            $response = $client->post($url, [
                'form_params' => [
                    'name' => 'wcfapp',
                    'password' => 'wcf_app',
                    'remember_me' => false
                ]
            ]);
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                //dd($e);
                $exception = $e->getResponse()->getBody();
                $exception = json_decode($exception, true);
                $error = $exception['error'];
                $message = $exception['error_description'];

                return 'Something went wrong! ' . $error . ': ' . $message;
            }
        }

        $body = json_decode($response->getBody(), true);
        $access_token = data_get($body, 'access_token');

        return $access_token;
    }

    /**
     * Get all active alarms
     *
     * @return mixed json_decode
     */
    public function getActiveAlarms($amsServerName)
    {
        //dd($amsServerName);
        $client = $this->client();

        //dd($client);
        $url = 'oad/server/' . $amsServerName . '/alarmlist';

        //dd($url);
        $response = $client->get($url);
        //dd($response);
        $response = json_decode($response->getBody(), true);
        $response = $this->alterResponse($response);

        return $response;
    }

    /**
     * Get current ONT active alarms
     *
     * @return mixed json_decode
     */
    public function getActiveAlarmsByNEName($amsServerName, $neName)
    {
        $client = $this->client();
        $url = 'oad/server/' . $amsServerName . '/nename/' . $neName;
        //dd($url);
        $response = $client->get($url);
        $response = json_decode($response->getBody(), true);
        //dd($response);
        if(empty($response)){
            return [];
        } else {
            $response = $this->alterResponse($response);

            return $response;
        }
    }

    /**
     * Get current ONT active alarms
     *
     * @return mixed json_decode
     */
    public function getActiveAlarmsByFriendlyName($amsServerName, $neName, $sourceFriendlyName)
    {
        $client = $this->client();
        $url = 'oad/server/' . $amsServerName . '/nename/' . $neName . '/sourcefriendlyname/' . $sourceFriendlyName;
        //dd($url);
        $response = $client->get($url);
        $response = json_decode($response->getBody(), true);
        //dd($response);
        if(empty($response)){
            return [];
        } else {
            $response = $this->alterResponse($response);

            return $response;
        }
    }

    public function alterResponse(array $response)
    {
        $alteredResponse = [];
        foreach ($response as $alarm) {
            //dd($alarm);
            $amsTime = array_get($alarm, 'amsTime');
            $amsTime = $this->parseMTOSIDateTime($amsTime);
            $neTime = array_get($alarm, 'neTime');
            $neTime = $this->parseMTOSIDateTime($neTime);

            array_set($alarm, 'amsTime', $amsTime);
            array_set($alarm, 'neTime', $neTime);

            $sourceFriendlyName = array_get($alarm, 'sourceFriendlyName');

            $sourceFriendlyName = Str::replaceFirst(':', ',', $sourceFriendlyName);
            $sourceFriendlyNameSplit = explode(',', $sourceFriendlyName);

            array_set($alarm, 'sourceFriendlyName', $sourceFriendlyNameSplit[1]);
            //dd($alarm);
            $alteredResponse[] = $alarm;
        }

        return $alteredResponse;
    }

    public function parseMTOSIDateTime($dateTimeString)
    {
        //dd($dateTimeString);
        //asmTime = (0)2020(5)12(7)17(9)13(11)02(13)37(15).(16)144(19)-0500(24)
        $year = Str::substr($dateTimeString, 0, 4);
        $month = Str::substr($dateTimeString, 4, 2);
        $day = Str::substr($dateTimeString, 6, 2);
        $hour = Str::substr($dateTimeString, 8, 2);
        $minute = Str::substr($dateTimeString, 10, 2);
        $second = Str::substr($dateTimeString, 12, 2);

        //$fractionSecond = Str::substr($dateTimeString,14,4);
        //$fractionSecond = '.' . (string)Str::of($dateTimeString)->after('.')->before('-');

        $timeZone = '-' . Str::after($dateTimeString, '-');
        $test1 = Str::substr($timeZone, 0, 2);
        $test2 = Str::substr($timeZone, 2, 2);
        $timeZone = '-' . $test1 . ':' . $test2;


        $carbon = new Carbon;
        $carbonDateTime = $carbon->create($year, $month, $day, $hour, $minute, $second, $timeZone);
        //dd($carbonDateTime->toISOString());
        return $carbonDateTime->toDateTimeString();
    }

    public function suspend($parameters)
    {
        //dd($amsServerName);
        $client = $this->client();

        //dd($client);
        $url = 'apc/suspend';

        //dd($url);
        $response = $client->post($url,[
            'form_params' => $parameters
        ]);
        //dd($client);
        //dd($response);
        $response = json_decode($response->getBody(), true);


        return $response;
    }

    public function resume($parameters)
    {
        //dd($amsServerName);
        $client = $this->client();

        //dd($client);
        $url = 'apc/resume';

        //dd($url);
        $response = $client->post($url,[
            'form_params' => $parameters
        ]);
        //dd($response);
        $response = json_decode($response->getBody(), true);


        return $response;
    }

    public function apcBulkExecute($parameters)
    {
        $client = $this->client();

        //dd($client);
        $url = 'apc/bulk';

        //dd($url);
        $response = $client->post($url,[
            'form_params' => $parameters
        ]);
        //dd($response);
        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function getPerformanceMonitoringData(array $parameters)
    {
        $client = $this->client();

        //dd($client);
        $url = 'sdc/server';

        //dd($url);
        $response = $client->post($url,[
            'form_params' => $parameters
        ]);
        //dd($response);
        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function getPerformanceMonitoringDataForObjects(array $parameters)
    {
        $client = $this->client();

        //dd($client);
        $url = 'sdc/server/objects';

        //dd($url);
        $response = $client->post($url,[
            'form_params' => $parameters
        ]);
        //dd($response);
        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function getConfiguredTemplate(array $parameters)
    {
        $client = $this->client();
        //$url =
    }

    public function getConfiguredServices(array $parameters)
    {
        $client = $this->client();

        //dd($client);
        $url = 'apc/configuredservices';

        //dd($url);
        $response = $client->post($url,[
            'form_params' => $parameters
        ]);
        //dd($response);
        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function modify($parameters)
    {
        $client = $this->client();

        //dd($client);
        $url = 'apc/modify';

        //dd($url);
        $response = $client->post($url,[
            'form_params' => $parameters
        ]);
        //dd($response);
        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function unconfigure($parameters)
    {
        $client = $this->client();

        //dd($client);
        $url = 'apc/unconfigure';

        //dd($url);
        $response = $client->post($url,[
            'form_params' => $parameters
        ]);
        //dd($response);
        $response = json_decode($response->getBody(), true);

        return $response;
    }

    public function configure($parameters)
    {
        $client = $this->client();

        //dd($client);
        $url = 'apc/configure';

        //dd($url);
        $response = $client->post($url,[
            'form_params' => $parameters
        ]);
        //dd($response);
        $response = json_decode($response->getBody(), true);
        return $response;

    }

    public function nextAvailableONTByPon($parameters)
    {
        $client = $this->client();

        //dd($client);
        $url = 'apc/get';

        //dd($url);
        $response = $client->post($url,[
            'form_params' => $parameters
        ]);
        //dd($response);
        $response = json_decode($response->getBody(), true);
        return $response;
    }

}