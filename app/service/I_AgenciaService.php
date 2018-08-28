<?php
    
class I_AgenciaService{

  
   
   
    public static function importAgencia()
    {
              
       try
       {
            
         
          
          $objects = IAgencia::getAgenciaByTitulosAbertos();
          
          if($objects){
          
              IAgencia::setAgenciaImportedInRepository($objects);
          }
            
            
        }
        catch(Exception $e)
        {    
           new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}








