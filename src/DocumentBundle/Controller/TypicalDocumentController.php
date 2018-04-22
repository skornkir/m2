<?php

namespace DocumentBundle\Controller;

use DocumentBundle\Utils\ContractApi;
use DocumentBundle\Utils\DocumentApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TypicalDocumentController extends Controller
{
    /**
     * @Route("admin/documentflow/documents", name="typedoc")
     */
    function showTypicalDocumentAction(){
        $api = new DocumentApi($this->container->get('twig'));
        $documents = $api->getTypicalDocuments();
        return $this->render('@Document/TypicalDocuments/documents.html.twig',['documents' => $documents]);
    }

    /**
     * @Route("admin/documentflow/contracts", name="typecontract")
     */
    function showTypicalContractAction(){
        $api = new ContractApi($this->container->get('twig'));
        $contracts = $api->getTypicalContracts();
        $documents = $api->documentApi->getTypicalDocumentOptions();
        return $this->render('@Document/TypicalDocuments/contracts.html.twig',['contracts' => $contracts, 'documents' => $documents] );
    }

    /**
     * @Route("admin/documentflow/services", name="typeservice")
     */
    function showTypicalServicetAction(){
        $api = new ContractApi($this->container);
        $contracts = $api->getTypicalDocuments();
        return $this->render('@Document/TypicalDocuments/documents.html.twig',['contracts' => $contracts, 'documents' => array()] );
    }
}
