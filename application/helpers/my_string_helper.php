<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Mb_ucfirst
 *
 * Returns formatted string with first letter uppercase and the rest string lowercase.
 *
 * @access	public
 * @param	string
 * @return	string	formatted string
 */

if ( ! function_exists('mb_ucfirst'))
{
    function mb_ucfirst($string, $encoding = 'utf-8')
    {
        $strlen = mb_strlen($string, $encoding);
        $firstChar = mb_substr($string, 0, 1, $encoding);
        $then = mb_substr($string, 1, $strlen - 1, $encoding);
        return mb_strtoupper($firstChar, $encoding) . mb_strtolower($then, $encoding);
    }
}

// --------------------------------------------------------------------

/**
 * Plural
 *
 * Returns form form of russian noun.
 *
 * @access	public
 * @param	int     number
 * @param	string  singular form
 * @param	string  plural form 1
 * @param	string  plural form 2
 * @return	string	form depending on the number
 */

if ( ! function_exists('plural'))
{
    function plural($i, $str1, $str2, $str3)
    {
        if ($i % 10 === 1 && $i % 100 !== 11)
        {
            $plural = 0;
        }
        elseif ($i % 10 >= 2 && $i % 10 <= 4 && ($i % 100 < 10 || $i % 100 >= 20))
        {
            $plural = 1;
        }
        else
        {
            $plural = 2;
        }

        switch ($plural)
        {
            case 0:
                $out_str = $str1;
                break;
            case 1:
                $out_str = $str2;
                break;
            default:
                $out_str = $str3;
                break;
        }
        
        return $out_str;
    }
}

// --------------------------------------------------------------------

/**
 * Highlight pattern
 *
 * Returns highlighted regular expression.
 *
 * @access	public
 * @param	string  pattern
 * @return	string	highlighted pattern
 */

if ( ! function_exists('highlight_pattern'))
{
    function highlight_pattern($string, $extended = FALSE)
    {
        $comm_pattern = $extended ? '\#\V*' : '';
        $pattern = '
            (\\\\\\\\)                                  # 1 - экранированные бэкслэши
         |  (\\\\Q.*?\\\\E)                             # 2 - экранированная последовательность
         |  (' . $comm_pattern . ')                     # 3 - ищем комментарии - если стоит флаг x
         |  (\\\\\d+)                                   # 4 - ссылки на найденные подмаски
         |  (\\\\.)                                     # 5 - экранированные символы
         |  (\[ (?:\^\])?(?:[^]\\\\]+|\\\\.)* \])       # 6 - символьные классы
         |  ( \(\?\d+\) )                               # 7 - ссылка на подмаску
         |  ( \( (?:                                    # ----
                  \?:                                   #
                | \?>                                   #
                | \?=                                   # 8 - круглые скобки (вместе с признаками группировки,
                | \?!                                   #     а также модификаторами)
                | \?<!                                  #
                | \?<=                                  #
                | \?(?:-?[ismxeuADSUXJ])+)?             #
                | \)                                    #
            )                                           # ----
         |  (      (?:\+|\*|\?) (?:\+|\?)               #
                |  (?:\+|\*|\?)                         #
                |  (?:\{\s*\d+\s*,\s*(?:\d+)?\s*\})     # 9 - квантификаторы
                |  (?:\{\s*,\s*\d+\s*\})                #
                |  (?:\{\s*\d+\s*\})                    #
            )                                           # ----
         |  (\|)                                        # 10 - знак альтернативы
         |  (\x20)                                      # 11 - пробел
';
        return preg_replace_callback(
            '/'.$pattern.'/x',
            function($match)
            {
                switch (true)
                {
                    case ( ! empty($match[1])):
                        return  '<span class="reg-escaped bold">' . htmlspecialchars($match[1]) . '</span>';
                        break;
                    case ( ! empty($match[2])):
                        return  '<span class="reg-escaped">' . htmlspecialchars($match[2]) . '</span>';
                        break;
                    case ( ! empty($match[3])):
                        return  '<span class="reg-comments">' . htmlspecialchars($match[3]) . '</span>';
                        break;
                    case ( ! empty($match[4])):
                        return  '<span class="reg-backref bold">' . htmlspecialchars($match[4]) . '</span>';
                        break;
                    case ( ! empty($match[5])):
                        return  '<span class="reg-escaped bold">' . htmlspecialchars($match[5]) . '</span>';
                        break;
                    case ( ! empty($match[6])):
                        return  '<span class="reg-symbol">' . htmlspecialchars($match[6]) . '</span>';
                        break;
                    case ( ! empty($match[7])):
                        return  '<span class="reg-subgroup-ref bold">' . htmlspecialchars($match[7]) . '</span>';
                        break;
                    case ( ! empty($match[8])):
                        return  '<span class="reg-paren">' . htmlspecialchars($match[8]) . '</span>';
                        break;
                    case ( ! empty($match[9])):
                        return  '<span class="reg-quant">' . htmlspecialchars($match[9]) . '</span>';
                        break;
                    case ( ! empty($match[10])):
                        return  '<span class="reg-or">' . htmlspecialchars($match[10]) . '</span>';
                        break;
                    case ( ! empty($match[11])):
                        return  '<span class="reg-white">' . htmlspecialchars($match[11]) . '</span>';
                        break;
                    default:
                        break;
                }
            },
            $string
        );
    }
}

// --------------------------------------------------------------------

/**
 * Highlight replacement
 *
 * Returns highlighted replacement string.
 *
 * @access	public
 * @param	string  pattern
 * @return	string	highlighted replacement string
 */

if ( ! function_exists('highlight_replacement'))
{
    function highlight_replacement($str, $func_placeholders = array())
    {
        return preg_replace(
               '/(?|({{(?:' . implode('|', $func_placeholders) . ')[\x20]\$\d}})|(?<!\\\\)(\$\d+))/ux',
               '<span class="reg-backref">\1</span>',
               $str);
    }
}

// --------------------------------------------------------------------

/**
 * Split range
 *
 * string - "number1-number2"
 * Returns split string:
 * if numbers are adjacent (1-2, 24-25 etc.) returns "1 and 2"
 * if not leaves string unchanged
 *
 * @access	public
 * @param	string  string
 * @return	string	split string
 */

if ( ! function_exists('split_range'))
{
    function split_range($str, $delimiter = '-')
    { 
        if (preg_match('/^\d+' . str_replace('/', '\/', $delimiter) . '\d+$/', $str))
        {            
            $nums = explode($delimiter, $str);
            return $nums[1] - $nums[0] === 1 ? $nums[0] . ' ' . lang('common_and') . ' ' . $nums[1] : $str;
        }
        else
        {
            return $str;
        }
        
    }
}

// --------------------------------------------------------------------

