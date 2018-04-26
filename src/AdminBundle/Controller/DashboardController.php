<?php

namespace AdminBundle\Controller;

use AppBundle\Api\InfoApi\Conmpany\CompanyApi;
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

        $companies = (new CompanyApi($twig))->getCompanies();
        dump($companies);
        return $this->render('@Admin/dashboard.html.twig', [
                'documents' => $documents,
                'waitingClients' => $companies
            ]
        );
    }

}
