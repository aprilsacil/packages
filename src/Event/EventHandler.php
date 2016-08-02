<?php //-->
/**
 * This file is part of the Cradle PHP Library.
 * (c) 2016-2018 Openovate Labs
 *
 * Copyright and license information can be found at LICENSE.txt
 * distributed with this package.
 */

namespace Cradle\Event;

use Cradle\Helper\InstanceTrait;
use Cradle\Resolver\ResolverTrait;

/**
 * Allows the ability to listen to events made known by another
 * piece of functionality. Events are items that transpire based
 * on an action. With events you can add extra functionality
 * right after the event has triggered.
 *
 * @package  Cradle
 * @category Event
 * @author   Christian Blanquera <cblanquera@openovate.com>
 * @standard PSR-2
 */
class EventHandler implements EventInterface
{
    use ResolverTrait, InstanceTrait;

     /**
     * @var array $observers cache of event handlers
     */
    protected $observers = [];

     /**
     * @var array $regexp listeners with regexp
     */
    protected $regex = [];

     /**
     * @var array $sprintf listeners with sprintf
     */
    protected $sprintf = [];

     /**
     * @var array|bool $meta The meta data for the current event
     */
    protected $meta = true;
    
    /**
     * Returns the current matched handler
     *
     * @return array
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * Returns possible event matches
     *
     * @param *string $event
     *
     * @return array
     */
    public function match($event)
    {
        $matches = [];

        //do the obvious match
        if (isset($this->observers[$event])) {
            $matches[] = array(
                'event' => $event,
                'pattern' => $event,
                'variables' => array()
            );
        }
        
        //deal with sprintf
        foreach ($this->sprintf as $pattern) {
            $variables = sscanf($event, $pattern);
            
            //if it matches
            if (is_array($variables) && strlen(implode('', $variables))) {
                $matches[] = array(
                    'event' => $event,
                    'pattern' => $pattern,
                    'variables' => $variables
                );
            }
        }

        //deal with regexp
        foreach ($this->regex as $pattern) {
            //if it matches
            if (preg_match_all($pattern, $event, $match)) {
                $variables = array();

                if (is_array($match) && !empty($match)) {
                    //flatten
                    $variables = call_user_func_array('array_merge', $match);
                    array_shift($variables);
                }

                $matches[] = array(
                    'event' => $event,
                    'pattern' => $pattern,
                    'variables' => $variables
                );
            }
        }

        return $matches;
    }
    
    /**
     * Stops listening to an event
     *
     * @param string|null   $event    name of the event
     * @param callable|null $callback callback handler
     *
     * @return EventHandler
     */
    public function off($event = null, $callback = null)
    {
        //if it's not callable
        if (!is_callable($callback)) {
            //set it to null
            $callback = null;
        }

        //if there is no event and not callable
        if (is_null($event) && is_null($callback)) {
            //it means that they want to remove everything
            $this->observers = [];
            return $this;
        }
        
        //if there are callbacks listening to
        //this and no callback was specified
        if (isset($this->observers[$event]) && is_null($callback)) {
            //it means that they want to remove
            //all callbacks listening to this event
            unset($this->observers[$event]);
            return $this;
        }
        
        //if there are callbacks listening
        //to this and we have a callback
        if (isset($this->observers[$event]) && is_callable($callback)) {
            return $this->removeObserversByEvent($event, $callback);
        }
        
        //if no event, but there is a callback
        if (is_null($event) && is_callable($callback)) {
            return $this->removeObserversByCallback($callback);
        }

        return $this;
    }
     
    /**
     * Attaches an instance to be notified
     * when an event has been triggered
     *
     * @param *string|array $event    The name of the event
     * @param *callable     $callback The event handler
     * @param int           $priority Set the importance
     *
     * @return EventHandler
     */
    public function on($event, $callback, $priority = 0)
    {
        //deal with multiple events
        if (is_array($event)) {
            foreach ($event as $item) {
                $this->on($item, $callback, $priority);
            }
            
            return $this;
        }

        //set up the observer
        $observer = $this->resolve(EventObserver::class, $callback);

        $this->observers[$event][$priority][] = $observer;

        //is there a sprintf ?
        if (preg_match('#%[sducoxXbgGeEfF]#', $event)) {
            $this->sprintf[] = $event;
        //is there a regexp ?
        } else if (strpos($event, '#') === 0 && strrpos($event, '#') !== 0) {
            $this->regex[] = $event;
        }

        return $this;
    }

    /**
     * Notify all observers of that a specific
     * event has happened
     *
     * @param *string $event The event to trigger
     * @param mixed   ...$args The arguments to pass to the handler
     *
     * @return EventHandler
     */
    public function trigger($event, ...$args)
    {
        $matches = $this->match($event);

        foreach ($matches as $match) {
            //add on to match
            $match['args'] = $args;
            $event = $match['pattern'];

            //if no direct observers
            if (!isset($this->observers[$event])) {
                continue;
            }

            //sort it out
            krsort($this->observers[$event]);
            $observers = call_user_func_array('array_merge', $this->observers[$event]);

            //for each observer
            foreach ($observers as $observer) {
                //get the callback
                $callback = $observer->getCallback();
                //add on to match
                $match['callback'] = $callback;
                //set the current
                $this->meta = $match;

                //if this is the same event, call the method, if the method returns false
                if (call_user_func_array($callback, $args) === false) {
                    $this->meta = false;
                    return $this;
                }
            }
        }
        
        $this->meta = true;
        
        return $this;
    }
    
    /**
     * Removes all observers matching this callback
     *
     * @param *callable $callback
     *
     * @return EventHandler
     */
    protected function removeObserversByCallback($callback)
    {
        //find the callback
        foreach ($this->observers as $event => $priorities) {
            $this->removeObserversByEvent($event, $callback);
        }
        
        return $this;
    }
    
    /**
     * Removes all observers matching this event and callback
     *
     * @param *string   $event
     * @param *callable $callback
     *
     * @return EventHandler
     */
    protected function removeObserversByEvent($event, $callback)
    {
        //if event isn't set
        if (!isset($this->observers[$event])) {
            //do nothing
            return $this;
        }

        //'foobar' => array(
        foreach ($this->observers[$event] as $priority => $observers) {
            //0 => array(
            foreach ($observers as $i => $observer) {
                //0 => callback
                if ($observer->assertEquals($callback)) {
                    unset($this->observers[$event][$priority][$i]);
                }
            }
        }
        
        return $this;
    }
}
