<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 22.04.2018
 * Time: 19:08
 */

namespace DocumentBundle\Utils;


class CompanyDocumentApi extends DocumentApi
{

    private $documentApi;

    public function __construct(\Twig_Environment $twig)
    {
        parent::__construct($twig);
        $this->documentApi = new DocumentApi($twig);
    }

    public function getCompanyDocumentsResponse( $status = 'False'){
        $query = array(
            'CompanyDocument' => array(
                'Company' => array(
                    //'ClientID' => $clientId
                )
            )
        );
        if($status != False){
            $query['CompanyDocument']['DocumentStatus'] = $status;
        }
        $operation = 750;
        return $this->getResponse($operation, $query);
    }

    public function getCompanyDocuments($status = 'False'){
        $response = $this->getCompanyDocumentsResponse($status);
        $documents = array();
        if(!empty($response)){
            libxml_use_internal_errors(true);
            $xml_result = simplexml_load_string($response);
            if (!$xml_result) {
                dump('no valid xml');
            }
            else{
                foreach($xml_result->entities as $item){
                    $companyDocument = $item->entity->CompanyDocument;
                    $id = (string)$companyDocument->CompanyDocumentID;
                    $documents[$id] = array(
                        "DocumentURL" => (string)$companyDocument->DocumentURL,
                        "ClientID" => (string)$companyDocument->Company->ClientID,
                        "Document" => $this->documentApi->getTypicalDocument((string)$companyDocument->StandardDocument->DocumentID),
                        "DocumentStatus" => (string)$companyDocument->DocumentStatus,
                        "ID" => $id,
                    );
                    $files = array();
                    foreach ($companyDocument->Files as $file) {
                        $files[] = array(
                            "filesID" => (string)$file->filesID,
                            "Description" => (string)$file->Description,
                            "File" => (string)$file->File,
                            "created" => (string)$file->created,
                        );
                    }
                    $documents[$id]['files'] = $files;
                }
            }
        }
        return $documents;
    }
}