<?php
    
class I_PaisService{

  
    public static function importPaises( $param = null )
    {
     
       
       try
       {
        
          $objects = IPais::getPaisByTitulosAbertos();
          
          if($objects){
              IPais::setPaisImportedInRepository($objects);
          } 
            
            
        }
        catch(Exception $e)
        {
            throw new Exception("Problemas carregando dados dos paises do ERP! ".$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}

