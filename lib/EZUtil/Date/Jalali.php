<?php
/*
* Copyright 2013 Mehdi Bakhtiari
*
* THIS SOFTWARE IS A FREE SOFTWARE AND IS PROVIDED BY THE COPYRIGHT HOLDERS
* AND CONTRIBUTORS "AS IS".YOU CAN USE, MODIFY OR REDISTRIBUTE IT UNDER THE
* TERMS OF "GNU LESSER GENERAL PUBLIC LICENSE" VERSION 3. YOU SHOULD HAVE
* RECEIVED A COPY OF FULL TEXT OF LGPL AND GPL SOFTWARE LICENCES IN ROOT OF
* THIS SOFTWARE LIBRARY. THIS SOFTWARE HAS BEEN DEVELOPED WITH THE HOPE TO
* BE USEFUL, BUT WITHOUT ANY WARRANTY. IN NO EVENT SHALL THE COPYRIGHT OWNER
* OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL,
* EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO,
* PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS;
* OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY,
* WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
* OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF
* ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
*
* THIS SOFTWARE IS LICENSED UNDER THE "GNU LESSER PUBLIC LICENSE" VERSION 3.
*/

/*
 * Many thanks to Roozbeh Pournader and Mohammad Toossi for their contribution and hard work
 * for implementing the the conversion between Gregorian and Jalali calendars.
 */

namespace EZUtil\Date;

class Jalali
{
	/**
	 * @var \DateTime
	 */
	protected $gregorian;

	/**
	 * @var int
	 */
	protected $year;

	/**
	 * @var int
	 */
	protected $month;

	/**
	 * @var int
	 */
	protected $day;

	/**
	 * @var int
	 */
	protected $weekDay;

	function __construct($year = null, $month = null, $day = null)
	{
		$this->year  = $year;
		$this->month = $month;
		$this->day   = $day;
	}

	/**
	 * @param \DateTime $gregorian
	 * @return Jalali
	 */
	public function setGregorianDate(\DateTime $gregorian)
	{
		$this->gregorian = $gregorian;
		return $this;
	}

	/**
	 * @return Jalali
	 * @throws DateException
	 */
	public function getJalali()
	{
		if (empty($this->gregorian))
			throw new DateException('No gregorian date has been provided yet.');

		$gYear  = (int) $this->gregorian->format('Y') - 1600;
		$gMonth = (int) $this->gregorian->format('m') - 1;
		$gDay   = (int) $this->gregorian->format('d') - 1;

		$gDayNumber = 365 * $gYear
			+ $this->divide($gYear + 3, 4)
			- $this->divide($gYear + 99, 100)
			+ $this->divide($gYear + 399, 400);

		for ($i = 0; $i < $gMonth; ++$i)
			$gDayNumber += JalaliFormat::$GREGORIAN_MONTH_DAYS[$i];

		if ($gMonth > 1 && (($gYear % 4 == 0 && $gYear % 100 != 0) || ($gYear % 400 == 0)))
			$gDayNumber++;

		$gDayNumber += $gDay;
		$jDayNumber = $gDayNumber - 79;
		$j_np       = $this->divide($jDayNumber, 12053);
		$jDayNumber = $jDayNumber % 12053;
		$jYear      = 979 + 33 * $j_np + 4 * $this->divide($jDayNumber, 1461);
		$jDayNumber %= 1461;

		if ($jDayNumber >= 366) {
			$jYear += $this->divide($jDayNumber - 1, 365);
			$jDayNumber = ($jDayNumber - 1) % 365;
		}

		for ($i = 0; $i < 11 && $jDayNumber >= JalaliFormat::$JALALI_MONTH_DAYS[$i]; ++$i)
			$jDayNumber -= JalaliFormat::$JALALI_MONTH_DAYS[$i];

		$jMonth = $i + 1;
		$jDay   = $jDayNumber + 1;

		if ($jMonth < 10)
			$jMonth = "0" . $jMonth;

		if ($jDay < 10)
			$jDay = "0" . $jDay;

		$this->year    = $jYear;
		$this->month   = $jMonth;
		$this->day     = $jDay;
		$this->weekDay = $this->gregorian->format('w');
		return $this;
	}

