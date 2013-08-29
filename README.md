### Convert Gregorian calendar date to Jalali

```
$date = new Jalali();
echo $date->setGregorianDate(new \DateTime())->format('Y/m/d');
```

As you may have noticed, you can use PHP's standard date format characters to format your Jalali date. Isn't that cool?

### Convert Jalali calendar calendar date to Gregorian

```
$date = new Jalali(1392, 6, 6);
echo $date->getGregorian()->format('Y/m/d');
```

