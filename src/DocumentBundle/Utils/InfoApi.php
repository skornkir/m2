<?php
/**
 * Created by PhpStorm.
 * User: Кирилл
 * Date: 22.04.2018
 * Time: 19:09
 */

namespace DocumentBundle\Utils;


abstract class InfoApi
{

    protected $entryPoint = "https://id01.mandarinpay.com/infoapi";

    protected  $productId = "000464-0001-0001";

    protected  $secret = "123";

    protected  $twig;

    protected function  __construct(\Twig_Environment $twig){
        $this->twig = $twig;
    }

    protected function getResponse($operation, $query){
        $parameters = [
            'operation' => $operation,
            'hash' => $this->getHash($operation),
            'query' => $query,
            'productId' => $this->productId,
        ];
        $request = $this->twig->render('@Document/query.html.twig', $parameters);
        return $this->executeQuery($request);
    }

    protected function getHash($operation){
        $htext = "$this->secret-$operation-$this->productId";
        return  md5($htext);
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

        return $response;
    }
}