<?php
    
class I_AgenciaControl extends TPage{

  
   
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
       parent::__construct();
       
       try
       {
            
          $IAgencia = new IAgencia();
          
          $objects = $IAgencia->getAgenciaByTitulosAbertos();
          
          if($objects){
              $IAgencia->setAgenciaImportedInRepository($objects);
          }
            
            
        }
        catch(Exception $e)
        {    
           new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}






