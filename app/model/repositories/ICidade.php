<?php
/**
 * ICidade Active Record
 * @author  <your-name-here>
 */
class ICidade extends TRecord
{
    use UtilImportDataTrait;
     
    const TABLENAME = 'i_cidade';
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
        parent::addAttribute('descricao');
        parent::addAttribute('chave_estado');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
        parent::addAttribute('importado');
    }
    
    
     public static function getCidadeByTitulosAbertos()
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
        	
        	$sqlstring = "SELECT A24.UKEY CHAVE_PRIMARIA_ORIGEM, A24_001_C MUNICIPIO, A24.A23_UKEY CHAVE_ESTADO FROM F13(NOLOCK)
                            INNER JOIN F12(NOLOCK) ON F12.UKEY = F13.F12_UKEY
                            INNER JOIN A03(NOLOCK) ON A03.UKEY = F12.F12_UKEYP
                            INNER JOIN A24(NOLOCK) ON A24.UKEY = A03.A24_UKEY
                            WHERE (F13_009_B - F13_021_B - F13_029_B - F13_025_B) > 0.10 -- PARCELA EM ABERTO
                            	AND F13_003_D < GETDATE() -- VENCIMENTO MENOR QUE HOJE
                            	AND F12_016_C = '001'
                            	AND ISNULL(F13_997_D, '19990101') < GETDATE() -- PRORROGAÇÃO MENOR QUE HOJE
                            GROUP BY A24.UKEY, A24_001_C, A24.A23_UKEY ";
                          
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
     
     
     public static function setCidadeImportedInRepository($objects)
     {
        $ObjLog = new LogImportacao();
        $ObjLog->nome_classe = get_class();
        $ObjLog->nome_metodo = __FUNCTION__ ;
        $ObjLog->inicio = date('Y-m-d H:i:s');
        try
    	{    
    	    
            if($objects)
        	{    
        	     TTransaction::open(self::$database);
        	
        	     foreach($objects as $object) 
                 { 
                  
                    
                    $obj = new ICidade();
                    
                    $objRetorno = $obj->getImportedByOrigem($object->CHAVE_PRIMARIA_ORIGEM,'ICidade');
                    
                    if(isset($objRetorno->id))
                    {
                        $obj = $objRetorno;
                    }
                                   
                    
                    $obj->chave_origem = $object->CHAVE_PRIMARIA_ORIGEM ;
                    $obj->descricao = $object->MUNICIPIO ;
                    $obj->chave_estado = $object->CHAVE_ESTADO ;
                    $obj->ultima_atualizacao = date('Y-m-d H:i:s');
                    $obj->qt_atualizacoes = $obj->qt_atualizacoes + 1;
                    
                   
                    
                   $obj->store();
                   
                 }
                 
                 TTransaction::close(); 
                 
                 $ObjLog->quantidade_registro = count($objects);
                 $ObjLog->fim = date('Y-m-d H:i:s');
                 $ObjLog->ocorrencia = 'SUCESSO';
                 
        	}     
                
            
    		
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
