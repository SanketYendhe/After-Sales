<?php
    session_start();
    function sendOutput($success, $data, $httpHeadersCode)
    {
        header_remove('Set-Cookie');
        $httpHeaders = ['Content-Type: application/json'];
        switch($httpHeadersCode)
        {
            case 200:
                array_push($httpHeaders,"HTTP/1.1 200 Ok");
                break;
            
            case 404:
                array_push($httpHeaders,"HTTP/1.1 404 Not Found");
                break;
            
            case 401:
                array_push($httpHeaders,"HTTP/1.1 401 Unauthorized");
                break;
            
            case 400:
                array_push($httpHeaders,"HTTP/1.1 400 Bad Request");
                break;
        }
        if (is_array($httpHeaders) && count($httpHeaders)) {
            foreach ($httpHeaders as $httpHeader) {
                header($httpHeader);
            }
        }
        $json = json_encode(array('success'=>$success,'data'=>$data));
        echo $json;
        exit;
    }