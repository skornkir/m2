<?php

namespace DocumentBundle\Utils;

class DocumentApi extends InfoApi {

    public function  __construct(\Twig_Environment $twig){
        parent::__construct($twig);
    }

    public function getTypicalDocuments(){
        $operation = 750;
        $query = array(
          'StandardDocument' => [
              'Offset' => 1
          ]
        );

        $response = $this->getResponse($operation, $query);
        return $this->parserRequest($response);
    }

    public function getTypicalDocument($id){
        $operation = 750;
        $query = array(
            'StandardDocument' => [
                'DocumentID' => $id,
            ]
        );

        $response = $this->getResponse($operation, $query);
        $document = array();
        if(!empty($response)){
            libxml_use_internal_errors(true);
            $xml_result = simplexml_load_string($response);
            if (!$xml_result) {
                // echo "Failed loading XML\n"; //logger
            }
            else{
                foreach($xml_result->entities as $item){
                    $document = array(
                        "DocumentID" => (string)$item->entity->StandardDocument->DocumentID,
                        "DocumentName" => (string)$item->entity->StandardDocument->DocumentName,
                        "DocumentDescription" => (string)$item->entity->StandardDocument->DocumentDescription,
                        "DocumentTypeID" => (string)$item->entity->StandardDocument->DocumentTypeID,
                        "DocumentExampleURL" => (string)$item->entity->StandardDocument->DocumentExampleURL,
                        "ID" => (string)$item->entity->StandardDocument->DocumentID,
                    );
                }
            }

        }
        return $document;
    }

    public function getTypicalDocumentOptions(){
        $documents = $this->getTypicalDocuments();
        $options = array();
        foreach ($documents as $id => $document){
            $options[$id] = $document['DocumentName'];
        }
        return $options;
    }

    protected function parserRequest($request){
        $documents = array();
        if(!empty($request)){
            libxml_use_internal_errors(true);
            $xml_result = simplexml_load_string($request);
            if (!$xml_result) {
               // echo "Failed loading XML\n"; //logger
                dump('no valid xml');
            }
            else{
                foreach($xml_result->entities as $item){
                    $documents[] = array(
                        "DocumentID" => (string)$item->entity->StandardDocument->DocumentID,
                        "DocumentName" => (string)$item->entity->StandardDocument->DocumentName,
                        "DocumentDescription" => (string)$item->entity->StandardDocument->DocumentDescription,
                        "DocumentTypeID" => (string)$item->entity->StandardDocument->DocumentTypeID,
                        "DocumentExampleURL" => (string)$item->entity->StandardDocument->DocumentExampleURL,
                        "ID" => (string)$item->entity->StandardDocument->DocumentID,
                    );
                }
            }

        }
        return $documents;
    }
}