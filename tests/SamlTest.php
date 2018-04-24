<?php

namespace asminog\yii2saml\tests;

use asminog\yii2saml\Saml;

class SamlTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateInstance()
    {
        $instance = new Saml();
        $this->assertNotEquals($instance, null);
    }

}
