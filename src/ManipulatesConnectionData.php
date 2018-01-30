<?php

namespace IdNow;


trait ManipulatesConnectionData
{
    private $authToken;

    public static function getBaseDomain()
    {
        return 'idnow.de';
    }

    public function getGoDomain()
    {
        if($this->testMode == true) {
            return 'go.test.'.self::getBaseDomain();
        } else {
            return 'go.'.self::getBaseDomain();
        }
    }

    public function getGatewayDomain()
    {
        if($this->testMode == true) {
            return 'gateway.test.'.self::getBaseDomain();
        } else {
            return 'gateway.'.self::getBaseDomain();
        }
    }

    public function getApiDomain()
    {
        if($this->testMode == true) {
            return 'api.test.'.self::getBaseDomain();
        } else {
            return 'api.'.self::getBaseDomain();
        }
    }

    public static function getProtocol()
    {
        return 'https://';
    }

    public function send($method = 'GET', $url, $headers, $data)
    {
        $ch = curl_init();

        var_dump($url, $headers, json_encode($data));

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        switch($method) {
            case "POST":
                curl_setopt($ch, CURLOPT_POST, 1);
                break;
            case "PUT":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;
            case "DELETE":
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
            case "GET":
            default:
                break;
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);

        curl_close ($ch);


        $result = json_decode($server_output, true);
        //TO DO: response validation

        return $result;
    }

    public function login()
    {
        $url = self::getProtocol().$this->getGatewayDomain().'/api/'.$this->getApiVersion().'/'
            . $this->getCompanyId().'/login';
        $headers = [
            'Content-Type: application/json',
        ];
        $data = [
            'apiKey' => $this->getApiKey(),
        ];

        $result = $this->send('POST', $url, $headers, $data);

        if(isset($result['authToken'])) {
            $this->authToken = $result['authToken'];
        }

        return $result;
    }

    public function getAuthToken()
    {
        return $this->authToken;
    }


}