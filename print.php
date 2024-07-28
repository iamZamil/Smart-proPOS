<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(0);

require_once "connection.php";
session_start();
$file_name=$_SESSION['email'];
$folder_name='pdfs';
require_once 'dompdf/autoload.inc.php';
$FillByClient="";
 if(!empty($_GET['email'])){
     $user_pdf_email=$_GET['email'];
     $email = $_GET['email'];
     if(array_key_exists('FillByClient',$_GET)){
        $FillByClient =  $_GET['FillByClient'];
     }
    $_SESSION['pdf_email']=$email;
    if($FillByClient == "1"){
       //  echo "Application will be filled by client";
         $hidden = "";
     }
    else{
        $hidden = "hidden";
    }
    
    //to get worksheet data
        $query =  "SELECT * FROM tiptop_worksheet WHERE `email` = '$email'";
        $r1=[];
        $json1=[];
        $p_query=mysqli_query($con,$query);
        if(mysqli_num_rows($p_query)>0){
            
            while($r=mysqli_fetch_assoc($p_query)){
                array_push($r1,$r);
            }

        }
        $json1=$r1;
        $vol=$json1[0]['card_volume'];
        $lender1=$json1[0]['lender1'];
        $cm1=$json1[0]['contract_amount1'];
        $terms1=$json1[0]['terms1'];
        $lender2=$json1[0]['lender2'];
        $cm2=$json1[0]['contract_amount2'];
        $terms2=$json1[0]['terms2'];
        $lender3=$json1[0]['lender3'];
        $cm3=$json1[0]['contract_amount3'];
        $terms3=$json1[0]['terms3'];
        $details_table=mysqli_query($con,"SELECT * FROM tiptop_details WHERE `email` = '$email'");
        if(!$details_table){
            echo mysqli_error($con);
        }else{
            $r2=[];
        if(mysqli_num_rows($details_table)>0){
                while($r=mysqli_fetch_assoc($details_table)){
                    array_push($r2,$r);
                }
                $json=$r2;
            }

        }
    function DBin($string){
            return str_replace("'","",$string);   
    }
    $funding_requested=$json[0]['funding_requested'];
    $funding_reason=$json[0]['funding_reason'];
    $business_name = DBin($json[0]['business_name']);
    $business_address = $json[0]['business_address'];
    $city = $json[0]['city'];
    $state = $json[0]['state'];
    $zip_code = $json[0]['zip_code'];
    $business_phone = $json[0]['business_phone'];
    $business_starting_date = $json[0]['business_starting_date'];
    $tax_id=$json[0]['tax_id'];
    $monthly_revenue = $json[0]['monthly_revenue'];
    $entity_type=$json[0]['entity_type'];
    $industry_type=$json[0]['industry_type'];
    $website=$json[0]['website'];
    $first_name=$json[0]['first_name'];
    $last_name=$json[0]['last_name'];
    $email=$json[0]['email'];
    $phone_number=$json[0]['phone_number'];
    $personal_address=$json[0]['personal_address'];
    $personal_city=$json[0]['personal_city'];
    $personal_state=$json[0]['personal_state'];
    $personal_zip_code=$json[0]['personal_zip_code'];
    $credit_score=$json[0]['credit_score'];
    $ssn=$json[0]['ssn'];
     $dob=$json[0]['dob']; 
    $co_name=$json[0]['co_owner_first_name'];
    $co_l_name=$json[0]['co_owner_last_name'];
    $co_city=$json[0]['co_owner_city'];
     $co_state=$json[0]['co_owner_state'];
     $co_zip_code=$json[0]['co_owner_postal_code'];
     $co_owner_address=$json[0]['co_owner_address'];
     $co_ssn=$json[0]['co_owner_ssn'];
     $co_owner_dob=$json[0]['co_owner_dob'];
     $co_owner_ownership=$json[0]['co_owner_ownership'];
     $reference=$json[0]['reference'];
    $co_credit=$json[0]['co_owner_credit_score'];
    $co_owner_email=$json[0]['co_owner_email'];
    $co_owner_phone=$json[0]['co_owner_phone'];
    $sign=$json[0]['sign'];
     $paths=$json[0]['paths'];
    $own=$json[0]['ownership'];
    $dba=$json[0]['dba'];
    $today = date("m-d-Y");
   $path1=explode(',',$paths);
   
    }
