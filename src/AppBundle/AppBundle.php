<?php
// src/AppBundle/AppBundle.php

namespace AppBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class AppBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}