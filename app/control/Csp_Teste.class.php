<?php
    // simone
class Csp_Teste extends TPage{

     private static $database = 'bd_cobranca';
   
   
    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
       parent::__construct();
       
       try
       {
            
           TTransaction::open('STARWESTCON');
        
            	$conn = TTransaction::get();
            	
            	$sqlstring = 'SELECT A22.UKEY CHAVE_PRIMARIA
    	                            ,A22_001_C PAIS
                              FROM A22(NOLOCK)';
                              
            	$result = $conn->query($sqlstring);
            	
            	$objects = $result->fetchAll(PDO::FETCH_CLASS, "stdClass");
            	
            
            TTransaction::close();
            
            if($objects)
        	{   
        	     foreach($objects as $object) 
                 { 
                  
                    
                    $objPais = new IPais();
                    
                    $objPais = $objPais->getIPaisByOrigem($object->CHAVE_PRIMARIA);
                    
                    $objPais->chave_origem = $object->CHAVE_PRIMARIA ;
                    $objPais->descricao = $object->PAIS ;
                    $objPais->data_hora = date('d/m/y H:i:s');
                    
                    TTransaction::open(self::$database);
                    
                    $objPais->store();
                    
                    TTransaction::close(); // close the transaction
                    
                    echo $objPais->chave_origem . " - ". $objPais->descricao . " - ". $objPais->data_hora . " - ".     "</br>";
                    
                 
                   
                    
                 }   
        		
        	}
        }
        catch(Exception $e)
        {
            new TMessage('error',$e->getMessage());
        }
       
    }
    
    
    // Teste de segundo commit


    
}