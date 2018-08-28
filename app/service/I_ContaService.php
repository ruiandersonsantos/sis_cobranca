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
           new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}







