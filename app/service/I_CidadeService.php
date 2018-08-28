<?php
    
class I_CidadeService{

     
    /**
     * Form constructor
     * @param $param Request
     */
    public static function importCidades( $param = null )
    {
            
       try
       {
            
                    
          $objects = ICidade::getCidadeByTitulosAbertos();
          
          if($objects){
              ICidade::setCidadeImportedInRepository($objects);
          }
            
            
        }
        catch(Exception $e)
        {    
            new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}



