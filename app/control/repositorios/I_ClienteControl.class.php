<?php
    
class I_ClienteControl extends TPage{

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
          $ICliente = new ICliente();
          
          $objects = $ICliente->getClienteByTitulosAbertos();
          
          if($objects){
              $ICliente->setClienteImportedInRepository($objects);
          } 
           
            
            
        }
        catch(Exception $e)
        {    
            new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}




