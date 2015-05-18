<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
/* Heredamos de la clase CI_Controller */
class registro extends CI_Controller {
 
  function __construct()
  {
 
    parent::__construct();
 
    /* Cargamos la base de datos */
    $this->load->database();
 
    /* Cargamos la libreria*/

    $this->load->library(array('session', 'lib_login'));
    $this->load->library('grocery_crud');
 
    /* Añadimos el helper al controlador */
    $this->load->helper('url');
  }

  function index()
  {
    /*
     * Mandamos todo lo que llegue a la funcion
     * administracion().
     **/
    redirect('registro/administracion');
  }

  function addFacebook () {

    $fb_data = $this->lib_login->facebook();

    if (isset($fb_data['me'])) {

      $me = $fb_data['me'];
      
      $this->load->model('UserModel');
      $this->UserModel->insert(array(
        'id' => $me['id'],
        'name' => $me['name'],
        'first_name' => $me['first_name'],
        'last_name' => $me['last_name'],
        'gender' => $me['gender']
      ));
    } else {
      echo "Else file registro";
   echo '<a href="' . $fb_data['loginUrl'] . '">Login</a>';
    }

    
  }

  function administracion()

  {
    try{
 
    /* Creamos el objeto */
    $crud = new grocery_CRUD();
 
    /* Seleccionamos el tema */
    $crud->set_theme('flexigrid');
 
    /* Seleccionmos el nombre de la tabla de nuestra base de datos*/
    $crud->set_table('dataUs');
 
    /* Le asignamos un nombre */
    $crud->set_subject('Us');
 
    /* Asignamos el idioma español */
    $crud->set_language('spanish');
 
    /* Aqui le decimos a grocery que estos campos son obligatorios */
    $crud->required_fields(
     
      'id',
      'name',
      'first_name',
      'last_name',
      'gender'
    );

    /* Aqui le indicamos que campos deseamos mostrar */
    $crud->columns(
      'id',
      'name',
      'first_name',
      'last_name',
      'gender'
    );
     /* Generamos la tabla */
    $output = $crud->render();
 
    /* La cargamos en la vista situada en
    /applications/views/productos/administracion.php */
    $this->load->view('registro/administracion', $output);
    }catch(Exception $e){
      /* Si algo sale mal cachamos el error y lo mostramos */
      show_error($e->getMessage().' --- '.$e->getTraceAsString());
    }
  }
}


