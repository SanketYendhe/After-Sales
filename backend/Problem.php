<?php
    require_once 'dbconfig.php';
    require_once 'common.php';
    require_once 'validate.php';
    class Problem extends DB
    {
        function create($problem)
        {
            $sql = "INSERT INTO problems(problem) VALUES('$problem')";
            if(mysqli_query($this->conn,$sql))
            {
                sendOutput(true,'Problem created successfully',200);
            }
            else
            {
                sendOutput(false, 'Problem creation failed '.mysqli_error($this->conn), 200);
            }
        }
        function map($productId,$problemId)
        {
            $sql = "SELECT * FROM products WHERE productId='$productId'";
            $res = mysqli_query($this->conn,$sql);
            if(!mysqli_num_rows($res)>0)
            {
                sendOutput(false,"Product not found",200);
            }
            $sql = "SELECT * FROM problems WHERE problemId='$problemId'";
            $res = mysqli_query($this->conn,$sql);
            if(!mysqli_num_rows($res)>0)
            {
                sendOutput(false,"Problem not found",200);
            }
            $sql = "INSERT INTO problemhas(productId,problemId) VALUES('$productId','$problemId')";
            if(mysqli_query($this->conn,$sql))
            {
                sendOutput(true,'Problem mapped successfully',200);
            }
            else
            {
                sendOutput(false, 'Problem mapping failed '.mysqli_error($this->conn), 200);
            }
        }
    }