<?php
    declare(strict_types=1);
    require_once 'dbconfig.php';
    require_once 'common.php';
    use Firebase\JWT\JWT;
    require_once('vendor/autoload.php');

    class User extends DB
    {
        function create($email,$password,$type="customer")
        {
            $sql = "INSERT INTO user(email,password,type) VALUES('$email','$password','$type')";
            if(mysqli_query($this->conn,$sql))
            {
                return $this->conn->insert_id;
            }
            else
            {
                return false;
            }
        }
        function login($email,$password)
        {
            $sql = "SELECT * FROM user WHERE email='$email' and password='$password'";
            $res = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($res)>0)
            {
                $row=mysqli_fetch_array($res);
                $secretKey  = 'bGS6lzFqvvSQ8ALbOxatm7/Vk7mLQyzqaS34Q4oR1ew=';
                $tokenId    = base64_encode(random_bytes(16));
                $issuedAt   = new DateTimeImmutable();
                $expire     = $issuedAt->modify('+60 minutes')->getTimestamp();      // Add 60 seconds
                $serverName = "your.domain.name";
            
                // Create the token as an array
                $data = [
                    'iat'  => $issuedAt->getTimestamp(),    // Issued at: time when the token was generated
                    'jti'  => $tokenId,                     // Json Token Id: an unique identifier for the token
                    'iss'  => $serverName,                  // Issuer
                    'nbf'  => $issuedAt->getTimestamp(),    // Not before
                    'exp'  => $expire,                      // Expire
                    'data' => [                             // Data related to the signer user
                        'userId' => $row['uid'],            // User name
                    ]
                ];
                $user_type=$row['type'];
            
                // Encode the array to a JWT string.
                $jwt = JWT::encode(
                    $data,      //Data to be encoded in the JWT
                    $secretKey, // The signing key
                    'HS512'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
                );
                $response = json_encode(['token'=>$jwt,'user_type'=>$user_type]);
                sendOutput(true,$response,200);
            }
            else
            {
                sendOutput(false,'Incorrect Credentials',200);
            }
        }
    }