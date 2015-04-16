<?php
function datediff($interval, $date1, $date2) {
   // Function roughly equivalent to the ASP "DateDiff" function
   $seconds = $date2 - $date1;

   switch($interval) {
       case "y":
           list($year1, $month1, $day1) = split('-', date('Y-m-d', $date1));
           list($year2, $month2, $day2) = split('-', date('Y-m-d', $date2));
           $time1 = (date('H',$date1)*3600) + (date('i',$date1)*60) + (date('s',$date1));
           $time2 = (date('H',$date2)*3600) + (date('i',$date2)*60) + (date('s',$date2));
           $diff = $year2 - $year1;
           if($month1 > $month2) {
               $diff -= 1;
           } elseif($month1 == $month2) {
               if($day1 > $day2) {
                   $diff -= 1;
               } elseif($day1 == $day2) {
                   if($time1 > $time2) {
                       $diff -= 1;
                   }
               }
           }
           break;
       case "m":
           list($year1, $month1, $day1) = split('-', date('Y-m-d', $date1));
           list($year2, $month2, $day2) = split('-', date('Y-m-d', $date2));
           $time1 = (date('H',$date1)*3600) + (date('i',$date1)*60) + (date('s',$date1));
           $time2 = (date('H',$date2)*3600) + (date('i',$date2)*60) + (date('s',$date2));
           $diff = ($year2 * 12 + $month2) - ($year1 * 12 + $month1);
           if($day1 > $day2) {
               $diff -= 1;
           } elseif($day1 == $day2) {
               if($time1 > $time2) {
                   $diff -= 1;
               }
           }
           break;
       case "w":
           // Only simple seconds calculation needed from here on
           $diff = floor($seconds / 604800);
           break;
       case "d":
           $diff = floor($seconds / 86400);
           break;
       case "h":
           $diff = floor($seconds / 3600);
           break;
       case "i":
           $diff = floor($seconds / 60);
           break;
       case "s":
           $diff = $seconds;
           break;
   }
   return $diff;
}

//Zero-pad time

function printtime() {
   $timenow	= getdate();
   $hours	= substr("0" . $timenow["hours"], -2);
   $minutes	= substr("0" . $timenow["minutes"], -2);
   $seconds	= substr("0" . $timenow["seconds"], -2);

   return($hours . " " . $minutes . " " . $seconds);
}

//Some general date functions.

function sub($timestamp, $seconds,$minutes,$hours,$days,$months,$years) {
   $mytime = mktime(1+$hours,0+$minutes,0+$seconds,1+$months,1+$days,1970+$years);
   return $timestamp - $mytime;
}
function add($timestamp, $seconds,$minutes,$hours,$days,$months,$years) {
   $mytime = mktime(1+$hours,0+$minutes,0+$seconds,1+$months,1+$days,1970+$years);
   return $timestamp + $mytime;
}
function dayOfWeek($timestamp) {
   return intval(strftime("%w",$timestamp));
}
function daysInMonth($timestamp) {
   $timepieces	= getdate($timestamp);
   $thisYear	= $timepieces["year"];
   $thisMonth	= $timepieces["mon"];

   for($thisDay=1;checkdate($thisMonth,$thisDay,$thisYear);$thisDay++);

   return $thisDay;
}
function firstDayOfMonth($timestamp) {
   $timepieces        = getdate($timestamp);
   return mktime(    $timepieces["hours"],
                     $timepieces["minutes"],
                   $timepieces["seconds"],
                   $timepieces["mon"],
                   1,
                   $timepieces["year"]);
}
function monthStartWeekDay($timestamp) {
   return dayOfWeek(firstDayOfMonth($timestamp));
}
function weekDayString($weekday) {
   $myArray = Array(       0 => "Sun",
                           1 => "Mon",
                           2 => "Tue",
                           3 => "Wed",
                           4 => "Thu",
                           5 => "Fri",
                           6 => "Sat");
   return $myArray[$weekday];
}
function stripTime($timestamp) {
   $timepieces        = getdate($timestamp);
   return mktime(    0,
                     0,
                   0,
                   $timepieces["mon"],
                   $timepieces["mday"],
                   $timepieces["year"]);
}
function getDayOfYear($timestamp) {
   $timepieces = getdate($timestamp);
   return intval($timepieces["yday"]);
}
function getYear($timestamp) {
   $timepieces = getdate($timestamp);
   return intval($timepieces["year"]);
}
function dayDiff($timestamp1,$timestamp2) {
   $dayInYear1 = getDayOfYear($timestamp1);
   $dayInYear2 = getDayOfYear($timestamp2);
   return ((getYear($dayInYear1)*365 + $dayInYear1) - (getYear($dayInYear2)*365 + $dayInYear2));
}

function formatDate($date,$format)
{
	$datetime = date_create($date);
	$datealone = date_format($datetime, $format);
	return $datealone;
}

function formatDateTime($datetime)
{
	$datetime = date_create($datetime);
	$datepart = date_format($datetime, 'j M Y');
	$timepart = date_format($datetime, 'H:i');
	return $datepart . "<br>" . $timepart;
}

function timeZoneDiff($tz)
{
	$dateTimeZone		= new DateTimeZone($tz);
	$dateTime			= new DateTime("now", $dateTimeZone);
	$timeOffset			= $dateTimeZone->getOffset($dateTime);
	$timeOffset			= ($timeOffset/60/60); // in hours
	return $timeOffset;
}

/**
 * This function returns the server timezone offset in seconds
 * e.g. Sydney in DST returns +1100 / 100 * 60 * 60 = 39600
 */
function getServerTimeZoneOffset()
{
    return date("O") / 100 * 60 * 60; // Seconds from GMT
}

/**
 * This function returns the local timezone offset in seconds
 *   where getTimeZone($tz) returns a timezone see below.
 */
function getLocalTimeZoneOffset($tz)
{
    return getTimeZone($tz) / 100 * 60 * 60; // Seconds from user GMT
}

// Now converting a server timestamp to a local timestamp is very simple.

/**
 * Will take a timestamp and minus off Server GMT and add on user GMT seconds
 * thereby making a local timestamp from a server timestamp.
 */
function getLocalTimestampFromServerTimestamp($tz, $timestamp)
{
    return $timestamp - getServerTimeZoneOffset() + getLocalTimeZoneOffset( $tz );
}

//And getting the local time from a user entered date is a useful function.
//Combine the next two functions to achieve just that.

function getLocalTimestampFromDateTime($tz, $datetime)
{
    $timestamp = strtotime($datetime);
    return getLocalTimestampFromServerTimestamp($tz, $timestamp);
}

/**
 * If you have a localized timestamp and just want to get the date format use this.
 */
function getFormattedDate($tz, $timestamp)
{
    return date("Y-m-d H:i:s " . getTimeZone($tz), $timestamp);
}

/**
 * Returns a timezone in the format +0000
 *  e.g. Perth in DST returns +0900
 */
function getTimeZone($tz)
{
    return "+0900"; // Perth in DST
}

?>
