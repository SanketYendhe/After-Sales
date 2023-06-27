<?php
    require_once 'dbconfig.php';
    require_once 'common.php';
    require_once 'validate.php';
    class Service extends DB
    {
        function createRequest($userId,$productId,$invoiceNo,$problemId,$problemDescription,$requestDate)
        {
            $sql = "SELECT * FROM customer WHERE uid='$userId'";
            $res = mysqli_query($this->conn,$sql);
            if(!mysqli_num_rows($res)>0)
            {
                sendOutput(false,"Customer not found",200);
            }
            $row=mysqli_fetch_array($res);
            $customerId=$row['customerId'];
            $customerPincode=$row['customerPincode'];
            $sql = "INSERT INTO servicerequest(customerId,productId,invoiceNo,problemId,problemDescription,requestDate,status) VALUES('$customerId','$productId','$invoiceNo','$problemId','$problemDescription','$requestDate','request_received')";
            if(mysqli_query($this->conn,$sql))
            {
                $requestId = $this->conn->insert_id;
                $sql = "SELECT * FROM dealerserves WHERE pincode='$customerPincode'";
                $res = mysqli_query($this->conn,$sql);
                if(mysqli_num_rows($res)>0)
                {
                    $row=mysqli_fetch_array($res);
                    $dealerId = $row['dealerId'];
                    $sql = "INSERT INTO serveby(requestId,dealerId) VALUES('$requestId','$dealerId')";
                    if(mysqli_query($this->conn,$sql))
                    {
                        sendOutput(true,'Service Request created successfully',200);
                    }
                    else
                    {
                        sendOutput(false,"Dealer mapping failed",200);
                    }
                }
                else
                {
                    $sql = "DELETE FROM servicerequest WHERE requestId='$requestId'";
                    mysqli_query($this->conn,$sql);
                    sendOutput(false,"No Service Dealer found at pincode ".$customerPincode,200);
                }
            }
            else
            {
                sendOutput(false,"Request creation failed ".mysqli_error($this->conn),200);
            }
        }
        function createTechnician($technicianName,$technicianMobile,$technicianEmail,$password,$userId)
        {
            $sql = "SELECT * FROM servicedealer WHERE uid='$userId'";
            $res = mysqli_query($this->conn,$sql);
            if(!mysqli_num_rows($res)>0)
            {
                sendOutput(false,"Dealer not found",200);
            }
            $row=mysqli_fetch_array($res);
            $dealerId=$row['dealerId'];

            $sql = "INSERT INTO technicians(technicianName,technicianMobile) VALUES('$technicianName','$technicianMobile')";
            if(mysqli_query($this->conn,$sql))
            {
                $technicianId = $this->conn->insert_id;
                $sql = "INSERT INTO user(email,password,type) VALUES('$technicianEmail','$password','technician')";
                if(mysqli_query($this->conn,$sql))
                {
                    $uid = $this->conn->insert_id;
                    $sql = "UPDATE technicians SET uid='$uid' WHERE technicianId='$technicianId'";
                    if(mysqli_query($this->conn,$sql))
                    {
                        $sql = "INSERT INTO worksfor(technicianId,dealerId) VALUES('$technicianId','$dealerId')";
                        if(mysqli_query($this->conn,$sql))
                            sendOutput(true,'Techician created successfully',200);
                        else
                            sendOutput(false,'Worksfor mapping faled '.mysqli_error($this->conn),200);
                    }
                    else
                        sendOutput(false,'User creation faled '.mysqli_error($this->conn),200);
                }
                else
                    sendOutput(false,'User creation faled '.mysqli_error($this->conn),200);
            }
            else
            {
                sendOutput(false, 'Technician creation failed '.mysqli_error($this->conn), 200);
            }
        }

        function createDealer($dealerName,$dealerMobile,$dealerEmail,$password,$servicablePincodes)
        {
            $sql = "INSERT INTO servicedealer(dealerName,dealerMobile) VALUES('$dealerName','$dealerMobile')";
            if(mysqli_query($this->conn,$sql))
            {
                $dealerId = $this->conn->insert_id;
                $sql = "INSERT INTO user(email,password,type) VALUES('$dealerEmail','$password','service_dealer')";
                if(mysqli_query($this->conn,$sql))
                {    
                    $uid = $this->conn->insert_id;
                    $sql = "UPDATE servicedealer SET uid='$uid' WHERE dealerId='$dealerId'";
                    if(mysqli_query($this->conn,$sql))
                    {
                        $flag=true;
                        $servicablePincodes=explode(',',$servicablePincodes);
                        foreach($servicablePincodes as $pincode)
                        {
                            $pincode = (int) $pincode;
                            $sql = "INSERT INTO dealerserves(dealerId,pincode) VALUES('$dealerId','$pincode')";
                            if(!mysqli_query($this->conn,$sql))
                                $flag=false;
                        }
                        if($flag)
                            sendOutput(true,'Dealer created successfully',200);
                        else
                            sendOutput(false,'Pincode mapping failed',200);
                    }
                    else
                        sendOutput(false,'User mapping faled '.mysqli_error($this->conn),200);
                }
                else
                    sendOutput(false,'User creation faled '.mysqli_error($this->conn),200);
            }
            else
            {
                sendOutput(false, 'Dealer creation failed '.mysqli_error($this->conn), 200);
            }
        }
    }