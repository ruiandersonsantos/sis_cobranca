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
            
            throw new Exception("Problemas carregando dados dos estados do ERP! ".$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}