	/**
	 * @return \DateTime
	 * @throws DateException
	 */
	public function getGregorian()
	{
		if (empty($this->year) || empty($this->month) || empty($this->day))
			throw new DateException('No jalali date has been provided yet.');

		$jy         = $this->year - 979;
		$jm         = $this->month - 1;
		$jd         = $this->day - 1;
		$jDayNumber = 365 * $jy + $this->divide($jy, 33) * 8 + $this->divide($jy % 33 + 3, 4);

		for ($i = 0; $i < $jm; ++$i)
			$jDayNumber += JalaliFormat::$JALALI_MONTH_DAYS [$i];

		$jDayNumber += $jd;
		$gDayNumber = $jDayNumber + 79;
		$gy         = 1600 + 400 * $this->divide($gDayNumber, 146097);
		$gDayNumber = $gDayNumber % 146097;
		$leap       = true;

		if ($gDayNumber >= 36525) {
			$gDayNumber--;
			$gy += 100 * $this->divide($gDayNumber, 36524);
			$gDayNumber = $gDayNumber % 36524;

			if ($gDayNumber >= 365)
				$gDayNumber++;
			else
				$leap = false;
		}

		$gy += 4 * $this->divide($gDayNumber, 1461);
		$gDayNumber %= 1461;

		if ($gDayNumber >= 366) {
			$leap = false;
			$gDayNumber--;
			$gy += $this->divide($gDayNumber, 365);
			$gDayNumber = $gDayNumber % 365;
		}

		for ($i = 0; $gDayNumber >= JalaliFormat::$GREGORIAN_MONTH_DAYS [$i] + ($i == 1 && $leap); $i++)
			$gDayNumber -= JalaliFormat::$GREGORIAN_MONTH_DAYS [$i] + ($i == 1 && $leap);

		$gm = $i + 1;
		$gd = $gDayNumber + 1;

		if ($gm < 10)
			$gm = "0" . $gm;

		if ($gd < 10)
			$gd = "0" . $gd;

		return new \DateTime("{$gy}/{$gm}/{$gd}");
	}

	/**
	 * This method accepts a combination of standard date format characters, including <d, j, w, m, F, y, Y>
	 *
	 * @param string $format
	 * @link http://php.net/manual/en/function.date.php
	 *
	 * @throws DateException
	 * @return string
	 */
	public function format($format)
	{
		if (empty($this->year) || empty($this->month) || empty($this->day))
			throw new DateException('No date is yet available to be formatted.');

		if (empty($this->weekDay))
			$this->weekDay = $this->getGregorian()->format('w');

		$format = str_replace('d', $this->day, $format);
		$format = str_replace('j', ((int) $this->day), $format);
		$format = str_replace('w', JalaliFormat::$WEEK_DAYS[(int) $this->weekDay], $format);
		$format = str_replace('m', $this->month, $format);
		$format = str_replace('F', JalaliFormat::$JALALI_MONTHS[(int) $this->month - 1], $format);
		$format = str_replace('y', substr($this->year, 2, 2), $format);
		$format = str_replace('Y', $this->year, $format);
		return $format;
	}

	/**
	 * This method adds a number units to the current date value.
	 * For more information about the designator argument, please refer to the provided link.
	 *
	 * @param int    $unit
	 * @param string $designator
	 * @link http://www.php.net/manual/en/dateinterval.construct.php
	 *
	 * @return Jalali
	 * @throws DateException
	 */
	public function add($unit, $designator = 'D')
	{
		if (empty($this->gregorian) && (empty($this->year) || empty($this->month) || empty($this->day)))
			throw new DateException('No date is yet available to add units to it.');

		if (!in_array($designator, array('Y', 'M', 'D', 'W', 'H', 'M', 'S')))
			throw new DateException('The provided designator parameter is not supported for Jalali dates.');

		if (empty($this->gregorian))
			$this->gregorian = $this->getGregorian();

		$unit        = (int) $unit;
		$formatStart = 'P';

		if (in_array($designator, array('H', 'M', 'S')))
			$formatStart .= 'T';

		$this->gregorian = (int) $unit >= 0
			? $this->gregorian->add(new \DateInterval("{$formatStart}{$unit}{$designator}"))
			: $this->gregorian->sub(new \DateInterval("{$formatStart}" . abs((int) $unit) . "{$designator}"));

		$this->getJalali($this->gregorian);
		return $this;
	}

	/**
	 * @return int
	 */
	public function getYear()
	{
		return $this->year;
	}

	/**
	 * @return int
	 */
	public function getMonth()
	{
		return $this->month;
	}

	/**
	 * @return int
	 */
	public function getDay()
	{
		return $this->day;
	}

	/**
	 * @param int $a
	 * @param int $b
	 * @return int
	 */
	private function divide($a, $b)
	{
		return (int) ($a / $b);
	}
}