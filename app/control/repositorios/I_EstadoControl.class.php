<?php
    
class I_EstadoControl extends TPage{

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
          $IEstado = new IEstado();
          
          $objects = $IEstado->getEstadoByTitulosAbertos();
          
          if($objects){
              $IEstado->setEstadoImportedInRepository($objects);
          }  
           
            
            
        }
        catch(Exception $e)
        {    
            
            new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}


