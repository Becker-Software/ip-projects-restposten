<?php 
namespace MartinBecker\IPProjectsRestposten;

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
        $this->user = $user;
        $this->pass = $pass;
    }

    protected function authorize($user,$pass,$url) {
        $key = hash ('sha256', $pass , false );
        $data = $user . $url;
        $digest = hash_hmac ('sha256', $data , $key , false );
        return $digest;
    }
    /**
     * Request
     * 
     * @var url Submit the last part of the url after /api/{your-call}
     */
    public function request($url) {
        $this->url = 'https://restposten.ip-projects.de/api/'. $url;
        $digest = $this->authorize($this->user,$this->pass,$this->url);

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