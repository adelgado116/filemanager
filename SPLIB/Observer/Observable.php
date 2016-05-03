<?php
/**
* @package SPLIB
* @version $Id: Observable.php,v 1.1 2003/12/12 08:06:05 kevin Exp $
*/
/**
* Base Observerable class
* @abstract
* @package SPLIB
*/
class Observable {
    /**
    * Array of Observers
    * @access private
    * @var array
    */
    var $observers;

    /**
    * Constructs the Observerable object
    */
    function Observable () {
        $this->observers=array();
    }

    /**
    * Calls the update() function using the reference to each
    * registered observer, passing an optional argument for the
    * event - used by children of Observable
    * @param mixed (optional) describing the event
    * @return void
    * @access public
    */
    function notifyObservers ($arg = NULL) {
        $keys = array_keys($this->observers);
        foreach ($keys as $key) {
          $this->observers[$key]->update($this,$arg);
        }
    }

    /**
    * Attaches an observer to the observable
    * @param Observer object built from subclass of Observer
    * @return void
    * @access public
    */
    function addObserver (& $observer) {
        $this->observers[]=& $observer;
    }
}
?>