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

//     var_dump( "File:".__FILE__, "Line:". __LINE__, "hi");
 
  final static private function get_real_ip_address()
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

class FileOperations
{
    private static function readFile($filename)
    {
        $contents = file_get_contents($filename);
        return $contents;
    }

    private static function writeFile($filename, $data)
    {
        $result = file_put_contents($filename, $data);
        return $result;
    }

    private static function searchFile($filename, $searchString)
    {
        $contents = self::readFile($filename);
        if (strpos($contents, $searchString) !== false) {
            return true;
        } else {
            return false;
        }
    }

    private static function deleteFile($filename)
    {
        if (file_exists($filename)) {
            $result = unlink($filename);
            return $result;
        } else {
            return false;
        }
    }

    public static function readFileContents($filename)
    {
        return self::readFile($filename);
    }

    public static function writeFileContents($filename, $data)
    {
        return self::writeFile($filename, $data);
    }

    public static function searchFileForString($filename, $searchString)
    {
        return self::searchFile($filename, $searchString);
    }

    public static function deleteFileFromDisk($filename)
    {
        return self::deleteFile($filename);
    }
}

// Example usage
$file = 'example.txt';

// Read file
$fileContents = FileOperations::readFileContents($file);
echo "File contents: " . $fileContents . "\n";

// Write to file
$data = "This is some new data.\n";
$writeResult = FileOperations::writeFileContents($file, $data);
if ($writeResult !== false) {
    echo "Data written to file successfully.\n";
} else {
    echo "Error writing to file.\n";
}

// Search for a string in the file
$searchString = "some";
$searchResult = FileOperations::searchFileForString($file, $searchString);
if ($searchResult) {
    echo "String found in file.\n";
} else {
    echo "String not found in file.\n";
}

// Delete the file
$deleteResult = FileOperations::deleteFileFromDisk($file);
if ($deleteResult) {
    echo "File deleted successfully.\n";
} else {
    echo "Error deleting file.\n";
}

?>