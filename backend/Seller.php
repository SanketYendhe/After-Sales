<?php
    require_once 'dbconfig.php';
    require_once 'common.php';
    require_once 'validate.php';
    class Seller extends DB
    {
        function create($sellerName,$city,$email,$mobile,$password)
        {
            $sql = "INSERT INTO seller(sellerName,city,mobile) VALUES('$sellerName','$city','$mobile')";
            if(mysqli_query($this->conn,$sql))
            {
                $sellerId = $this->conn->insert_id;
                $sql = "INSERT INTO user(email,password,type) VALUES('$email','$password','seller')";
                if(mysqli_query($this->conn,$sql))
                {    
                    $uid = $this->conn->insert_id;
                    $sql = "UPDATE seller SET uid='$uid' WHERE sellerId='$sellerId'";
                    if(mysqli_query($this->conn,$sql))
                        sendOutput(true,'Seller created successfully',200);
                    else
                        sendOutput(false,'User mapping faled '.mysqli_error($this->conn),200);
                }
                else
                    sendOutput(false,'User creation faled '.mysqli_error($this->conn),200);
            }
            else
            {
                sendOutput(false, 'Seller creation failed '.mysqli_error($this->conn), 200);
            }
        }
        function get()
        {
            $sql = "SELECT * FROM seller";
            $res = mysqli_query($this->conn,$sql);
            $json = [];
            if(mysqli_num_rows($res)>0)
            {
                while($row=mysqli_fetch_array($res))
                {
                    $js['sellerId']=$row['sellerId'];
                    $js['sellerName']=$row['sellerName'];
                    $js['city']=$row['city'];
                    $js['mobile']=$row['mobile'];
                    $js['uid']=$row['uid'];
                    array_push($json,json_encode($js));
                }
                sendOutput(true,$json,200);
            }
            else
            {
                sendOutput(false,'Customer Not Found',200);
            }
        }
        function createSales($aadhar,$dateOfPurchase,$productId,$price,$userId)
        {
            $sql = "SELECT * FROM products WHERE productId='$productId'";
            $res = mysqli_query($this->conn,$sql);
            if(!mysqli_num_rows($res)>0)
            {
                sendOutput(false,"Product not found",200);
            }
            $sql = "SELECT * FROM seller WHERE uid='$userId'";
            $res = mysqli_query($this->conn,$sql);
            if(!mysqli_num_rows($res)>0)
            {
                sendOutput(false,"Seller not found",200);
            }
            $row=mysqli_fetch_array($res);
            $sellerId=$row['sellerId'];
            $sql = "INSERT INTO buys(aadhar,dateOfPurchase,productId,sellerId,price) VALUES('$aadhar','$dateOfPurchase','$productId','$sellerId','$price')";
            if(mysqli_query($this->conn,$sql))
            {
                sendOutput(true,'Sale created successfully',200);
            }
            else
            {
                sendOutput(false, 'Sale creation failed '.mysqli_error($this->conn), 200);
            }
        }
    }