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
            throw new Exception("Problemas carregando dados das agencias do ERP! ".$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}








