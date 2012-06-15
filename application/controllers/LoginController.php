<?php

class LoginController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body


     $form = new Application_Form_SignIn();
        $this->view->SignIn = $form;
        
        $authAdapter = $this->getAuthAdapter();
           
        if ($this->getRequest()->isPost()) 
            {
            
            $formData = $this->getRequest()->getPost();
            

            if ($form->isValid($formData)) 
                {
                $email    = $form->getValue('email');
                $password = $form->getValue('password');
                $authAdapter->setIdentity($email)
                            ->setCredential($password);
                
             $auth = Zend_Auth::getInstance();
        
             $result = $auth->authenticate($authAdapter);
         
        
             if($result->isValid())
               {
                    //$auth->getStorage()->write($authAdapter->getResultRowObject(array('id', 'f_name','level')));
                    
                    $this->_redirect('index');
               }
               else
            {
                //$form->populate($formData);
                $this->view->SignUpError = "Invalid Username or Password";
            }
                
            } 
            else
            {
                $form->populate($formData);
            }
               
          } 
        }  



 private function getAuthAdapter()
    {
        $auth = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $auth->setTableName('users')
             ->setIdentityColumn('email')
             ->setCredentialColumn('password');
        
        return $auth;
    }


}

