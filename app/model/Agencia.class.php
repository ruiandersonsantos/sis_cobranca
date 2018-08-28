<?php

class Agencia extends TRecord
{
    const TABLENAME  = 'agencia';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    use UtilImportDataTrait;
    private static $database = 'bd_cobranca';
    private $cidade;
    private $banco;
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('chave_origem');
        parent::addAttribute('codigo');
        parent::addAttribute('nome_agencia');
        parent::addAttribute('chave_primaria_banco');
        parent::addAttribute('chave_primaria_cidade');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
        parent::addAttribute('banco_id');
        parent::addAttribute('cidade_id');
    }

    /**
     * Method set_cidade
     * Sample of usage: $var->cidade = $object;
     * @param $object Instance of Cidade
     */
    public function set_cidade(Cidade $object)
    {
        $this->cidade = $object;
        $this->cidade_id = $object->id;
    }
    
    /**
     * Method get_cidade
     * Sample of usage: $var->cidade->attribute;
     * @returns Cidade instance
     */
    public function get_cidade()
    {
        
        // loads the associated object
        if (empty($this->cidade))
            $this->cidade = new Cidade($this->cidade_id);
        
        // returns the associated object
        return $this->cidade;
    }
    /**
     * Method set_banco
     * Sample of usage: $var->banco = $object;
     * @param $object Instance of Banco
     */
    public function set_banco(Banco $object)
    {
        $this->banco = $object;
        $this->banco_id = $object->id;
    }
    
    /**
     * Method get_banco
     * Sample of usage: $var->banco->attribute;
     * @returns Banco instance
     */
    public function get_banco()
    {
        
        // loads the associated object
        if (empty($this->banco))
            $this->banco = new Banco($this->banco_id);
        
        // returns the associated object
        return $this->banco;
    }
    
    /**
     * Method getContas
     */
    public function getContas()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('agencia_id', '=', $this->id));
        return Conta::getObjects( $criteria );
    }
}

