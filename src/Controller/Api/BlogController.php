<?php

namespace App\Controller\Api;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations\{Delete, Get, Post, Put, Patch};
use FOS\RestBundle\Controller\Annotations\View as ViewAttribute;

class BlogController extends AbstractFOSRestController
{

    #[Get(path: "/posts")]
    #[ViewAttribute(serializerGroups: ['post','author'], serializerEnableMaxDepthChecks: true)]
    public function getAction() {
        return "hola mundo";
    }
}