<?php

namespace App\Handlers;

/*
 * Demo:
 * $file_path = CurlHelper::downloadFile($url, array('followLocation' => true, 'maxRedirs' => 5), $file_path);
 */
class CurlHandler
{
    /**
     * Downloads a file from a url and returns the temporary|downloaded file path.
     * @param string $url
     * @param array $options
     * @param string $file_path
     * @return string The file path
     */
    public static function downloadFile($url, $options = array(), $file_path)
    {
        if (!is_array($options)) {
            $options = array();
        }
        $options = array_merge(array(
            'connectionTimeout' => 5, // seconds
            'timeout' => 10, // seconds
            'sslVerifyPeer' => false,
            'followLocation' => false, // if true, limit recursive redirection by
            'maxRedirs' => 1, // setting value for "maxRedirs"
        ), $options);

        // create a temporary|downloaded file (we are assuming that we can write to the system's temporary|downloaded directory)
        // $tempFileName = tempnam(sys_get_temp_dir(), '') . '.jpg';
        // $fh = fopen($tempFileName, 'w');
        $fh = fopen($file_path, 'w');

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_FILE, $fh);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $options['connectionTimeout']);
        curl_setopt($ch, CURLOPT_TIMEOUT, $options['timeout']);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $options['sslVerifyPeer']);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $options['followLocation']);
        curl_setopt($ch, CURLOPT_MAXREDIRS, $options['maxRedirs']);
        curl_exec($ch);

        curl_close($ch);
        fclose($fh);

        return $file_path;
    }
}
