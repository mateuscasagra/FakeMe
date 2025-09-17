<?php 

namespace ApiClient;
use Exception;
use DateTime;
class HttpClient{
    private $token;
    private const BASE_URL = "http://localhost:21465";
    private const ROUTES = [
        'generate-token' => '/api/mySession/THISISMYSECURETOKEN/generate-token',
        'start-session' => '/api/mySession/start-session',
        'send-message' => '/api/mySession/send-message',
        'status-session' => '/api/mySession/status-session'
    ];

    private function logError($message, $category, $data = null): void{
        $date = (new DateTime())->format('d/m H:s');
        $error = "ERROR: Error in $category\nMessage: $message\nContent: $data\nDate: $date\n\n";
        file_put_contents("log.txt", $error, FILE_APPEND | LOCK_EX);
    }

    private function verifyRoute($route): bool{
        if(array_key_exists($route, self::ROUTES)){
            return true;
        }
        return false;
    }

    
    public function __construct($token){
        $this->token = $token;
    }

    public function doRequest($method, $route, $data = []){
        if(!$this->verifyRoute($route)){
            $this->logError("Route does not exist", "Routes", $route);
            throw new Exception("Route does not exist");
        }
        
        if (!$this->token) {
            $this->logError("Token empty", "Token");
            throw new Exception("Error Token empty");
        }

        $fullRoute = self::BASE_URL.self::ROUTES[$route];
        
        $ch = curl_init();
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        $headers[] = 'Authorization: Bearer ' . $this->token;
        $curlOptions = [
            CURLOPT_URL => $fullRoute,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_TIMEOUT => 10
        ];

        switch($method){
            case 'GET':
                $curlOptions[CURLOPT_GET] = true;
                break;
            case 'POST':
                $curlOptions[CURLOPT_POST] = true;
                $curlOptions[CURLOPT_POSTFIELDS] = json_encode($data);
                break;
        }
        curl_setopt_array($ch, $curlOptions);
        $response = curl_exec($ch);
        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($statusCode >= 400) {
            $this->logError("Error $statusCode", 'API', $response);
            throw new Exception("Error in API, Status: $statusCode.\n Response: $response");
        }
        $dataResponse = json_decode($response, true);
        return $dataResponse;
    }
}

