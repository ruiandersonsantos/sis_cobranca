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
            throw new Exception("Problemas carregando dados dos clientes do ERP! ".$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}




