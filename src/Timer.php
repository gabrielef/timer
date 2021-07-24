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

    public function start($key, int $precision = 0)
    {
        $this->timers[$key] = $this->newTimer($precision);
        return $this->timers[$key]->start;
    }

    public function look($key)
    {
        $diff = (new \DateTime())->diff($this->timers[$key]->start);
        return round($diff->s + $diff->f, $this->timers[$key]->precision);
    }

    // //TODO
    // public function lap($key)
    // {
    // }

    // //TODO
    // public function pause($key)
    // {
    // }

    public function end($key)
    {
        $diff = (new \DateTime())->diff($this->timers[$key]->start);
        $precision = $this->timers[$key]->precision;
        $this->clear($key);
        return round($diff->s + $diff->f, $precision);
    }

    function list() {
        return array_keys($this->timers);
    }

    public function has($key)
    {
        if (array_search($key, $this->list()) !== false) {
            return true;
        }
        return false;
    }

    public function clear($key)
    {
        unset($this->timers[$key]);
    }
}
