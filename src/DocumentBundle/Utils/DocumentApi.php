<?php

namespace DocumentBundle\Utils;

use Symfony\Bridge\Twig\TwigEngine;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DocumentApi{

    protected $entryPoint = "https://id01.mandarinpay.com/infoapi";

    protected  $productId = "000464-0001-0001";

    protected  $secret = "123";

    protected  $container;

    public function  __construct(ContainerInterface $container){
        $this->container = $container;
    }

    public function getTypicalDocuments(){
        $operation = 750;
        $query = array(
          'StandardDocument' => [
              'Offset' => 1
          ]
        );
        $request = $this->container->get('twig')->render('@Document/query.html.twig',[
            'operation' => $operation,
            'hash' => $this->getHash($operation),
            'query' => $query,
            'productId' => $this->productId,
        ]);
        dump($request);
        $response = $this->executeQuery($request);
        return $this->parserRequest($response);
    }

    protected function getHash($operation){
        $htext = "$this->secret-$operation-$this->productId";
        return  md5($htext);
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

    protected function executeQuery($request){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->entryPoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
        $response  = curl_exec($ch);
        curl_close($ch);

//        if(!empty($response)){
//            $xml_response = simplexml_load_string($response);
//            if(isset($xml_response->message) && (string)$xml_response->message != "OK"){
//                global $user;
//                $fields = array(
//                    'uid' => $user->uid,
//                    'request' => $xml,
//                    'response' => $response,
//                    'message' => (string)$xml_response->message,
//                    'code' => (string)$xml_response->code,
//                );
//                mandarin2_slack_notification_api_wrong('Обновление 109го источника', $fields);
//            }
//        }
//        else{
//            global $user;
//            $fields = array(
//                'uid' => $user->uid,
//                'request' => $xml,
//            );
//            mandarin2_slack_notification_api_wrong('Отсутвует ответ 109го источника', $fields);
//        }

        return $response;
    }

}