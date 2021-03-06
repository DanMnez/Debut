<?php

namespace core;

use Exception;

class Collection 
{
    /**
     * Los items de la colección
     * 
     * @var array
     */
    private $items = array();

    /**
     * Permite añadir items a la colección
     * 
     * @param object $obj
     * @param int    $key
     * 
     * @throws \Exception
     */
    public function addItem($obj, $key = null) 
    {
        if ($key == null) {
            $this->items[] = $obj;
        } else {
            if (isset($this->items[$key])) {
                throw new Exception('La clave ' . $key . ' ya está en uso.');
            }else {
                $this->items[$key] = $obj;
            }
        }
    }
    
    /**
     * Permite borrar items de la colección
     * 
     * @param int $key
     * 
     * @throws \Exception
     */
    public function deleteItem($key) 
    {
        if (isset($this->items[$key])) {
            unset($this->items[$key]);
        } else {
            throw new Exception('La clave ' . $key . ' es inválida.');
        }
    }

    /**
     * Permite obtener un item expecífico de la colección
     * 
     * @param int $key La clave
     * 
     * @throws \Exception
     * @return object El item
     */
    public function getItem($key) 
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        } else {
            throw new Exception('La clave ' . $key . ' es inválida.');
        }
    }
    
    /**
     * Getter de items
     * 
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }
}
