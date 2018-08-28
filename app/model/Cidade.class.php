<?php

class Cidade extends TRecord
{
    const TABLENAME  = 'cidade';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    use UtilImportDataTrait;
  
    private static $database = 'bd_cobranca';
    private $estado;
    
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
        parent::addAttribute('estado_id');
    }

    /**
     * Method set_estado
     * Sample of usage: $var->estado = $object;
     * @param $object Instance of Estado
     */
    public function set_estado(Estado $object)
    {
        $this->estado = $object;
        $this->estado_id = $object->id;
    }
    
    /**
     * Method get_estado
     * Sample of usage: $var->estado->attribute;
     * @returns Estado instance
     */
    public function get_estado()
    {
        
        // loads the associated object
        if (empty($this->estado))
            $this->estado = new Estado($this->estado_id);
        
        // returns the associated object
        return $this->estado;
    }
    
    /**
     * Method getAgencias
     */
    public function getAgencias()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('cidade_id', '=', $this->id));
        return Agencia::getObjects( $criteria );
    }
}

