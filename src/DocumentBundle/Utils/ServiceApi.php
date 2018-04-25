<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 22.04.2018
 * Time: 12:04
 */

namespace DocumentBundle\Utils;


class ServiceApi extends DocumentFlowApi{

    public $contractApi;

    public function __construct(\Twig_Environment $twig)
    {
        parent::__construct($twig);
        $this->contractApi = new ContractApi($twig);
    }

    private function getContractOfService($id){
        $operation = 750;
        $query = array(
            'StandardContractOfService' => [
                'Service' => [
                    'ServiceID' => $id,
                ]
            ]
        );

        $response = $this->getResponse($operation, $query);

        $contracts = array();
        if(!empty($response)){
            libxml_use_internal_errors(true);
            $xml_result = simplexml_load_string($response);
            if (!$xml_result) {
            }
            else{
                foreach($xml_result->entities as $item){
                    $id = (string)$item->entity->StandardContractOfService->StandardContract->ContractID;
                    $contract = $this->contractApi->getTypicalContract($id);
                    $contracts[$id] = $contract;
                }
            }
        }

        return $contracts;
    }

    public function getTypicalServices(){
        $operation = 750;
        $query = array(
            'Service' => [
                'Offset' => 1
            ]
        );

        $response = $this->getResponse($operation, $query);
        return $this->parserRequest($response);
    }

    protected function parserRequest($request){
        $contracts = array();
        if(!empty($request)){
            libxml_use_internal_errors(true);
            $xml_result = simplexml_load_string($request);
            if (!$xml_result) {
            }
            else{
                foreach($xml_result->entities as $item){
                    $id = (string)$item->entity->Service->ServiceID;
                    $contracts[$id] = array(
                        "ServiceID" => $id,
                        "ServiceName" => (string)$item->entity->Service->ServiceName,
                        "ServiceDescription" => (string)$item->entity->Service->ServiceDescription,
                    );
                    $contracts[$id]['contractList'] = $this->getContractOfService($id);
                }
            }
        }
        return $contracts;
    }
}