<?php

class DayClock
{

    /** @var string */
    protected $format = '{time}.';

    /** @var array */
    protected $days = [
        1 => 'Monday',
        2 => 'Tuesday',
        3 => 'Wednesday',
        4 => 'Thursday',
        5 => 'Friday',
        6 => 'Saturday',
        7 => 'Sunday',
    ];

    /** @var array */
    protected $events = [
        '00:00' => '{d} {h}:{m}'
    ];


    /**
     * Set global format
     * @param null $format
     */
    public function __construct($format = null)
    {
        if($format) {
            $this->format = $format;
        }
    }


    /**
     * Set days name
     * @param array $set
     */
    public function days(array $set)
    {
        $this->days = $set;
    }


    /**
     * Add event
     * @param array $set
     */
    public function at(array $set)
    {
        $this->events = $set;
    }


    /**
     * Get custom time
     * @param string $at
     * @return string
     */
    public function time($at = null)
    {
        // set base
        $at = $at ? strtotime($at) : time();

        // init time
        $time = date('H:i', $at);
        $hours = date('H', $at);
        $minutes = date('i', $at);

        // init day
        $today = date('N', $at);
        $tomorrow = $today + 1;
        if($tomorrow > 7) {
            $tomorrow = 1;
        }

        $today = $this->days[$today];
        $tomorrow = $this->days[$tomorrow];

        // find the right event
        $display = null;
        foreach($this->events as $event => $text) {
            if($time < $event) {
                break;
            }
            $display = $text;
        }

        // format text
        $display = str_replace('{h}', $hours, $display);
        $display = str_replace('{m}', $minutes, $display);
        $display = str_replace('{d}', $today, $display);
        $display = str_replace('{d+1}', $tomorrow, $display);

        // format global
        $global = str_replace('{time}', $display, $this->format);

        return $global;
    }

} 