<?php

namespace DocumentBundle\Controller;

use DocumentBundle\Utils\CompanyDocumentApi;
use DocumentBundle\Utils\ContractApi;
use DocumentBundle\Utils\DocumentApi;
use DocumentBundle\Utils\ServiceApi;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class TypicalDocumentController extends Controller
{
    /**
     * @Route("admin/documentflow/documents", name="typedoc")
     */
    function showTypicalDocumentAction(){
        $api = new DocumentApi($this->get('twig'));
        $documents = $api->getTypicalDocuments(); 
        return $this->render('@Document/TypicalDocuments/documents.html.twig',['documents' => $documents]);
    }

    /**
     * @Route("admin/documentflow/contracts", name="typecontract")
     */
    function showTypicalContractAction(){
        $api = new ContractApi($this->get('twig'));
        $contracts = $api->getTypicalContracts();
        $documents = $api->documentApi->getTypicalDocumentOptions();
        return $this->render('@Document/TypicalDocuments/contracts.html.twig',['contracts' => $contracts, 'documents' => $documents] );
    }

    /**
     * @Route("admin/documentflow/services", name="typeservice")
     */
    function showTypicalServicetAction(){
        $api = new ServiceApi($this->get('twig'));
        $services = $api->getTypicalServices();
        $contracts = $api->contractApi->getTypicalContractOptions();
        return $this->render('@Document/TypicalDocuments/services.html.twig',['services' => $services, 'contracts' => $contracts] );
    }

    /**
     * @Route("admin/document/flow", name="doc_in_progress")
     */
    function showDocumentsInProgress(){
        $companyDocument = new CompanyDocumentApi($this->get('twig'));
        $documents = $companyDocument->getCompanyDocuments('processing');
        return $this->render('@Document/CompanyDocument/companyDocument.html.twig',['documents' => $documents ] );
    }
}
