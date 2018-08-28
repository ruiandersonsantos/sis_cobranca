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
            
            new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}





