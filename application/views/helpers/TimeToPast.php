<?php

class Zend_View_Helper_TimeToPast extends Zend_View_Helper_Abstract
{
    /**
     * Convert unixtime to past period
     * I stole it from http://php.net/manual/en/function.time.php
     *
     * @param  int $time
     * @return string
     */
    public function timeToPast($time)
    {
        $difference = time() - $time;

        // I think this site will not survive more than 50 years
        $periods = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year');
        $lengths = array('60', '60', '24', '7', '4.35', '12', '50');
		$postfix = 'ago';

        for ($j = 0; $difference >= $lengths[$j] && $j < 7; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);
        if ($difference != 1) {
            $periods[$j] .= 's';
            
        }

        return $difference . ' ' . $periods[$j] . ' ' . $postfix;
    }
}