<?php
    
class I_PaisControl extends TPage{

   
   
   
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
       parent::__construct();
       
       try
       {
            
             
          $IPais = new IPais();
          
          $objects = $IPais->getPaisByTitulosAbertos();
          
          if($objects){
              $IPais->setPaisImportedInRepository($objects);
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

