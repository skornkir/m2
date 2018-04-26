<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 25.04.2018
 * Time: 16:29
 */

namespace AppBundle\Api\InfoApi\Conmpany;

// <Limit> <Offset> <OrderBy>
use DocumentBundle\Utils\InfoApi;

class CompanyApi extends InfoApi{

    public function __construct(\Twig_Environment $twig){
        parent::__construct($twig);
    }

    public function getCompanies($limit = 10){
        $operation = 750;
        $query = array(
            'Company' => [
                'ClientID' => 44,
                'Limit' => $limit
            ]
        );

        $response = $this->getResponse($operation, $query);
        $companies = array();

        if(!empty($response)){
            libxml_use_internal_errors(true);
            $xml_result = simplexml_load_string($response);
            if (!$xml_result) {
                // echo "Failed loading XML\n"; //logger
            }
            else{
                foreach($xml_result->entities as $item){
                    $id = $item->entity->Company->ClientID;
                    $companies[] = array(
                        "ClientId" => $id ,
                        "CompanyName" => (string)$item->entity->Company->PartnerRF->CompanyName,
                        'Updated' =>  date("d.m.y", strtotime((string)$item->entity->Company->PartnerRF->updated)) ,

                    );
                }
            }

        }
        return $companies;
    }
}