# HOW-TO GUIDE 

### Convert Gregorian calendar date to Jalali

```
$date = new Jalali();
echo $date->setGregorianDate(new \DateTime())->getJalali()->format('Y/m/d');
```

As you may have noticed, you can use [PHP's standard date format characters](http://php.net/manual/en/function.date.php) to format your Jalali date. Isn't that cool?

### Convert Jalali calendar date to Gregorian

```
$date = new Jalali(1392, 6, 6);
echo $date->getGregorian()->format('Y/m/d');
```

### Formatting the converted date

Let's say you want to output the Jalali converted date to something like "پنج شنبه، ۸ شهریور ۱۳۹۲"
You can achieve this by 

```
$date = new Jalali();
echo $date->setGregorianDate(new \DateTime())->getJalali()->format('w, d F Y');
```

This looks pretty much like the above code. All I have done is that I have provided a different format string ```w, d F Y```

### Adding units of date/time to the Jalali calendar date
To add a number of years/months/days/hours/minutes/seconds to the converted Jalali date you can use the ```add()``` method.

This method accepts two arguments. The first one is the number of units to add to the date and the second one is the date/time designator character.

Let's say you want to add 7 days to the current date.

```
$date = new Jalali(1392, 6, 6);
echo $date->add(7, 'D')->format('Y/m/d');
```

You could also do it like this:

```
$date = new Jalali(1392, 6, 6);
echo $date->add(1, 'W')->format('Y/m/d');
```

Again if you've noticed, [PHP's standard DateInterval characters](http://www.php.net/manual/en/dateinterval.construct.php) are used to add units of date/time to the Jalali date.

You can also use *negative values* for the unit being added to the Jalali date to subtract the amount of date/time from the Jalali date if you need to navigate backward in time.

### Convert TIMESTAMP to a Jalali calendar date
```
$date = new Jalali();
echo $date->setTimestamp(time())->getJalali()->format('Y/m/d');
```

It was that simple. All you need to do to convert a timestamp.
