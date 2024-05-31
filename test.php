<?php

$a = time();
var_dump($a);

/**
 * Test class
 * 
 * @Author: john3825
 * @Date: 2024/05/30
 * 
 */

 /**
  * Calculates the factorial of a given number.
  *
  * @param int $n The number to calculate the factorial for.
  * @return int The factorial of the given number.
  */
final class Test {
    static private $a = 0;
    
    public function __construct() {
    }
    final static public function test1()
    {
        
        $UserAgent = (object) array(
            "UserAgent" => $_SERVER["HTTP_USER_AGENT"],
            "IP" => self::get_real_ip_address(),
            "Timestamp" => time()
        );
        return $UserAgent;
    }
/*     var_dump( "File:".__FILE__, "Line:". __LINE__, "hi");
 */  
ADD  final static private function get_real_ip_address()
    {
        // Check if the IP address is passed through a proxy
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // Check if the IP address is passed through a proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            // Get the IP address from the remote address
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        // Check if the IP address is in a private IP range
        $private_ip_ranges = array(
            '10.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16'
        );

   

        return $ip;
    }

    final static private function ip_in_range($ip, $range)
    {
        if (strpos($range, '/') === false) {
            $range .= '/32';
        }
        list($range, $netmask) = explode('/', $range, 2);
        $range_decimal = ip2long($range);
        $ip_decimal = ip2long($ip);
        $wildcard_decimal = pow(2, (32 - $netmask)) - 1;
        $netmask_decimal = ~$wildcard_decimal;

        return (($ip_decimal & $netmask_decimal) == ($range_decimal & $netmask_decimal));
    }

    final static private function get_public_ip_address()
    {
        $ip_services = array(
            'https://api.ipify.org/',
            'https://ipinfo.io/ip',
            'https://icanhazip.com/'
        );

        foreach ($ip_services as $service) {
            $curl = curl_init($service);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $public_ip = curl_exec($curl);
            curl_close($curl);

            if ($public_ip !== false && filter_var($public_ip, FILTER_VALIDATE_IP)) {
                return $public_ip;
            }
        }

        // If all services fail, return the server's IP address
        return $_SERVER['SERVER_ADDR'];
    }

 }

$Test = new Test();
$UserAgent = $Test::test1();

var_dump($UserAgent);


?>