<?php

/**
 * @author GallerySoft.info
 * @copyright 2018
 */

class IOServices
{
    var $resCode;
    var $partnerTransId;
    var $description;
    var $partnerCode = "paycard365_AirtimeIV";
    var $partner_3DES_key = "H3zVvWCLkbQxZgGWgQu17REEnN1wWN2pXqCZOO2aZQDxD4cSAKSGVL4kmRfemjdf";
    var $clientDateTime;
    function TopupMobile($telco, $mobileNo, $amount, $isPrePay, $trace, $type)
    {
        include_once 'service.php';
        $this->description="nap tien dien thoai thanh cong";
        $this->partnerTransId="12345678";
        $this->resCode="99";
        $this->clientDateTime="";
        $iomedia = new ioneMedia();
        //$Trace=rand(10000000,99999999);
        //$clientDateTime=date("YmdHis",time());
        $parrams=array('partnerCode'=>'','partnerTransId'=>$trace,'telcoCode'=>$telco,'mobileType'=>'TT','mobileNo'=>$mobileNo,'topupAmount'=>$amount,'clientDateTime'=>date("YmdHis",time()));
        $resultio= $iomedia->directTopup($parrams);
        //var_dump($resultio);die;
        //$resultio=json_decode('{"resCode":"00","partnerTransId":"15496913","partnerCode":"paycard365_AirtimeIV","telcoCode":"VP","mobileType":"TT","mobileNo":"0913081236","topupAmount":"10000","discountValue":"560","debitValue":"9440","clientDateTime":"20180621100225","serverDateTime":"20180621100226","description":"SUCCESS","sign":"Q4SLT6c53XQcQk9hW4wHEgBdz1T1vX7NNlCovpViPA\/RiJ2OOdyIn6F8Mhd8UXKnO+HBYDI9g8tr\r\n3lNzAQqEUguBmCFGaYX7HBH7aIFiGfhPEsMNHy8mYfbm57JtpXkoLp2WmKRo4tdj1\/chzXLdKEih\r\nvK8qxGaHrsDSfSdLi\/s=","message":"Th\u00e0nh c\u00f4ng","verify":false}',true);//
        if(count($resultio)>0){
            $this->description=$resultio['description'];
        $this->partnerTransId=$resultio['partnerTransId'];
        $this->resCode=$resultio['resCode'];
        $this->clientDateTime=$resultio['clientDateTime'];
        $result=array("resCode"=>$this->resCode,"partnerTransId"=>$this->partnerTransId,"description"=>$this->description,"clientDateTime"=>$this->clientDateTime);
        
        }else{            
        
            $result=array("resCode"=>$this->resCode,"partnerTransId"=>$this->partnerTransId,"description"=>$this->description,"clientDateTime"=>$this->clientDateTime);
        
        }
        return $result;
    }
}

?>