<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 21.04.2018
 * Time: 14:19
 */

namespace DocumentBundle\Utils;


class ContractApi extends DocumentApi
{
    public $documentApi;

    public function __construct(\Twig_Environment $twig)
    {
        parent::__construct($twig);
        $this->documentApi = new DocumentApi($twig);
    }

    protected function getDocumentContracts($contract_id){
        $operation = 750;

        $query = [
            'StandardContractDocument' => [
                'StandardContract' => [
                    'ContractID' => $contract_id
                ]
            ]
        ];

        $response = $this->getResponse($operation, $query);

        $documents = array();
        if(!empty($response)){
            $xml_result = simplexml_load_string($response);
            foreach($xml_result->entities as $item){
                $id = (string)$item->entity->StandardContractDocument->StandardDocument->DocumentID;
                $documents[$id] = array(
                    'DocumentID' => (string)$item->entity->StandardContractDocument->StandardDocument->DocumentID,
                    'DocumentName' => (string)$item->entity->StandardContractDocument->StandardDocument->DocumentName,
                    'DocumentDescription' => (string)$item->entity->StandardContractDocument->StandardDocument->DocumentDescription,
                    'DocumentTypeID' => (string)$item->entity->StandardContractDocument->StandardDocument->DocumentTypeID,
                    'DocumentExampleURL' => (string)$item->entity->StandardContractDocument->StandardDocument->DocumentExampleURL,
                ) ;

            }
        }
        return $documents;
    }

    public function getTypicalContracts(){
        $operation = 750;
        $query = array(
            'StandardContract' => [
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
                dump('no valid xml');
            }
            else{
                foreach($xml_result->entities as $item){
                    $id = (string)$item->entity->StandardContract->ContractID;
                    $contracts[$id] = array(
                        "ContractID" => (string)$item->entity->StandardContract->ContractID,
                        "ContractName" => (string)$item->entity->StandardContract->ContractName,
                        "ContractDescription" => (string)$item->entity->StandardContract->ContractDescription,
                        "ContractHelpInfo" => (string)$item->entity->StandardContract->ContractHelpInfo,
                        "documentList" => "",
                    );
                    $contracts[$id]['documentList'] = $this->getDocumentContracts($id);
                }
            }
        }
        return $contracts;
    }
}