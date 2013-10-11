<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Round_time
 *
 * Returns round time
 *
 * @access	public
 * @param	string  time in format [hrs delimiter mins]
 * @param	string  delimiter, usually '.'
 * @return	string	rounded time
 */
if ( ! function_exists('round_time'))
{
    function round_time($str, $delimiter = '.')
    {
        $time = explode($delimiter, $str);
        if (count($time === 2))
        {
            $mins = (int)round($time[1]/5)*5;
            $hrs = (int)floor(($time[0]*60 + $mins)/60);
            return ($hrs === 24 ? '0' :  $hrs) . $delimiter . ($mins === 60 ? '00' : str_pad($mins, 2, "0", STR_PAD_LEFT));
        }
        else
        {
            return $str;
        }
    }
}

// --------------------------------------------------------------------

/**
 * Month
 *
 * Returns month as a string
 *
 * @access	public
 * @param	string  number (then cast to int)
 * @return	string	russian month as a string
 */

if ( ! function_exists('month'))
{
    function month($number)
    {
        $month = $number;
        if ($number >= 1 and $number <= 12)
        {
            switch ((int)$number){
                case 1: $month = lang('jan');
                    break;
                case 2: $month = lang('feb');
                    break;
                case 3: $month = lang('mar');
                    break;
                case 4: $month = lang('apr');
                    break;
                case 5: $month = lang('may');
                    break;
                case 6: $month = lang('jun');
                    break;
                case 7: $month = lang('jul');
                    break;
                case 8: $month = lang('aug');
                    break;
                case 9: $month = lang('sep');
                    break;
                case 10: $month = lang('oct');
                    break;
                case 11: $month = lang('nov');
                    break;
                case 12: $month = lang('dec');
                default:
                    break;
            }
        }
        return $month;
    }
}

// --------------------------------------------------------------------