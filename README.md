### Convert Gregorian calendar date to Jalali

`$date = new Jalali();
echo $date->setGregorianDate(new \DateTime())->format('Y/m/d')