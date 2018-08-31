<?php
    
class I_EstadoService{

    
    public static function importEstados( $param = null )
    {
              
       try
       {
         
          $objects = IEstado::getEstadoByTitulosAbertos();
          
          if($objects){
              IEstado::setEstadoImportedInRepository($objects);
          }  
           
            
            
        }
        catch(Exception $e)
        {    
            
            new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}


