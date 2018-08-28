<?php
    
class I_BancoControl extends TPage{

   
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
       parent::__construct();
       
       try
       {
            
          $Ibanco = new IBanco();
          
          $objects = $Ibanco->getBancoByTitulosAbertos();
          
          if($objects){
              $Ibanco->setBancoImportedInRepository($objects);
          }
            
            
        }
        catch(Exception $e)
        {    
            
            new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}





