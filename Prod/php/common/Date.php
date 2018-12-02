<?php
    class Date
    {
        public function __constructor()
        {
        }


        public static function getMonth()
        {
            return date('n');
        }

        public static function getYear()
        {
            return date('Y');
        }

        public static function getYearBeforeMonth($month)
        {
            $current_month = self::getMonth();
            if ($month >= $current_month) {
                return self::getYear() + 1;
            } else {
                return self::getYear();
            }
        }
    }
