<?php
    
class I_BancoService{

   
    /**
     * Form constructor
     * @param $param Request
     */
    public static function importBancos($param = null)
    {
             
       try
       {
                    
          $objects = IBanco::getBancoByTitulosAbertos();
          
          if($objects){
              IBanco::setBancoImportedInRepository($objects);
          }
            
            
        }
        catch(Exception $e)
        {    
            
            throw new Exception("Problemas carregando dados dos bancos do ERP! ".$e->getMessage());
        }
       
    }
    
    
    

    
}





