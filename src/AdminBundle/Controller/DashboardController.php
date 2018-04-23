<?php

namespace AdminBundle\Controller;

use DocumentBundle\Utils\CompanyDocumentApi;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{
    /**
     * @Route("admin", name="admin")
     */
    public function dashboardAction()
    {
        $twig = $this->get('twig');
        $companyDocument = new CompanyDocumentApi($twig);
        $documents = $companyDocument->getCompanyDocuments( 'processing');
        dump($documents);
        return $this->render('@Admin/dashboard.html.twig', array( 'documents' => $documents));
    }

}
