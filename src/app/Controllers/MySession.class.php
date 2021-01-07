<?php

namespace kivweb\Controllers;

/**
 *  Objekt pro praci se Session.
 *  @author Michal Nykl
 */
class MySession{
    
    /**
     *  Pri vytvoreni objektu je zahajena session.
     */
    public function __construct(){
        session_start(); // zahajim
    }

    /**
     *  Funkce pro ulozeni hodnoty do session.
     * @param string $name Jmeno atributu.
     * @param mixed $value Hodnota
     */
    public function addSession(string $name, $value){
        $_SESSION[$name] = $value;
    }

    /**
     *  Vrati hodnotu dane session nebo null, pokud session neni nastavena.
     * @param string $name Jmeno atributu.
     * @return mixed
     */
    public function readSession(string $name){
        // existuje dany atribut v session
        if($this->isSessionSet($name)){
            return $_SESSION[$name];
        } else {
            return null;
        }
    }

    /**
     *  Je session nastavena?
     * @param string $name Jmeno atributu.
     * @return boolean
     */
    public function isSessionSet(string $name): bool {
        return isset($_SESSION[$name]);
    }

    /**
     *  Odstrani danou session.
     * @param string $name Jmeno atributu.
     */
    public function removeSession(string $name){
        unset($_SESSION[$name]);
    }
}
