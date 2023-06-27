<?php
    require_once 'Customer.php';
    require_once 'User.php';
    require_once 'Seller.php';
    require_once 'Product.php';
    require_once 'Problem.php';
    require_once 'Policy.php';
    require_once 'Service.php';
    require_once 'common.php';
    require_once 'dbconfig.php';
    $uri = parse_url($_SERVER['REQUEST_URI'],PHP_URL_PATH);
    $uri = explode( '/', $uri );

    $valid_paths=['customer','login','seller','product','service'];
    $validator = new Validate;

    

    if(!isset($uri[5]) || !in_array($uri[5],$valid_paths))
    {
        sendOutput(false,'404',404);
        exit();
    }
    else
    {
        $route = $uri[5];
        $method = $_SERVER['REQUEST_METHOD'];
        $index = array_search($route,$valid_paths);
        switch($index)
        {
            case 0:
                switch($method)
                {
                    case "POST":
                        if(!isset($_POST['customerName']) || !isset($_POST['customerAddress']) || !isset($_POST['customerPincode']) || !isset($_POST['customerMobile']) || !isset($_POST['customerEmail']) || !isset($_POST['customerAadhar']) || !isset($_POST['password']))
                        {
                            sendOutput(false,'Valid Request Parameters Missing',200);
                        }
                        else
                        {
                            $customer = new Customer;
                            $customer->create($_POST['customerName'],$_POST['customerAddress'],$_POST['customerPincode'],$_POST['customerMobile'],$_POST['customerEmail'],$_POST['customerAadhar'],$_POST['password']);
                        }
                        break;
                    
                    case "GET":
                        if(!isset($_GET['token']))
                        {
                            sendOutput(false,'Valid Request Parameters Missing',200);
                        }
                        else
                        {
                            $customer = new Customer;
                            $customer->get();
                        }
                        break;

                    default:
                        sendOutput(false,'404',404);
                        break;
                }
                break;

            case 1:
                switch($method)
                {
                    case "POST":
                        if(!isset($_POST['email']) || !isset($_POST['password']))
                        {
                            sendOutput(false,'Valid Request Parameters Missing',200);
                        }
                        else
                        {
                            $user = new User;
                            $user->login($_POST['email'],$_POST['password']);
                        }
                        break;
                }
                break;
            
            case 2:
                switch($method)
                {
                    case "POST":
                        if(!isset($uri[6]))
                        {
                            if(!isset($_POST['token']) || !isset($_POST['sellerName']) || !isset($_POST['city']) || !isset($_POST['email']) || !isset($_POST['mobile']) || !isset($_POST['password']))
                            {
                                sendOutput(false,'Valid Request Parameters Missing',200);
                            }
                            else
                            {
                                if($validator->validateAdmin($_POST['token']))
                                {
                                    $seller = new Seller;
                                    $seller->create($_POST['sellerName'],$_POST['city'],$_POST['email'],$_POST['mobile'],$_POST['password']);
                                }
                                else
                                {
                                    sendOutput(false,'Unauthorized',401);
                                }
                            }
                        }
                        else
                        {
                            $subRoute=$uri[6];
                            switch($subRoute)
                            {
                                case "sales":
                                    if(!isset($_POST['token']) || !isset($_POST['aadhar']) || !isset($_POST['dateOfPurchase']) || !isset($_POST['productId']) || !isset($_POST['price']))
                                    {
                                        sendOutput(false,'Valid Request Parameters Missing',200);
                                    }
                                    else
                                    {
                                        if($userId=$validator->validateSeller($_POST['token']))
                                        {
                                            $seller = new Seller;
                                            $seller->createSales($_POST['aadhar'],$_POST['dateOfPurchase'],$_POST['productId'],$_POST['price'],$userId);
                                        }
                                        else
                                        {
                                            sendOutput(false,'Unauthorized',401);
                                        }
                                    }
                                    break;
                            }
                        }
                        break;
                    
                    case "GET":
                        if(!isset($_GET['token']))
                        {
                            sendOutput(false,'Valid Request Parameters Missing',200);
                        }
                        if($validator->validateAdmin($_GET['token']))
                        {
                            $seller = new Seller;
                            $seller->get();
                        }
                        else
                        {
                            sendOutput(false,'Unauthorized',401);
                        }
                        break;
                }
            
            case 3:
                switch($method)
                {
                    case "POST":
                        if(!isset($uri[6]))
                        {
                            if(!isset($_POST['token']) || !isset($_POST['productName']) || !isset($_POST['policyId']))
                            {
                                sendOutput(false,'Valid Request Parameters Missing',200);
                            }
                            else
                            {
                                if($validator->validateAdmin($_POST['token']))
                                {
                                    $product = new Product;
                                    $product->create($_POST['productName'],$_POST['policyId']);
                                }
                                else
                                {
                                    sendOutput(false,'Unauthorized',401);
                                }
                            }
                        }
                        else
                        {
                            switch($subRoute)
                            {
                                case "problem":
                                    if(!isset($_POST['token']) || !isset($_POST['problem']))
                                    {
                                        sendOutput(false,'Valid Request Parameters Missing',200);
                                    }
                                    if($validator->validateAdmin($_POST['token']))
                                    {
                                        $problem = new Problem;
                                        $problem->create($_POST['problem']);
                                    }
                                    else
                                    {
                                        sendOutput(false,'Unauthorized',401);
                                    }
                                    break;
                                
                                case "mapProblem":
                                    if(!isset($_POST['token']) || !isset($_POST['productId']) || !isset($_POST['problemId']))
                                    {
                                        sendOutput(false,'Valid Request Parameters Missing',200);
                                    }
                                    if($validator->validateAdmin($_POST['token']))
                                    {
                                        $problem = new Problem;
                                        $problem->map($_POST['productId'],$_POST['problemId']);
                                    }
                                    else
                                    {
                                        sendOutput(false,'Unauthorized',401);
                                    }
                                    break;
                                
                                case "policy":
                                    if(!isset($_POST['token']) || !isset($_POST['replacableMonths']) || !isset($_POST['freeRepairMonths']) || !isset($_POST['warrantyPeriod']))
                                    {
                                        sendOutput(false,'Valid Request Parameters Missing',200);
                                    }
                                    if($validator->validateAdmin($_POST['token']))
                                    {
                                        $policy = new Policy;
                                        $policy->create($_POST['replacableMonths'],$_POST['freeRepairMonths'],$_POST['warrantyPeriod']);
                                    }
                                    else
                                    {
                                        sendOutput(false,'Unauthorized',401);
                                    }
                                    break;
                            }
                        }
                        break;
                    
                    case "GET":
                        $product = new Product;
                        if(isset($_GET['productId']))
                        {
                            $product->get($_GET['productId']);
                        }
                        else
                        {
                            $product->get();
                        }
                        break;
                    
                }
                break;
            
            case 4:
                switch($method)
                {
                    case "POST":
                        if(!isset($uri[6]))
                        {
                            if(!isset($_POST['token']) || !isset($_POST['productId']) || !isset($_POST['invoiceNo']) || !isset($_POST['problemId']) || !isset($_POST['problemDescription']) || !isset($_POST['requestDate']))
                            {
                                sendOutput(false,'Valid Request Parameters Missing',200);
                            }
                            if($userId=$validator->ValidateCustomer($_POST['token']))
                            {
                                $service = new Service;
                                $service->createRequest($userId,$_POST['productId'],$_POST['invoiceNo'],$_POST['problemId'],$_POST['problemDescription'],$_POST['requestDate']);
                            }
                        }
                        else
                        {
                            $subRoute=$uri[6];
                            switch($subRoute)
                            {
                                case "createDealer":
                                    if(!isset($_POST['token']) || !isset($_POST['dealerName']) || !isset($_POST['dealerMobile']) || !isset($_POST['dealerEmail']) || !isset($_POST['password']) || !isset($_POST['servicablePincodes']))
                                    {
                                        sendOutput(false,'Valid Request Parameters Missing',200);
                                    }
                                    if($validator->validateAdmin($_POST['token']))
                                    {
                                        $service = new Service;
                                        $service->createDealer($_POST['dealerName'],$_POST['dealerMobile'],$_POST['dealerEmail'],$_POST['password'],$_POST['servicablePincodes']);
                                    }
                                    else
                                    {
                                        sendOutput(false,'Unauthorized',401);
                                    }
                                    break;
                                
                                case "createTechnician":
                                    if(!isset($_POST['token']) || !isset($_POST['technicianName']) || !isset($_POST['technicianMobile']) || !isset($_POST['technicianEmail']) || !isset($_POST['password']))
                                    {
                                        sendOutput(false,'Valid Request Parameters Missing',200);
                                    }
                                    if($userId=$validator->ValidateDealer($_POST['token']))
                                    {
                                        $service = new Service;
                                        $service->createTechnician($_POST['technicianName'],$_POST['technicianMobile'],$_POST['technicianEmail'],$_POST['password'],$userId);
                                    }
                                    else
                                    {
                                        sendOutput(false,'Unauthorized',401);
                                    }
                                    break;
                            }
                        }
                        break;
                }
                break;
            
        }
        exit();
    }
?>