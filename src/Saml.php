<?php

namespace asminog\yii2saml;

use Yii;
use Exception;
use OneLogin\Saml2\Auth;
use OneLogin\Saml2\Settings;
use yii\base\BaseObject;

/**
 * SL This class wraps OneLogin_Saml2_Auth class by creating an instance of that class using configurations specified in configFileName variable inside @app/config folder.
 */
class Saml extends BaseObject
{

    /**
     * The file in which contains OneLogin_Saml2_Auth configurations.
     * @var string
     */
    public $configFileName = '@app/config/saml.php';

    /**
     * OneLogin_Saml2_Auth instance.
     * @var \OneLogin\Saml2\Auth
     */
    private $instance;

    /**
     * Configurations for OneLogin_Saml2_Auth.
     * @var array
     */
    public $config;

    public function init()
    {
        parent::init();

        if (empty($this->config)) {
            $configFile = Yii::getAlias($this->configFileName);
            $this->config = require($configFile);
        }
        
        echo "<pre>";
        print_r($this->config);
        print_r($_SERVER);
        exit;

        $this->instance = new Auth($this->config);
    }

    /**
     * Call the login method on OneLogin_Saml2_Auth.
     */
    public function login($returnTo = null, $parameters = array(), $forceAuthn = false, $isPassive = false)
    {
        return $this->instance->login($returnTo, $parameters, $forceAuthn, $isPassive);
    }

    /**
     * Call the logout method on OneLogin_Saml2_Auth.
     */
    public function logout($returnTo = null, $parameters = array(), $nameId = null, $sessionIndex = null)
    {
        return $this->instance->logout($returnTo, $parameters, $nameId, $sessionIndex);
    }

    /**
     * Call the getAttributes method on OneLogin_Saml2_Auth.
     */
    public function getAttributes()
    {
        return $this->instance->getAttributes();
    }

    /**
     * Call the getAttribute method on OneLogin_Saml2_Auth.
     */
    public function getAttribute($name)
    {
        return $this->instance->getAttribute($name);
    }

    /**
     * Returns the metadata of this Service Provider in xml.
     * @return string Metadata in xml
     * @throws Exception
     * @throws OneLogin\Saml2\Error
     */
    public function getMetadata()
    {
        $samlSettings = new Settings($this->config, true);
        $metadata = $samlSettings->getSPMetadata();

        $errors = $samlSettings->validateMetadata($metadata);
        if (!empty($errors)) {
            throw new Exception('Invalid Metadata Service Provider');
        }

        return $metadata;
    }

    /**
     * Call the processResponse method on OneLogin_Saml2_Auth.
     */
    public function processResponse()
    {
        $this->instance->processResponse();
    }

    public function processSLO()
    {
        $this->instance->processSLO();
    }

    /**
     * Call the getErrors method on OneLogin_Saml2_Auth.
     */
    public function getErrors()
    {
        return $this->instance->getErrors();
    }

    /**
     * Call the getLastErrorReason method on OneLogin_Saml2_Auth.
     */
    public function getLastErrorReason()
    {
        return $this->instance->getLastErrorReason();
    }

    /**
     * Check if debug is enabled on OneLogin_Saml2_Auth.
     */
    public function isDebugActive()
    {
        $samlSettings = $this->instance->getSettings();
        return $samlSettings->isDebugActive();
    }

    /**
     * Check if user is authenticated.
     */
    public function isAuthenticated()
    {
        return $this->instance->isAuthenticated();
    }
}
