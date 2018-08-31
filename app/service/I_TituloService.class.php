<?php
    
class I_TituloService{

   
    public static function importTitulos( $param = null )
    {
             
       try
       {
        $objects = ITitulo::getTituloByTitulosAbertos();
          
          if($objects){
          
              ITitulo::setTituloImportedInRepository($objects);
          }  
            
            
        }
        catch(Exception $e)
        {    
            
            new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}





