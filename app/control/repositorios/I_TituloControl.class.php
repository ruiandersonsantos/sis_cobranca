<?php
    
class I_TituloService{

   
    public function __construct( $param )
    {
       parent::__construct();
       
       try
       {
            
         $ITitulo = new ITitulo();
          
          $objects = $ITitulo->getTituloByTitulosAbertos();
          
          if($objects){
              $ITitulo->setTituloImportedInRepository($objects);
          }  
            
            
        }
        catch(Exception $e)
        {    
            
            new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}





