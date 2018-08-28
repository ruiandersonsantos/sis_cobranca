<?php
    
class I_CidadeControl extends TPage{

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
            
          $ICidade = new ICidade();
          
          $objects = $ICidade->getCidadeByTitulosAbertos();
          
          if($objects){
              $ICidade->setCidadeImportedInRepository($objects);
          }
            
            
        }
        catch(Exception $e)
        {    
            new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}



