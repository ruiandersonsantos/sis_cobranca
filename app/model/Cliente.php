<?php

class Cliente extends TRecord
{
    use UtilImportDataTrait;
    private static $database = 'bd_cobranca';
    const TABLENAME  = 'cliente';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('chave_origem');
        parent::addAttribute('codigo');
        parent::addAttribute('razao');
        parent::addAttribute('nome_fantasia');
        parent::addAttribute('documento');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
    }

    
    /**
     * Method getContatos
     */
    public function getContatos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return Contato::getObjects( $criteria );
    }
    /**
     * Method getEnderecos
     */
    public function getEnderecos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cliente_id', '=', $this->id));
        return Endereco::getObjects( $criteria );
    }
}

