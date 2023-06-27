<?php
    require_once 'dbconfig.php';
    require_once 'User.php';
    require_once 'common.php';
    require_once 'validate.php';
    class Customer extends DB
    {
        function create($customerName,$customerAddress,$customerPincode,$customerMobile,$customerEmail,$customerAadhar,$password)
        {
            $sql = "INSERT INTO customer(customerName,customerAddress,customerPincode,customerMobile,customerAadhar) VALUES('$customerName','$customerAddress','$customerPincode','$customerMobile','$customerAadhar')";
            if(mysqli_query($this->conn,$sql))
            {
                $customerId=$this->conn->insert_id;
                $user = new User;
                if($uid=$user->create($customerEmail,$password))
                {
                    $sql = "UPDATE customer SET uid='$uid' WHERE customerId='$customerId'";
                    if(mysqli_query($this->conn,$sql))
                        sendOutput(true, 'Customer created successfully', 200);
                    else   
                        sendOutput(false,'User mappping failed',200);
                }   
                else
                {
                    sendOutput(false, 'User creation failed', 200);
                }
            }
            else
            {
                sendOutput(false, 'Customer creation failed '.mysqli_error($this->conn), 200);
            }
        }
        function get()
        {
            $validator = new Validate;
            $userId = $validator->validate($_GET['token']);
            $sql = "SELECT * FROM user WHERE uid='$userId'";
            $res = mysqli_query($this->conn,$sql);
            if(mysqli_num_rows($res)>0)
            {
                $row=mysqli_fetch_array($res);
                $email=$row['email'];
                $user_type=$row['type'];
                if($user_type=="customer")
                {
                    $sql = "SELECT * FROM customer WHERE uid='$userId'";
                    $res = mysqli_query($this->conn,$sql);
                    $json = [];
                    if(mysqli_num_rows($res)>0)
                    {
                        while($row=mysqli_fetch_array($res))
                        {
                            $json['customerId']=$row['customerId'];
                            $json['customerName']=$row['customerName'];
                            $json['customerAddress']=$row['customerAddress'];
                            $json['customerPincode']=$row['customerPincode'];
                            $json['customerMobile']=$row['customerMobile'];
                            $json['customerAadhar']=$row['customerAadhar'];
                            $json['uid']=$row['uid'];
                        }
                        sendOutput(true,[json_encode($json)],200);
                    }
                    else
                    {
                        sendOutput(false,'Customer Not Found',200);
                    }
                }
                else if($user_type=="admin")
                {
                    $sql = "SELECT * FROM customer";
                    $res = mysqli_query($this->conn,$sql);
                    $json = [];
                    if(mysqli_num_rows($res)>0)
                    {
                        while($row=mysqli_fetch_array($res))
                        {
                            $js['customerName']=$row['customerName'];
                            $js['customerAddress']=$row['customerAddress'];
                            $js['customerPincode']=$row['customerPincode'];
                            $js['customerMobile']=$row['customerMobile'];
                            $js['customerAadhar']=$row['customerAadhar'];
                            $js['uid']=$row['uid'];
                            array_push($json,$js);
                        }
                        sendOutput(true,$json,200);
                    }
                    else
                    {
                        sendOutput(true,[],200);
                    }
                }
            }
            else
            {
                sendOutput(false,'User Not Found',200);
            }
        }
    }