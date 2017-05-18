<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_image_url'))
{
    function get_image_url($url = '')
    {
        if(
            startsWith($url,'/assets/') ||
            startsWith($url,'/lib/')
            ){
            return base_url($url);
        }
        if(
            startsWith($url,'/data/')
            ){
            return base_url(str_replace_first('/data','data',$url));
        }
        return $url;
    }   
}
if ( ! function_exists('get_thumb_url'))
{
    function get_thumb_url($url = '')
    {
        if(
            startsWith($url,'/assets/') ||
            startsWith($url,'/lib/')
            ){
            return base_url($url);
        }
        if(
            startsWith($url,'/data/')
            ){
            return base_url(str_replace_first('/data','data/thumbs',$url));
        }
        return $url;
    }   
}
function startsWith($haystack, $needle)
{
     $length = strlen($needle);
     return (substr($haystack, 0, $length) === $needle);
}

function endsWith($haystack, $needle)
{
    $length = strlen($needle);
    if ($length == 0) {
        return true;
    }

    return (substr($haystack, -$length) === $needle);
}
function str_replace_first($from, $to, $subject)
{
    $from = '/'.preg_quote($from, '/').'/';

    return preg_replace($from, $to, $subject, 1);
}