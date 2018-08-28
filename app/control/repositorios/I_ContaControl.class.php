<?php
    
class I_ContaControl extends TPage{

     private static $database = 'bd_cobranca';
   
   
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
       parent::__construct();
       
       try
       {
            
          $IConta = new IConta();
          
          $objects = $IConta->getContaByTitulosAbertos();
          
          if($objects){
              $IConta->setContaImportedInRepository($objects);
          }
            
            
        }
        catch(Exception $e)
        {    
           new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}