use Dompdf\Dompdf; 
// Instantiate and use the dompdf class 
// $dompdf = new Dompdf();
// $dompdf->set_paper(array(0,0,600,800));

// $GLOBALS['bodyHeight'] = 0;

// $dompdf->setCallbacks(
//   array(
//     'myCallbacks' => array(
//       'event' => 'end_frame', 'f' => function ($infos) {
//         $frame = $infos["frame"];
//         if (strtolower($frame->get_node()->nodeName) === "body") {
//             $padding_box = $frame->get_padding_box();
//             $GLOBALS['bodyHeight'] += $padding_box['h'];
//         }
//       }
//     )
//   )
// );
// $dompdf->loadHtml($html);
// $dompdf->render();
// unset($dompdf);

$dompdf = new Dompdf();
// $dompdf->set_paper(array(0,0,600,$GLOBALS['bodyHeight']+100));
$options = $dompdf->getOptions();
$options->setChroot('/home/u600808399/domains/tiptopcrm.online/public_html/');
// $options->setChroot('/');
$dompdf->setOptions($options);
$html="<!DOCTYPE html>
<html lang=\"en\">
    <head>
        <meta charset=\"UTF-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
        <title>Tip Top Capital</title>
        <style>
            li{
                font-size:12px;
                
            }
         
           
        </style>
        <style>
