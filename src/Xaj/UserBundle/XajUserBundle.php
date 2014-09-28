<?php

namespace Xaj\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class XajUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
