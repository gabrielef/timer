<?php

namespace gabrielef;

class Timer
{
    private $timers = [];

    private function newTimer(int $precision = 0)
    {
        $timer = new \stdClass();
        $timer->start = new \DateTime();
        $timer->precision = $precision;
        return $timer;
    }

    /**
     * Round number to specific precision 
     *
     * @param int|float $time
     * @param integer $precision
     * @return float
     */
    private function roundWithPrecision($time, int $precision){
        return round($time, $precision);
    }

    /**
     * Start a new timer with name and precision and retrieve used DateTime 
     *
     * @param string $key
     * @param integer $precision
     * @return DateTime
     */
    public function start(string $key, int $precision = 0)
    {
        $this->timers[$key] = $this->newTimer($precision);
        return $this->timers[$key]->start;
    }

    /**
     * Retrieve the amount of time passed of a specific timer
     *
     * @param string $key
     * @return float
     */
    public function look(string $key)
    {
        $diff = (new \DateTime())->diff($this->timers[$key]->start);
        return $this->roundWithPrecision($diff->s + $diff->f, $this->timers[$key]->precision);
    }

    // //TODO
    // public function lap($key)
    // {
    // }

    // //TODO
    // public function pause($key)
    // {
    // }
    
    /**
     * Stop the timer (this will also delete the timer)
     *
     * @param string $key
     * @return float
     */
    public function end(string $key)
    {
        $diff = (new \DateTime())->diff($this->timers[$key]->start);
        $precision = $this->timers[$key]->precision;
        $this->clear($key);
        return $this->roundWithPrecision($diff->s + $diff->f, $precision);
    }

    /**
     * List all the available timer key
     *
     * @return array
     */
    function list() {
        return array_keys($this->timers);
    }

    /**
     * Check if $key is already used
     *
     * @param string $key
     * @return boolean
     */
    public function has(string $key)
    {
        if (array_search($key, $this->list()) !== false) {
            return true;
        }
        return false;
    }

    //TODO clear all timer
    /**
     * Clear a timer
     *
     * @param string $key
     * @return void
     */
    public function clear(string $key)
    {
        unset($this->timers[$key]);
    }
}
