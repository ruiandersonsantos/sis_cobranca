<?php

class Banco extends TRecord
{
    const TABLENAME  = 'banco';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    use UtilImportDataTrait;
    
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
       
    }

    
    /**
     * Method getAgencias
     */
    public function getAgencias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('banco_id', '=', $this->id));
        return Agencia::getObjects( $criteria );
    }
}

