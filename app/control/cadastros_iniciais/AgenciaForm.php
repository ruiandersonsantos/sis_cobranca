<?php

class AgenciaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'bd_cobranca';
    private static $activeRecord = 'Agencia';
    private static $primaryKey = 'id';
    private static $formName = 'form_Agencia';

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle('Cadastro de agência');


        $id = new TEntry('id');
        $codigo = new TEntry('codigo');
        $nome_agencia = new TEntry('nome_agencia');
        $banco_id = new TDBUniqueSearch('banco_id', 'bd_cobranca', 'Banco', 'id', 'nome_banco','id asc'  );
        $cidade_id = new TDBUniqueSearch('cidade_id', 'bd_cobranca', 'Cidade', 'id', 'descricao','id asc'  );

        $banco_id->addValidation('Banco id', new TRequiredValidator()); 
        $cidade_id->addValidation('Cidade id', new TRequiredValidator()); 

        $id->setEditable(false);
        $banco_id->setMinLength(2);
        $cidade_id->setMinLength(2);

        $banco_id->setMask('{nome_banco}');
        $cidade_id->setMask('{descricao}');

        $id->setSize(100);
        $codigo->setSize('10%');
        $banco_id->setSize('40%');
        $cidade_id->setSize('40%');
        $nome_agencia->setSize('40%');



        $row1 = $this->form->addFields([new TLabel('Id:', null, '14px', null)],[$id]);
        $row2 = $this->form->addFields([new TLabel('Codigo:', null, '14px', null)],[$codigo]);
        $row3 = $this->form->addFields([new TLabel('Nome agência:', null, '14px', null)],[$nome_agencia]);
        $row4 = $this->form->addFields([new TLabel('Banco :', null, '14px', null)],[$banco_id]);
        $row5 = $this->form->addFields([new TLabel('Cidade :', null, '14px', null)],[$cidade_id]);

        // create the form actions
        $btn_onsave = $this->form->addAction('Salvar', new TAction([$this, 'onSave']), 'fa:floppy-o #ffffff');
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction('Limpar formulário', new TAction([$this, 'onClear']), 'fa:eraser #dd5a43');

        // vertical box container
        $container = new TVBox;
        $container->style = 'width: 100%';
        $container->class = 'form-container';
        // $container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);

        parent::add($container);

    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            /**
            // Enable Debug logger for SQL operations inside the transaction
            TTransaction::setLogger(new TLoggerSTD); // standard output
            TTransaction::setLogger(new TLoggerTXT('log.txt')); // file
            **/

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Agencia(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            /**
            // To define an action to be executed on the message close event:
            $messageAction = new TAction(['className', 'methodName']);
            **/

            new TMessage('info', AdiantiCoreTranslator::translate('Record saved'), $messageAction);

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new Agencia($key); // instantiates the Active Record 

                $this->form->setData($object); // fill the form 

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

    }

    public function onShow($param = null)
    {

    } 

}

