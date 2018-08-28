<?php
/**
 * Teste2 Registration
 * @author  <your name here>
 */
class Teste2 extends TPage
{
    private $form;
    private $datagrid;
    private $pageNavigation;
    private $loaded;
    
    /**
     * Class constructor
     * Creates the page and the registration form
     */
    function __construct()
    {
        parent::__construct();
        
        // creates the form
        $this->form = new TForm('form_SystemAccessLog');
        
        try
        {
            // TUIBuilder object
            $ui = new TUIBuilder(500,500);
            $ui->setController($this);
            $ui->setForm($this->form);
            
            // reads the xml form
            $ui->parseFile('app/forms/teste.form.xml');
            
            // get the interface widgets
            $fields = $ui->getWidgets();
            // look for the TDataGrid object
            foreach ($fields as $name => $field)
            {
                if ($field instanceof TDataGrid)
                {
                    $this->datagrid = $field;
                    $this->pageNavigation = $this->datagrid->getPageNavigation();
                }
            }
            
            // add the TUIBuilder panel inside the TForm object
            $this->form->add($ui);
            // set form fields from interface fields
            $this->form->setFields($ui->getFields());
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
        
        // add the form to the page
        parent::add($this->form);
    }
    

    /**
     * method mostar()()
     * Load the datagrid with the database objects
     */
    function mostar()($param = NULL)
    {
        try
        {
            // open a transaction with database 'bd_cobranca'
            TTransaction::open('bd_cobranca');
            
            // creates a repository for SystemAccessLog
            $repository = new TRepository('SystemAccessLog');
            $limit = 10;
            // creates a criteria
            $criteria = new TCriteria;
            $criteria->setProperties($param); // order, offset
            $criteria->setProperty('limit', $limit);
            
            if (TSession::getValue('SystemAccessLog_filter'))
            {
                // add the filter stored in the session to the criteria
                $criteria->add(TSession::getValue('SystemAccessLog_filter'));
            }
            
            // load the objects according to criteria
            $objects = $repository->load($criteria);
            
            $this->datagrid->clear();
            if ($objects)
            {
                // iterate the collection of active records
                foreach ($objects as $object)
                {
                    // add the object inside the datagrid
                    $this->datagrid->addItem($object);
                }
            }
            
            // reset the criteria for record count
            $criteria->resetProperties();
            $count= $repository->count($criteria);
            
            $this->pageNavigation->setCount($count); // count of records
            $this->pageNavigation->setProperties($param); // order, page
            $this->pageNavigation->setLimit($limit); // limit
            
            // close the transaction
            TTransaction::close();
            $this->loaded = true;
        }
        catch (Exception $e) // in case of exception
        {
            // shows the exception error message
            new TMessage('error', '<b>Error</b> ' . $e->getMessage());
            // undo all pending operations
            TTransaction::rollback();
        }
    }
    
    /**
     * method show()
     * Shows the page
     */
    function show()
    {
        // check if the datagrid is already loaded
        if (!$this->loaded)
        {
            $this->mostar()();
        }
        parent::show();
    }

}