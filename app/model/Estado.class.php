<?php

class Estado extends TRecord
{
    const TABLENAME  = 'estado';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}
    
    use UtilImportDataTrait;
    private static $database = 'bd_cobranca';
    
    private $pais;
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('chave_origem');
        parent::addAttribute('descricao');
        parent::addAttribute('sigla');
        parent::addAttribute('chave_origem_pais');
        parent::addAttribute('data_hora_criacao');
        parent::addAttribute('ultima_atualizacao');
        parent::addAttribute('qt_atualizacoes');
        parent::addAttribute('pais_id');
    }

    /**
     * Method set_pais
     * Sample of usage: $var->pais = $object;
     * @param $object Instance of Pais
     */
    public function set_pais(Pais $object)
    {
        $this->pais = $object;
        $this->pais_id = $object->id;
    }
    
    /**
     * Method get_pais
     * Sample of usage: $var->pais->attribute;
     * @returns Pais instance
     */
    public function get_pais()
    {
        
        // loads the associated object
        if (empty($this->pais))
            $this->pais = new Pais($this->pais_id);
        
        // returns the associated object
        return $this->pais;
    }
    
    /**
     * Method getCidades
     */
    public function getCidades()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('estado_id', '=', $this->id));
        return Cidade::getObjects( $criteria );
    }
}

