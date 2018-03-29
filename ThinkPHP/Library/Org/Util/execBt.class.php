<?php

namespace Org\Util;

/**
 * Class xBEncoder
 * Author: Angus.Fenying
 * Version: 0.1
 * Date:  2014-06-03
 *
 *  This class helps stringify or parse BENC
 *  codes.
 *
 * All Copyrights 2007 - 2014 Fenying Studio Reserved.
 */
class ExecBt
{
    const READY = 0;
    const READ_STR = 1;
    const READ_DICT = 2;
    const READ_LIST = 3;
    const READ_INT = 4;
    const READ_KEY = 5;
    public $y;
    protected $z, $m, $n;
    protected $stat;
    protected $stack;
    /**
     * This method saves the status of current
     * encode/decode work.
     */
    protected function push($newY, $newStat)
    {
        array_push($this->stack, array($this->y, $this->z, $this->m, $this->n, $this->stat));
        list($this->y, $this->z, $this->m, $this->n, $this->stat) = array($newY, 0, 0, 0, $newStat);
    }
    /**
     * This method restore the saved status of current
     * encode/decode work.
     */
    protected function pop()
    {
        $t = array_pop($this->stack);
        if ($t) {
            if ($t[4] == self::READ_DICT) {
                $t[0]->{$t[1]} = $this->y;
                $t[1] = 0;
            } elseif ($t[4] == self::READ_LIST)
                $t[0][] = $this->y;
            list($this->y, $this->z, $this->m, $this->n, $this->stat) = $t;
        }
    }
    /**
     * This method initializes the status of work.
     * YOU SHOULD CALL THIS METHOD BEFORE EVERYTHING.
     */
    public function init()
    {
        $this->stat = self::READY;
        $this->stack = array();
        $this->z = $this->m = $this->n = 0;
    }
    /**
     * This method decode $s($l as length).
     * You can get $obj->y as the result.
     */
    public function decode($s, $l)
    {
        $this->y = 0;
        for ($i = 0; $i < $l; ++$i) {
            $this->stat=0;
            switch ($this->stat) {
                case self::READY:
                    if ($s[$i] == 'd') {

                        $this->y = new xBDict();
                        $this->stat = self::READ_DICT;
                    } elseif ($s[$i] == 'l') {
                        $this->y = array();
                        $this->stat = self::READ_LIST;
                    }
                    break;
                case self::READ_INT:
                    if ($s[$i] == 'e') {
                        $this->y->val = substr($s, $this->m, $i - $this->m);
                        $this->pop();
                    }
                    break;
                case self::READ_STR:
                    if (xBInt::isNum($s[$i]))
                        continue;
                    if ($s[$i] = ':') {
                        $this->z = substr($s, $this->m, $i - $this->m);
                        $this->y = substr($s, $i + 1, $this->z + 0);
                        $i += $this->z;
                        $this->pop();
                    }
                    break;
                case self::READ_KEY:
                    if (xBInt::isNum($s[$i]))
                        continue;
                    if ($s[$i] = ':') {
                        $this->n = substr($s, $this->m, $i - $this->m);
                        $this->z = substr($s, $i + 1, $this->n + 0);
                        $i += $this->n;
                        $this->stat = self::READ_DICT;
                    }
                    break;
                case self::READ_DICT:
                    if ($s[$i] == 'e') {
                        $this->pop();
                        break;
                    } elseif (!$this->z) {
                        $this->m = $i;
                        $this->stat = self::READ_KEY;
                        break;
                    }
                case self::READ_LIST:
                    switch ($s[$i]) {
                        case 'e':
                            $this->pop();
                            break;
                        case 'd':
                            $this->push(new xBDict(), self::READ_DICT);
                            break;
                        case 'i':
                            $this->push(new xBInt(), self::READ_INT);
                            $this->m = $i + 1;
                            break;
                        case 'l':
                            $this->push(array(), self::READ_LIST);
                            break;
                        default:
                            if (xBInt::isNum($s[$i])) {
                                $this->push('', self::READ_STR);
                                $this->m = $i;
                            }
                    }
                    break;
            }
        }
        $rtn = empty($this->stack);
        $this->init();
        return $rtn;
    }
    /**
     * This method encode $obj->y into BEncode.
     */
    public function encode()
    {
        return $this->_encDo($this->y);
    }
    protected function _encStr($str)
    {
        return strlen($str) . ':' . $str;
    }
    protected function _encDo($o)
    {
        if (is_string($o))
            return $this->_encStr($o);
        if ($o instanceof xBInt)
            return 'i' . $o->val . 'e';
        if ($o instanceof xBDict) {
            $r = 'd';
            foreach ($o as $k => $c)
                $r .= $this->_encStr($k) . $this->_encDo($c);
            return $r . 'e';
        }
        if (is_array($o)) {
            $r = 'l';
            foreach ($o as $c)
                $r .= $this->_encDo($c);
            return $r . 'e';
        }
    }
}
class xBDict
{
}
class xBInt
{
    public $val;
    public function __construct($val = 0)
    {
        $this->val = $val;
    }
    public static function isNum($chr)
    {
        $chr = ord($chr);
        if ($chr <= 57 && $chr >= 48)
            return true;
        return false;
    }
}