<?php
    require_once 'dbconfig.php';
    require_once 'common.php';
    require_once 'validate.php';
    class Policy extends DB
    {
        function create($replacableMonths,$freeRepairMonths,$warrantyPeriod)
        {
            $sql = "INSERT INTO policies(replacableMonths,freeRepairMonths,warrantyPeriod) VALUES('$replacableMonths','$freeRepairMonths','$warrantyPeriod')";
            if(mysqli_query($this->conn,$sql))
            {
                sendOutput(true,'Policy created successfully',200);
            }
            else
            {
                sendOutput(false, 'Policy creation failed '.mysqli_error($this->conn), 200);
            }
        }
    }