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

    protected function parserRequest($request){
        $contracts = array();
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