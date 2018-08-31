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
            TTransaction::rollback();
            new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}

