<?php
    
class I_ClienteService{

   
    public static function importClientes( $param = null )
    {
             
       try
       {
                  
          $objects = ICliente::getClienteByTitulosAbertos();
          
          if($objects){
              ICliente::setClienteImportedInRepository($objects);
          } 
           
            
            
        }
        catch(Exception $e)
        {    
            new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}




