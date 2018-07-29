<?php namespace MartinBecker\IPProjectsRestposten;

/**
*  Restposten API Wrapper
*
*  @author Martin Becker <martin.becker@becker-software.de>
*/
class Api {

    protected $pass;
    public $user;
    public $url;
    /**
     * Constructor Function
     * 
     * @var string $user Username
     * @var string $pass Password
     */
    public function __construct($user,$pass)
    {
        $url = "https://restposten.ip-projects.de/api/hardware";

        $key = hash ('sha256', env('ipprojects-api-password') , false );
        $data = env('ipprojects-api-user') . $url ;
        $digest = hash_hmac ('sha256', $data , $key , false );

        $this->user = $user;
        $this->pass = $pass;
    }

    protected function authorize($user,$pass,$url) {
        $key = hash ('sha256', $pass , false );
        $data = $user . "https://restposten.ip-projects.de/api/hardware";
        $digest = hash_hmac ('sha256', $data , $key , false );
        return $digest;
    }
    /**
     * Request
     * 
     * @var url Submit the last part of the url after /api/{your-call}
     */
    public function request($url) {
        $this->url = $url = 'https://restposten.ip-projects.de/api/'. $url;
        $digest = $this->authorize($this->user,$this->pass,$this->url);
        header('Content-Type: application/json');
        $c = curl_init() ;
        curl_setopt ($c , CURLOPT_URL , $this->url );
        curl_setopt ($c , CURLOPT_HTTPHEADER , array ('AuthUser: '. $this->user , 'AuthDigest: ' . $digest ));
        curl_setopt ($c , CURLOPT_RETURNTRANSFER , true );
        $this->json = $json = curl_exec ($c);
        $this->info = curl_getinfo($c);
        curl_close ($c);
        return $this->info;
    }
}