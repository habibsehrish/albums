<?php

class IndexController extends Zend_Controller_Action
{

  
 public function init()
    {
    
     //hello
    }

    public function indexAction()
    {
        // home page:listing of albums

  
      $albums = new Application_Model_DbTable_Albums();
      $temp= $albums->fetchAll();

         //-------Pagination------------
        $page=$this->_getParam('page',1);
        $paginator = Zend_Paginator::factory($temp);
        $paginator->setItemCountPerPage('5');
        $paginator->setCurrentPageNumber($page);
        $this->view->albums = $paginator;
        //-------end of pagination-------
        //-------end of pagination-------
        $form = new Application_Form_SignIn();
        $this->view->SignIn = $form;

    }


    public function addAction()
    {
        // addition
        if(Zend_Auth::getInstance()->hasIdentity())
        {
        $form = new Application_Form_Album();
        $form->submit->setLabel('Add');
        $this->view->form = $form;

    if ($this->getRequest()->isPost()) {
        $formData = $this->getRequest()->getPost();
    if ($form->isValid($formData)) {
             $artist = $form->getValue('artist');
             $title = $form->getValue('title');
             $albums = new Application_Model_DbTable_Albums();
             $albums->addAlbum($artist, $title);
             $this->_helper->redirector('index');
            } 
    else {
         $form->populate($formData);
        }
    }
}
        else
        {
            $this->_redirect('login');
        }

    }



    public function editAction()
    {
        // editing
         if(Zend_Auth::getInstance()->hasIdentity())
        {
        $form = new Application_Form_Album();
        $form->submit->setLabel('Save');
        $this->view->form = $form;
    if ($this->getRequest()->isPost()) {
        $formData = $this->getRequest()->getPost();
    if ($form->isValid($formData)) {
                $id = (int)$form->getValue('id');
                $artist = $form->getValue('artist');
                $title = $form->getValue('title');
                $albums = new Application_Model_DbTable_Albums();
                $albums->updateAlbum($id, $artist, $title);
        $this->_helper->redirector('index');
            } 
    else {
        $form->populate($formData);
         }
        } 

    else {
        $id = $this->_getParam('id', 0);
    if ($id > 0) {
            $albums = new Application_Model_DbTable_Albums();
            $form->populate($albums->getAlbum($id));
                 }
        }
}
        else
        {
            $this->_redirect('login');
        }

    }


    public function deleteAction()
    {
        // deletion
if(Zend_Auth::getInstance()->hasIdentity())
        {

if ($this->getRequest()->isPost()) {
            $del = $this->getRequest()->getPost('del');
if ($del == 'Yes') { 
                $id = $this->getRequest()->getPost('id');
                $albums = new Application_Model_DbTable_Albums();
                $albums->deleteAlbum($id);
    }
        $this->_helper->redirector('index');
        } 
        else {
            $id = $this->_getParam('id', 0);
            $albums = new Application_Model_DbTable_Albums();
            $this->view->album = $albums->getAlbum($id);
        }


        }
        else
        {
            $this->_redirect('login');
        }
    }



}