@import url('https://fonts.googleapis.com/css?family=Open+Sans|Rock+Salt|Shadows+Into+Light|Cedarville+Cursive');
</style>
    </head>
    <body style=\"margin: 0;padding: 0;font-family: sans-serif;color: #000;\">
        <div>
            <div style=\"padding: 12px 12px; width:100%; max-width: 100%;\">
                <div style=\"display: flex;justify-content: space-between;align-items: center;\">
                    <div style=\"display:inline-block; width:80%\">
                    <img src=\"assets/img/logo.jpg\" id=\"logo\" style=\"width:220px;height:85px;\">
                    </div>
                    <div style=\"display:inline-block; \">
                        <ul style=\"margin-bottom: 0;padding: 0;list-style: none;line-height: 20px;\">
                            <li style=\"font-size:14px\">
                                Tel: (888) 443-4488
                            </li>
                            <li style=\"font-size:14px\">
                                Direct: (212) 252-2217
                            </li>
                            <li style=\"font-size:14px\">
                                Fax: (888) 942-2122
                            </li>
                            <li style=\"font-size:14px\">
                                <a href=\"#\" style=\"text-decoration: none;\">apply@tiptopcap.com</a>
                            </li>
                            <li style=\"font-size:14px\">
                                <a href=\"#\" style=\"text-decoration: none;\">www.tiptopcap.com</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div>
                    <div style=\"font-size: 24px; font-weight: 600; padding: 5px 0;text-align: center;\">
                        WORKING CAPITAL APPLICATION 
                    </div>
                    <div style=\"font-size: 20px; margin-top: 10px;margin-bottom: 10px;\">
                        Company Information
                    </div>
                    <div>
                        <table style=\"margin-bottom: 1px;border-collapse: collapse; width: 100%;\">
                            <tr>
                                <td style=\"width: 50%;font-size: 18px;border: 2px solid #a39f9f;text-align: left;padding: 14px 14px;width:50% !important\" colspan=\"1\">Company/Legal Business Name: <span style=\"font-weight:400 !important;\"> <br/> <b>$business_name</b></span></td>
                                <td style=\"width: 50%;padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width:50% !important\" colspan=\"3\">Doing Business AS/DBA:<span style=\"font-weight:400 !important;\"> <br/> <b>$dba</b></span> </td>
                            </tr>
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;\">Business /Physical Address(No PO Boxes) : <span style=\"font-weight:400 !important;\"> <br/> <b>$business_address</b></span> </td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;\">City: <span style=\"font-weight:400 !important;\"> <br/> <b>$city</b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;width: 15%;\">State: <span style=\"font-weight:400 !important;\"> <br/> <b>$state</b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;width: 15%;\">Zip: <span style=\"font-weight:400 !important;\"> <br/> <b>$zip_code</b></span></td>
                            </tr>
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;width:25% !important\" >Business Phone# : <span style=\"font-weight:400 !important;\"><b ></b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;width:30% !important\" >Business Start Date:  <span style=\"font-weight:400 !important;\"> <br/> <b>$business_starting_date </b></span>  </td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;width:30% !important\">Federal Tax ID:  <span style=\"font-weight:400 !important;\"> <br/>  <b>$tax_id</b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;width:15% !important\" >Entity: <span style=\"font-weight:400 !important;\"> <br/>  <b>$entity_type</b></span></td>
                            </tr>
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width:20% !important\">Monthly Revenue:<span style=\"font-weight:400 !important;\"><br/><b>$monthly_revenue</b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width:30% !important\">
                                   Monthly CC Volume: <br/><b>$vol</b>
                                </td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width:25% !important\">
                                  Industry Type: <span style=\"font-weight:400 !important;\"> <br/><b>$industry_type</b></span>
                                </td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width:25% !important\">
                                  Use Of Funds:<span style=\"font-weight:400 !important;\"><br/><b>$funding_reason</b></span>
                                </td>
                            </tr>
                            
                        </table>
                        <div style=\"font-size: 20px; margin-top: 10px;margin-bottom: 10px;\">
                            Principal Owner #1
                        </div>
                        <table style=\"margin-bottom: 1px;border-collapse: collapse; width: 100%;\">
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width: 25%;\">First Name:<span style=\"font-weight:400 !important;\"><br/><b>$first_name</b></span> </td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width: 25%;\">Last Name: <span style=\"font-weight:400 !important;\"><br/><b>$last_name</b></span> </td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width: 30%;\">Credit Score: <span style=\"font-weight:400 !important;\"><br/><b>$credit_score</b></td>
                                <td style=\"padding: 20px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width: 20%;\" >Ownership%: <span style=\"font-weight:400 !important;\"><br/> <b> $own </b> </span> </td>
                            </tr>
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width:40% !important\" >Home Address:  <span style=\"font-weight:400 !important;\"><br/> <b>$personal_address</b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width:20% !important\">City: <span style=\"font-weight:400 !important;\"> <br/><b>$personal_city</b></span>  </td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width:20% !important\">State: <span style=\"font-weight:400 !important;\"><br/><b>$personal_state</b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width:20% !important\">Zip: <span style=\"font-weight:400 !important;\"><br/><b>$personal_zip_code</b> </span></td>
                            </tr>
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;\">Phone Number:<span style=\"font-weight:400 !important;\" $phone_number><b></b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;\">Email: <span style=\"font-weight:400 !important;\" $email><b></b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;\">SSN:<span style=\"font-weight:400 !important;\"><br/><b>$ssn</b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;\">D.O.B:<span style=\"font-weight:400 !important;\"><br/><b>$dob</b></span></td>
                            </tr>
                        </table>
                        <div style=\"font-size: 20px; margin-top: 10px;margin-bottom: 10px;\">
                            Principal Owner #2
                        </div>
                        <table style=\"margin-bottom: 1px;border-collapse: collapse; width: 100%;\">
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width: 25%;\">First Name:<span style=\"font-weight:400 !important;\"><br/><b>$co_name</b> </span>  </td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width: 25%;\">Last Name:<span style=\"font-weight:400 !important;\"><br/><b>$co_l_name</b></span> </td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width: 30%;\">Credit Score:<br/><b>$co_credit</b></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width: 20%;\" >Ownership%:<span style=\"font-weight:400 !important;\"><br/><b>$co_owner_ownership</b></span></td>
                            </tr>
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width:40% !important\">Home Address:<span style=\"font-weight:400 !important;\"><br/><b>$co_owner_address</b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width:20% !important\">City:<span style=\"font-weight:400 !important;\"><br/><b>$co_city</b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width:20% !important\">State:<span style=\"font-weight:400 !important;\"><br/><b>$co_state</b></span> </td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;width:20% !important\">Zip:<span style=\"font-weight:400 !important;\"><br/><b>$co_zip_code</b></span></td>
                            </tr>
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;\">Phone Number:<span style=\"font-weight:400 !important;\"><b></b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;\">Email:<span style=\"font-weight:400 !important;\"><b></b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;\">SSN:<span style=\"font-weight:400 !important;\"><br/><b>$co_ssn</b></span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: left;\">D.O.B:<span style=\"font-weight:400 !important;\"><br/><b>$co_owner_dob</b></span> </td>
                            </tr>
                        </table>

                        <div style=\"font-size: 20px; margin-top: 10px;margin-bottom: 10px;\">
                            Loan or cash Advance Balance (s)
                        </div>
                        
                        <table style=\"margin-bottom: 1px;border-collapse: collapse; width: 100%;margin-bottom:3px\">
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;width: 33%;\">Company </td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;width: 34%;\">Balance </td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;width: 33%;\">Daily Payment</td>
                            </tr>
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;\"><span style=\"font-weight:400 !important;\"><br/>$lender1</span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;\"><span style=\"font-weight:400 !important;\"><br/>$cm1</span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;\"><span style=\"font-weight:400 !important;\"><br/>$terms1</span></td>
                            </tr>
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;\"><span style=\"font-weight:400 !important;\"><br/>$lender2</span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;\"><span style=\"font-weight:400 !important;\"><br/>$cm2</span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;\"><span style=\"font-weight:400 !important;\"><br/>$terms2</span></td>
                            </tr>
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;\"><span style=\"font-weight:400 !important;\"><br/>$lender3</span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;\"><span style=\"font-weight:400 !important;\"><br/>$cm3</span></td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;\"><span style=\"font-weight:400 !important;\"><br/>$terms3</span></td>
                            </tr>
                            </table>
                            <table style=\"margin-bottom: 1px;border-collapse: collapse; width: 60%;margin-bottom:3px\">
                            <tr>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;\" colspan=\"1\">Amount Requested</td>
                                <td style=\"padding: 14px 14px;font-size: 18px;border: 2px solid #a39f9f;text-align: center;\" colspan=\"2\"><span style=\"font-weight:400 !important;\"><br/>$funding_requested</span></td>
                               
                            </tr>
                            </table>
                            <table style=\"margin-bottom: 1px;border-collapse: collapse; width: 110%;margin-bottom:3px;margin-left:50px\">
                             <tr>
                        <td >
                                <div style=\"font-size: 20px;margin-right:20px \">
                                    Principal Owner #1 Signature 
                                </div>
                                <div>
                                    <ul style=\"padding: 0px;list-style: none;margin-bottom:0px;\">
                                        <li style=\"font-size: 20px;margin-bottom: 7px;display: flex;\">
                                            <span style=\"width: 130px;\">Print Full Name: $first_name $last_name</span>
                                            
                                        </li>
                                        <li style=\"font-size: 20px;margin-bottom: 7px;display: flex;\">
                                            <span style=\"width: 130px;\">Date: $today</span>
                                            
                                        </li>
                                        <li style=\"font-size: 20px;margin-bottom: 7px;display: flex;\">
                                           <span style=\"width: 400px;height:200px\"> Signature:<img src=\"$sign\" width=\"150\" height=\"50\" /></span>
                                           
                                        </li>
                                    </ul>
                                </div>
                            
                        </td>
                        <td >
                        
                                <div style=\"font-size: 20px;\">
                                    Principal Owner #2 Signature 
                                </div>
                                <div>
                                    <ul style=\"padding: 0px;margin-bottom:0px;list-style: none;\">
                                        <li style=\"font-size: 20px;margin-bottom: 7px;display: flex;\">
                                            <span style=\"width: 130px;\">Print Full Name: $co_name $co_l_name </span>
                                            
                                        </li>
                                        <li style=\"font-size: 20px;margin-bottom: 7px;display: flex;\">
                                            <span style=\"width: 130px;\">Date: $today</span>
                                            
                                        </li>
                                        <li style=\"font-size: 20px;margin-bottom: 7px;display: flex;\">
                                           <span style=\"width: 180px;\"> Signature: <i width=\"100\" style=\"font-family: Cedarville Cursive; letter-spacing: -1px;\"> $co_name $co_l_name</i> </span>
                                         
                                        </li>
                                    </ul>
                                </div>
                           
                        </td>
                        </tr>
                        </table>
                      
                            
                     
                        <div>
                            <p style=\"font-size: 9px;text-align: justify;\">
                                By signing, each of the above listed business and business owner/officer (individually and collectively, “you”) authorize Tip Top Capital Inc. (“TTC”) and each of its representatives, successors, assigns and designees (“Recipients”) that may be involved with or
                                acquire commercial loans having daily repayment features or purchases of future receivables including Merchant Cash Advance transactions, including without limitation the application therefore (collectively, “Transactions”) to obtain consumer or personal,
                                business and investigative reports and other information about you, including credit card processor statements and bank statements, from one or more consumer reporting agencies, such as TransUnion, Experian and Equifax, and from other Credit bureaus,
                                banks, creditors and other third parties. You also authorize TTC to transmit this application form, along with any of the foregoing information obtained in connection with this application, to any or all of the recipients for the foregoing purposes to the release, by
                                any creditor or financial institution, of any information relating to any of you, to TTC and to each of the Recipients, on its own behalf. If your application for business credit is denied, you have the right to a written statement of the specific reasons for the denial.
                                To obtain the statement, please contact TTC at the above address or phone number within 60 days from the date you are notified of the credit decision. You have the right to obtain a written statement of reasons for the denial within 30 days of receiving your
                                request for the statement.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>";
