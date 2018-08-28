<?php
/**
 * IBanco Active Record
 * @author  <your-name-here>
 */
class IBanco extends TRecord
{
    use UtilImportDataTrait;
    
    const TABLENAME = 'i_banco';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'serial'; // {max, serial}
    
    private static $database = 'bd_cobranca';
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('chave_origem');
        parent::addAttribute('codigo');
        parent::addAttribute('nome_banco');
        parent::addAttribute('nome_banco_completo');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
        parent::addAttribute('importado');
    }
    
   
    
    public static function getBancoByTitulosAbertos()
    {
    
        $objects = new stdClass;
        
        $ObjLog = new LogImportacao();
        $ObjLog->nome_classe = get_class();
        $ObjLog->nome_metodo = __FUNCTION__ ;
        $ObjLog->inicio = date('Y-m-d H:i:s');
        
        try
        {
            TTransaction::open('STARWESTCON');
        
        	$conn = TTransaction::get();
        	
        	$sqlstring = " SELECT 
                            	A01.UKEY CHAVE_PRIMARIA_ORIGEM,
                            	A01_001_C CODIGO,
                            	A01_002_C NOME_BANCO,
                            	A01_003_C NOME_BANCO_COMPLETO
                            FROM F13(NOLOCK)
                            INNER JOIN f12(NOLOCK) ON f12.ukey = f13.F12_UKEY
                            INNER JOIN A01(NOLOCK) ON A01.UKEY = F13.A01_UKEY
                            WHERE (F13_009_B - F13_021_B - F13_029_B - F13_025_B) > 0.10 -- PARCELA EM ABERTO
                            	AND F13_003_D < GETDATE() -- VENCIMENTO MENOR QUE HOJE
                            	AND F12_016_C = '001'
                            	AND ISNULL(F13_997_D, '19990101') < GETDATE() -- PRORROGAÇÃO MENOR QUE HOJE
                            GROUP BY
                            	A01.UKEY,
                            	A01_001_C,
                            	A01_002_C,
                            	A01_003_C ";
                          
        	$result = $conn->query($sqlstring);
        	
        	$objects = $result->fetchAll(PDO::FETCH_CLASS, "stdClass");
            	
            
            TTransaction::close();
            
            $ObjLog->quantidade_registro = count($objects);
            $ObjLog->fim = date('Y-m-d H:i:s');
            $ObjLog->ocorrencia = 'SUCESSO';
           
        }
        catch(Exception $e)
        {
            TTransaction::rollback();
            
            $ObjLog->fim = date('Y-m-d H:i:s');
            $ObjLog->ocorrencia = 'ERROR '. $e->getMessage();
            self::setLogImported($ObjLog);
            
            throw new Exception("Problemas carregando dados do ERP! ".$e->getMessage());
           
        }
        
        self::setLogImported($ObjLog);
        return $objects;
    
    }
    
    public static function setBancoImportedInRepository($objects)
    {
        $ObjLog = new LogImportacao();
        $ObjLog->nome_classe = get_class();
        $ObjLog->nome_metodo = __FUNCTION__ ;
        $ObjLog->inicio = date('Y-m-d H:i:s');
        
        try
    	{    
    	     TTransaction::open(self::$database);
    	
    	     foreach($objects as $object) 
             { 
              
                
                $obj = new IBanco();
                
                $objRetorno = $obj->getImportedByOrigem($object->CHAVE_PRIMARIA_ORIGEM,'IBanco');
                
                if(isset($objRetorno->id))
                {
                    $obj = $objRetorno;
                }
                               
                
                $obj->chave_origem = $object->CHAVE_PRIMARIA_ORIGEM ;
                $obj->codigo = $object->CODIGO ;
                $obj->nome_banco = $object->NOME_BANCO ;
                $obj->nome_banco_completo = $object->NOME_BANCO_COMPLETO ;
                                    
                $obj->ultima_atualizacao = date('Y-m-d H:i:s');
                $obj->qt_atualizacoes = $obj->qt_atualizacoes + 1;
                
               
                
               $obj->store();
             
                
             }
             
             TTransaction::close(); // close the transaction   
    		$ObjLog->quantidade_registro = count($objects);
            $ObjLog->fim = date('Y-m-d H:i:s');
            $ObjLog->ocorrencia = 'SUCESSO';
    	}
    	catch(Exception $e)
        {
            TTransaction::rollback();
            
            $ObjLog->fim = date('Y-m-d H:i:s');
            $ObjLog->ocorrencia = 'ERROR '. $e->getMessage();
            self::setLogImported($ObjLog);
            
            throw new Exception("Problemas na gravação de dados no repositorio! ".$e->getMessage());
        
        }
    
        self::setLogImported($ObjLog);
    
    }


}
