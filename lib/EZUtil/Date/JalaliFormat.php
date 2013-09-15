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

namespace EZUtil\Date;

/**
 * Class JalaliFormat
 * @package EZUtil\Date
 * @author  Mehdi Bakhtiari <mehdone@gmail.com>
 */
class JalaliFormat
{
	public static $JALALI_MONTHS = array(
		'فروردین',
		'اردیبهشت',
		'خرداد',
		'تیر',
		'مرداد',
		'شهریور',
		'مهر',
		'آبان',
		'آذر',
		'دی',
		'بهمن',
		'اسفند',
	);

	public static $WEEK_DAYS = array(
		'يكشنبه',
		'دوشنبه',
		'سه شنبه',
		'چهارشنبه',
		'پنجشنبه',
		'جمعه',
		'شنبه');

	public static $GREGORIAN_MONTH_DAYS = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	public static $JALALI_MONTH_DAYS = array(31, 31, 31, 31, 31, 31, 30, 30, 30, 30, 30, 29);

	/**
	 * Returns the zero-based index of the provided month
	 *
	 * @param string $month
	 * @return int|null
	 */
	public static function getMonthIndex($month)
	{
		for ($i = 0; $i < count(self::$JALALI_MONTHS); $i++)
			if (self::$JALALI_MONTHS[$i] === $month)
				return $i;

		return null;
	}
}
