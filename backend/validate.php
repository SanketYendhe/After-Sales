<?php

declare(strict_types=1);

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require_once('vendor/autoload.php');
require_once('common.php');
require_once 'dbconfig.php';

class Validate extends DB
{
    function validate($token)
    {
        try
        {
            if (! preg_match('/(\S+)/', $token, $matches)) {
                sendOutput(false,'Token not found in request1',400);
                exit;
            }
            $jwt = $matches[1];
            if (! $jwt) {
                // No token was able to be extracted from the authorization header
                sendOutput(false,'Token not found in request',400);
                exit;
            }
            
            $secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
            //$token = JWT::decode($jwt, $secretKey, ['HS512']);
            $token = JWT::decode($jwt, new Key($secretKey, 'HS512'));
            $now = new DateTimeImmutable();
            $serverName = "your.domain.name";
            
            if ($token->iss !== $serverName ||
                $token->nbf > $now->getTimestamp() ||
                $token->exp < $now->getTimestamp())
            {
                sendOutput(false,'Token not valid',401);
                exit;
            }
            return $token->data->userId;
        }
        catch(Firebase\JWT\ExpiredException $e)
        {
            sendOutput(false,'Token Expired',401);
        }
    }
    
    function validateAdmin($token)
    {
        try
        {
            if (! preg_match('/(\S+)/', $token, $matches)) {
                sendOutput(false,'Token not found in request1',400);
                exit;
            }
            $jwt = $matches[1];
            if (! $jwt) {
                // No token was able to be extracted from the authorization header
                sendOutput(false,'Token not found in request',400);
                exit;
            }
            
            $secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
            //$token = JWT::decode($jwt, $secretKey, ['HS512']);
            $token = JWT::decode($jwt, new Key($secretKey, 'HS512'));
            $now = new DateTimeImmutable();
            $serverName = "your.domain.name";
            
            if ($token->iss !== $serverName ||
                $token->nbf > $now->getTimestamp() ||
                $token->exp < $now->getTimestamp())
            {
                sendOutput(false,'Token not valid',401);
                exit;
            }
            
            $userId=$token->data->userId;
            $sql="SELECT * FROM user WHERE uid='$userId'";
            $res = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($res)>0)
            {
                $row=mysqli_fetch_array($res);
                $user_type=$row['type'];
                if($user_type=='admin')
                {
                    return true;
                }
            }
            else
            {
                return false;
            }
        }
        catch(Firebase\JWT\ExpiredException $e)
        {
            sendOutput(false,'Token Expired',401);
        }
    }
    function ValidateSeller($token)
    {
        try
        {
            if (! preg_match('/(\S+)/', $token, $matches)) {
                sendOutput(false,'Token not found in request1',400);
                exit;
            }
            $jwt = $matches[1];
            if (! $jwt) {
                // No token was able to be extracted from the authorization header
                sendOutput(false,'Token not found in request',400);
                exit;
            }
            
            $secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
            //$token = JWT::decode($jwt, $secretKey, ['HS512']);
            $token = JWT::decode($jwt, new Key($secretKey, 'HS512'));
            $now = new DateTimeImmutable();
            $serverName = "your.domain.name";
            
            if ($token->iss !== $serverName ||
                $token->nbf > $now->getTimestamp() ||
                $token->exp < $now->getTimestamp())
            {
                sendOutput(false,'Token not valid',401);
                exit;
            }
            
            $userId=$token->data->userId;
            $sql="SELECT * FROM user WHERE uid='$userId'";
            $res = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($res)>0)
            {
                $row=mysqli_fetch_array($res);
                $user_type=$row['type'];
                if($user_type=='seller')
                {
                    return $userId;
                }
            }
            else
            {
                return false;
            }
        }
        catch(Firebase\JWT\ExpiredException $e)
        {
            sendOutput(false,'Token Expired',401);
        }
    }
    function ValidateDealer($token)
    {
        try
        {
            if (! preg_match('/(\S+)/', $token, $matches)) {
                sendOutput(false,'Token not found in request1',400);
                exit;
            }
            $jwt = $matches[1];
            if (! $jwt) {
                // No token was able to be extracted from the authorization header
                sendOutput(false,'Token not found in request',400);
                exit;
            }
            
            $secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
            //$token = JWT::decode($jwt, $secretKey, ['HS512']);
            $token = JWT::decode($jwt, new Key($secretKey, 'HS512'));
            $now = new DateTimeImmutable();
            $serverName = "your.domain.name";
            
            if ($token->iss !== $serverName ||
                $token->nbf > $now->getTimestamp() ||
                $token->exp < $now->getTimestamp())
            {
                sendOutput(false,'Token not valid',401);
                exit;
            }
            
            $userId=$token->data->userId;
            $sql="SELECT * FROM user WHERE uid='$userId'";
            $res = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($res)>0)
            {
                $row=mysqli_fetch_array($res);
                $user_type=$row['type'];
                if($user_type=='service_dealer')
                {
                    return $userId;
                }
            }
            else
            {
                return false;
            }
        }
        catch(Firebase\JWT\ExpiredException $e)
        {
            sendOutput(false,'Token Expired',401);
        }
    }
    function ValidateCustomer($token)
    {
        try
        {
            if (! preg_match('/(\S+)/', $token, $matches)) {
                sendOutput(false,'Token not found in request1',400);
                exit;
            }
            $jwt = $matches[1];
            if (! $jwt) {
                // No token was able to be extracted from the authorization header
                sendOutput(false,'Token not found in request',400);
                exit;
            }
            
            $secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
            //$token = JWT::decode($jwt, $secretKey, ['HS512']);
            $token = JWT::decode($jwt, new Key($secretKey, 'HS512'));
            $now = new DateTimeImmutable();
            $serverName = "your.domain.name";
            
            if ($token->iss !== $serverName ||
                $token->nbf > $now->getTimestamp() ||
                $token->exp < $now->getTimestamp())
            {
                sendOutput(false,'Token not valid',401);
                exit;
            }
            
            $userId=$token->data->userId;
            $sql="SELECT * FROM user WHERE uid='$userId'";
            $res = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($res)>0)
            {
                $row=mysqli_fetch_array($res);
                $user_type=$row['type'];
                if($user_type=='customer')
                {
                    return $userId;
                }
            }
            else
            {
                return false;
            }
        }
        catch(Firebase\JWT\ExpiredException $e)
        {
            sendOutput(false,'Token Expired',401);
        }
    }
}





// Show the page