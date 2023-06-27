<?php
    require_once 'dbconfig.php';
    require_once 'common.php';
    require_once 'validate.php';
    class Product extends DB
    {
        function create($productName,$policyId)
        {
            $sql = "SELECT * FROM policies WHERE policyId='$policyId'";
            $res = mysqli_query($this->conn,$sql);
            if(!mysqli_num_rows($res)>0)
            {
                sendOutput(false,"Policy not found",200);
            }
            $sql = "INSERT INTO products(productName) VALUES('$productName')";
            if(mysqli_query($this->conn,$sql))
            {
                $productId = $this->conn->insert_id;
                $sql = "INSERT INTO productHas(productId,policyId) VALUES('$productId','$policyId')";
                if(mysqli_query($this->conn,$sql))
                    sendOutput(true,'Product created successfully',200);
                else
                    sendOutput(false, 'Policy mapping failed '.mysqli_error($this->conn), 200);
            }
            else
            {
                sendOutput(false, 'Product creation failed '.mysqli_error($this->conn), 200);
            }
        }
        function get($productId=-1)
        {
            if($productId==-1)
            {
                $sql = "SELECT * FROM products";
                $res = mysqli_query($this->conn,$sql);
                $json = [];
                if(mysqli_num_rows($res)>0)
                {
                    while($row=mysqli_fetch_array($res))
                    {
                        $js['productId']=$row['productId'];
                        $js['productName']=$row['productName'];
                        array_push($json,json_encode($js));
                    }
                    sendOutput(true,$json,200);
                }
                else
                {
                    sendOutput(false,'Products Not Found',200);
                }
            }
            else
            {
                $sql = "SELECT * FROM products WHERE productId='$productId'";
                $res = mysqli_query($this->conn,$sql);
                $json = [];
                if(mysqli_num_rows($res)>0)
                {
                    while($row=mysqli_fetch_array($res))
                    {
                        $js['productId']=$row['productId'];
                        $js['productName']=$row['productName'];
                        array_push($json,json_encode($js));
                    }
                    sendOutput(true,$json,200);
                }
                else
                {
                    sendOutput(false,'Products Not Found',200);
                }
            }
        }
    }