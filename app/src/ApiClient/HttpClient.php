<?php 

namespace ApiClient;
use Exception;
class HttpClient{
    private $token;

    private const ROUTES = [
        'generate-token' => '/api/mySession/THISISMYSECURETOKEN/generate-token',
        'start-session' => '/api/mySession/start-session',
        'send-message' => '/api/mySession/send-message'
    ];

    private function logError($message, $category, $data): void{
        $error = "ERROR: Error in $category\nMessage: $message\nContent: $data";
        file_put_contents("log.txt", $error);
    }

    private function verifyRoute($route): bool{
        if(array_key_exists($route, self::ROUTES)){
            return true;
        }
        return false;
    }

    private function getRoute($route): string{
        return self::ROUTES[$route];
    }

    private function getToken(): string{
        return $this->token;
    }
    
    public function __construct(){
        $this->token = getenv('TOKEN');
    }

    public function doRequest($method, $route, $data = []): array{
        if(!$this->verifyRoute($route)){
            $this->logError("Route does not exist", "Routes", $route);
            throw new Exception("Route does not exist");
        }

        $ch = curl_init();
        $headers = [
            'Content-Type: application/json',
            'Accept: application/json'
        ];
        if ($this->getToken()) {
            $headers[] = 'Authorization: Bearer ' . $this->getToken();
        }
        $curlOptions = [
            CURLOPT_URL => $route,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true, 
            CURLOPT_TIMEOUT => 10
        ];

        switch($method){
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

