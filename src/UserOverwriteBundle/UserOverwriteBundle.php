<?php

namespace UserOverwriteBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UserOverwriteBundle extends Bundle
{
  public function getParent()
  {
      return 'FOSUserBundle';
  }
}
