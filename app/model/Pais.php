<?php

class Pais extends TRecord
{    
    use UtilImportDataTrait;
     
    const TABLENAME  = 'pais';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    private static $database = 'bd_cobranca';
   
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('chave_origem');
        parent::addAttribute('descricao');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
    }

    
    /**
     * Method getEstados
     */
    public function getEstados()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('pais_id', '=', $this->id));
        return Estado::getObjects( $criteria );
    }
}

