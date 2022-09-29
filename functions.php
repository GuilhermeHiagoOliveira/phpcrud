<?php
class Functions
{
    public function select()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, 'http://localhost/quality/api/functions/select.php');
        $response = curl_exec($curl);
        curl_close($curl);

        $result = (json_decode($response, true));
        return $result["body"];
    }

    public function search()
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_URL, 'http://localhost/quality/api/functions/search.php');
        $response = curl_exec($curl);
        curl_close($curl);
        $result = (json_decode($response, true));
        return $result;
        return $result["body"];
    }
}
