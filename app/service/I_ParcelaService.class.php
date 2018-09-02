<?php
    
class I_ParcelaService{

    public static function importParcelas( $param = null )
    {
             
       try
       {
            
          $objects = IParcela::getParcelaByTitulosAbertos();
          
          if($objects){
          
              IParcela::setParcelaImportedInRepository($objects);
          }  
            
            
        }
        catch(Exception $e)
        {    
            
            throw new Exception("Problemas carregando dados das parcelas do ERP! ".$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}





