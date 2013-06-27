<?php
/**
 * Tab Example - Controller Admin Example
 *
 * @category   	Module / checkout
 * @author     	PrestaEdit <j.danse@prestaedit.com>
 * @copyright  	2012 PrestaEdit
 * @version   	1.0	
 * @link       	http://www.prestaedit.com/
 * @since      	File available since Release 1.0
*/

class AdminAnswerAndWinController extends ModuleAdminController
{
	public function __construct()
	{
		$this->table = 'answerandwin';
		$this->className = 'Question';
		$this->lang = false;
		$this->deleted = false;
		$this->colorOnBackground = false;
		$this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected'), 'confirm' => $this->l('Delete selected items?')));
		$this->context = Context::getContext();
		
		parent::__construct();
	}
	
	/**
	 * Function used to render the list to display for this controller
	 */
	public function renderList()
	{
		$this->addRowAction('edit');
		$this->addRowAction('delete');
		$this->addRowAction('details');
		
		$this->bulk_actions = array(
			'delete' => array(
				'text' => $this->l('Delete selected'),
				'confirm' => $this->l('Delete selected items?')
				)
			);
		
		$this->fields_list = array(
			'id_answerandwin' => array(
				'title' => $this->l('ID'),
				'align' => 'center',
				'width' => 25
			),
			'question' => array(
				'title' => $this->l('Question'),
				'width' => 'auto',
			),
		  	'response' => array(
				'title' => $this->l('Réponse'),
				'width' => 'auto',
			),
		);
		
		$lists = parent::renderList();
		
		parent::initToolbar();
		
		return $lists;
	}
		
	/**
	 * method call when ajax request is made with the details row action
	 * @see AdminController::postProcess()
	 */
	public function ajaxProcessDetails()
	{
		if (($id = Tools::getValue('id')))
		{
			// override attributes
			$this->display = 'list';
			$this->lang = false;

			$this->addRowAction('edit');
			$this->addRowAction('delete');

// 			$this->_select = 'b.*';
// 		//	$this->_join = 'LEFT JOIN `'._DB_PREFIX_.'tab_lang` b ON (b.`id_tab` = a.`id_tab` AND b.`id_lang` = '.$this->context->language->id.')';
// 			$this->_where = 'AND a.`id_parent` = '.(int)$id;
// 			$this->_orderBy = 'position';

			// get list and force no limit clause in the request
			$this->getList($this->context->language->id);

			// Render list
			$helper = new HelperList();
			$helper->actions = $this->actions;
			$helper->list_skip_actions = $this->list_skip_actions;
			$helper->no_link = true;
			$helper->shopLinkType = '';
			$helper->identifier = $this->identifier;
			$helper->imageType = $this->imageType;
			$helper->toolbar_scroll = false;
			$helper->show_toolbar = false;
			$helper->orderBy = 'position';
			$helper->orderWay = 'ASC';
			$helper->currentIndex = self::$currentIndex;
			$helper->token = $this->token;
			$helper->table = $this->table;
			$helper->position_identifier = $this->position_identifier;
			// Force render - no filter, form, js, sorting ...
			$helper->simple_header = true;
			$content = $helper->generateList($this->_list, $this->fields_list);

			echo Tools::jsonEncode(array('use_parent_structure' => false, 'data' => $content));
		}

		die;
	}	
		
	public function renderForm()
	{
		$this->fields_form = array(
			'tinymce' => true,
			'legend' => array(
				'title' => $this->l('Créer votre question/réponse et configurer le cadeau : '),
				'image' => '../img/admin/cog.gif'
			),
			'input' => array(
				array(
					'type' => 'text',
					'label' => $this->l('Question :'),
					'name' => 'question',
					'size' => 40,
				    'required' => true
				),
				array(
					'type' => 'text',
					'label' => $this->l('Réponse :'),
					'name' => 'response',
					'size' => 40,
				    'required' => true
				),
		    array(
  		    'type' => 'text',
  		    'label' => $this->l('Montant :'),
  		    'name' => 'amount',
  		    'size' => 40,
		      'required' => true
		    )
// 			  ,
// 				array(
// 					'type' => 'date',
// 					'name' => 'exampledate',
// 				)
			),
			'submit' => array(
				'title' => $this->l('Save'),
				'class' => 'button'
			)
		);

		if (!($obj = $this->loadObject(true)))
			return;
			
	//	$this->fields_value = array('lorem' => "ipsum");

		return parent::renderForm();
	}
	
	public function postProcess()
	{
// 	  if (Tools::isSubmit('submitAdd'.$this->table))
// 	  {
	    
// // 	    if(!Tools::getIsset('amount') || Tools::isEmpty(Tools::getValue('amount'))){
// // 	      $this->errors[] = Tools::displayError('Veuillez renseigner un montant');
// // 	    }
	    
// 	   // Create Object ExampleData
// 	   $obj = new Question();
// 	   // Copy From Post
// 	   $this->copyFromPost($obj, 'answerandwin');
// 	   // Save object
// 	   if(empty($this->errors)){
//   	   if (!$obj->save())
//   	    $this->errors[] = Tools::displayError('An error has occurred: Can\'t save the current object');
//   	   else
//   	      Tools::redirectAdmin(self::$currentIndex.'&conf=4&token='.$this->token);
// 	   }
	 
// 	  }
	  if (Tools::isSubmit('submitAdd'.$this->table))
 	  {
	    if(!Tools::getIsset('amount') || Tools::isEmpty(Tools::getValue('amount')) ){
	      $this->errors[] = Tools::displayError('Veuillez renseigner un montant');
	    }
	    elseif(!Validate::isFloat(Tools::getValue('amount'))){
	      $this->errors[] = Tools::displayError('Le montant doit être un numérique');
	    }
	  //  if(empty($this->errors)){	  
        return parent::postProcess();
	    //}
 	  }
	}
	/*
	public function postProcess()
	{
		if (Tools::isSubmit('submitAdd'.$this->table))
		{
			// Create Object ExampleData
			$exemple_data = new ExampleData();

			$exemple_data->exampledate = array();
			$languages = Language::getLanguages(false);
				foreach ($languages as $language)
					$exemple_data->name[$language['id_lang']] = Tools::getValue('name_'.$language['id_lang']);

			// Save object
			if (!$exemple_data->save())
				$this->errors[] = Tools::displayError('An error has occurred: Can\'t save the current object');
			else
				Tools::redirectAdmin(self::$currentIndex.'&conf=4&token='.$this->token);
		}	
	}
	*/
}