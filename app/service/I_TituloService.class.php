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
            
            throw new Exception("Problemas carregando dados dos titulos do ERP! ".$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}