$dompdf->loadHtml($html); 
// $dompdf->setPaper('A4', 'portrait'); 
$paper_size = array(0,0,900,1400); 
$dompdf->set_paper($paper_size);
$dompdf->render(); 
$pdf = $dompdf->output();
//code to update path of new pdf
$tm=strtotime("now");
$new_name=$tm."_tiptop.pdf";
$path1['0']="https://tiptopcrm.online/assets/$email/$new_name";
$ful_path=$path1['0'];
$all_path=implode(',',$path1);
$dtr="Link to resubmit application https://tiptopcrm.online/resubmit-application.php?email=$email";

// $curl = curl_init();
// curl_setopt_array($curl, array(
//   CURLOPT_URL => 'https://api.gohighlevel.com/zapier/contact/add_update',
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => '',
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 0,
//   CURLOPT_FOLLOWLOCATION => true,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => 'POST',
//   CURLOPT_POSTFIELDS =>'{
//     "email" : "'.$email.'",
//     "phone" : "'.$phone_number.'",
//     "generated_pdf" : "'.$ful_path.'"
//     }',
//   CURLOPT_HTTPHEADER => array(
//     'Authorization: Bearer 27811cb0-ea9e-4423-b654-0e9cb1b422ee',
//     'Content-Type: application/json'
//   ),
// ));
// $response = curl_exec($curl);
// $feilds = CURLOPT_POSTFIELDS;
// curl_close($curl);

//code to update path in db
$query = "UPDATE tiptop_details SET `paths`=('".$all_path."') WHERE `email` = ('".$email."')";
$update_query=mysqli_query($con,$query);
if(!$query){
    echo mysqli_error($con);
}else{
    echo "Updated";
}
//code to update path
file_put_contents("assets/$email/$new_name", $pdf);
  if($_GET['send_email_as_well']=='yes'){
      $group=$_GET['group'];
     $f_url="https://tiptopcrm.online/send_email_app.php?email=$email&group=$group";
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $f_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
 }elseif($_GET['send_email_as_well']=='new_app'){
       $group=$_GET['group'];
     $f_url="https://tiptopcrm.online/send_email_app_new.php?email=$email&group=$group";
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $f_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);
     
 }else{
     
 }

echo "<script type='text/javascript'>window.location.href='fast-application/thankyou-page.php'</script>";
// Output the generated PDF (1 = download and 0 = preview) 
// $dompdf->stream("ttc", array("Attachment" => 1));
// $output = $dompdf->output();
// mkdir('assets/faraz@gmail.com', 0777);
// $file_location = $_SERVER['DOCUMENT_ROOT']."ttc/assets/".$output.".pdf";
// file_put_contents('ttc.pdf', $output)
?>