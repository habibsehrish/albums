<?php

class Application_Form_SignIn extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setAction('login');
        $this->setMethod('post');
        $email = $this->createElement('text','email');
        $email->setLabel('email: *')
                ->setRequired(true);
                
        $password = $this->createElement('password','password');
        $password->setLabel('password: *')
                ->setRequired(true);
                
        $signin = $this->createElement('submit','SignIn');
        $signin->setLabel('SignIn')
                ->setIgnore(true);
                
        $this->addElements(array(
                        $email,
                        $password,
                        $signin, 

                        ));
    }


}

