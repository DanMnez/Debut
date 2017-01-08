<?php

namespace core;

class Paginator 
{

    /**
     * Las propiedades de la paginación
     * 
     * @var array   
     */
    private $_properties = array();
    
    /**
     * Configuración por defecto
     * 
     * @var array  
     */
    public $_defaults = array(
      'page' => 1,
      'perPage' => 10 
    );
    
    /**
     * Constructor
     * 
     * @param array $array   Array que será paginado
     * @param int   $perPage La cantidad de elementos que se deben mostrar por página
     * @return void
     */
    public function __construct($array, $perPage = null)
    {
      $this->array   = $array;
      $this->curPage = (!isset($_GET['page']) ? $this->_defaults['page'] : $_GET['page']);
      $this->perPage = ($perPage == null) ? $this->_defaults['perPage'] : $perPage;
    }
    
    /**
     * Global setter
     * 
     * Utiliza el array de propiedades
     * 
     * @param string $name  El nombre de la propiedad
     * @param string $value El valor de la propiedad
     * @return void
     */
    public function __set($name, $value) 
    { 
      $this->_properties[$name] = $value;
    }
    
    /**
     * Global getter
     * 
     * Obtiene la propiedad del array de propiedades
     * si existe
     * 
     * @param string $name El nombre de la propiedad
     * @return mixed El valor de la propiedad o false
     */
    public function __get($name)
    {
      if (array_key_exists($name, $this->_properties)) {
        return $this->_properties[$name];
      }
      return false;
    }

    /**
     * Obtiene los resultados de la paginación
     * 
     * @return array Elementos de la pagina
     */
    public function getResults()
    {
      // Asigna la página usando el método GET, sino hay página asume que es la expecificada por defecto (1)
      $this->page = (empty($this->curPage) !== false) ? $this->curPage : $this->page = $this->_defaults['page'];
      
      // El tamaño del array
      $this->length = count($this->array);
      
      // Número de páginas
      $this->pages = ceil($this->length / $this->perPage);
      
      // Calcula el punto de partida
      $this->start = ceil(($this->page - 1) * $this->perPage);
      
      // retorna la porción del resultado
      return array_slice($this->array, $this->start, $this->perPage);
    }
    
    /**
     * Obtiene los enlaces html para el desplazamiento por páginas
     * 
     * @return mixed  El HTML de la paginación o false
     */
    public function getLinks()
    {
      // Inicializa el conjunto de enlaces
      $links  = array();
      
      // Solo seguimos si tenemos más de una página
      if (($this->pages) > 1) {
          
        // Si no está en la primera página, asigna el enlace "Anterior"
        if ($this->page != 1) {
            $links[] = '<li><a href="?page='.($this->page - 1).'">&laquo; Anterior</a></li>';
        }
        
        // Asigna todos los números al array
        for ($i = 1; $i < ($this->pages + 1); $i++) {
          if ($this->page == $i) {
            $links[] = '<li class="active"><a>'.$i.'</a></li>'; // Añade estilos a la página activa
          } else {
            $links[] = ' <li><a href="?page='.$i.'">'.$i.'</a></li>';
          }
        }
        
        // Si no está en la última página, asigna el enlace "Siguiente"
        if ($this->page < $this->pages) {
            $links[] = '<li><a href="?page='.($this->page + 1).'"> Siguiente &raquo; </a></li>';
        }
        
        // Devuelve el array de links como un string
        return implode($links);
      }
      
      return false;
    }
}