<?php

namespace asminog\yii2saml\actions;

use yii\base\Action;
use Yii;

/**
 * Base class for actions.
 */
abstract class BaseAction extends Action
{

    /**
     * This variable should be the component name of asminog\yii2saml\Saml.
     * @var string
     */
    public $samlInstanceName = 'saml';

    /**
     * This variable hold the instance of asminog\yii2saml\Saml.
     * @var \asminog\yii2saml\Saml
     */
    protected $samlInstance;

    public function init()
    {
        parent::init();

        $this->samlInstance = Yii::$app->get($this->samlInstanceName);
    }

}
