<?php
    
class I_ContaService{

    
    public static function importContas( $param = null)
    {
             
       try
       {
            
          $objects = IConta::getContaByTitulosAbertos();
          
          if($objects){
              IConta::setContaImportedInRepository($objects);
          }
            
            
        }
        catch(Exception $e)
        {    
           throw new Exception("Problemas carregando dados das contas do ERP! ".$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}







