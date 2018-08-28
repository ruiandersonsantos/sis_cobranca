<?php
    
class I_ParcelaControl extends TPage{

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
            
          $IParcela = new IParcela();
          
          $objects = $IParcela->getParcelaByTitulosAbertos();
          
          if($objects){
              $IParcela->setParcelaImportedInRepository($objects);
          }  
            
            
        }
        catch(Exception $e)
        {    
            
            new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}





