<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DashboardController extends Controller
{
    /**
     * @Route("admin")
     */
    public function dashboardAction()
    {
        return $this->render('@Admin/dashboard.html.twig', array(
        ));
    }

}
