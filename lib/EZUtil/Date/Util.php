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
 * Class Util
 * @package EZUtil\Date
 * @author  Mehdi Bakhtiari
 */
class Util
{
	/**
	 * @param string      $date1
	 * @param string      $date2
	 * @param string|null $delimiter
	 * @param string      $designator
	 * @return int
	 */
	public static function diff($date1, $date2, $delimiter = '/', $designator = '%a')
	{
		$jalali = new Jalali();
		$date1  = $jalali->setJalaliDate($date1, $delimiter)->getGregorian();
		$date2  = $jalali->setJalaliDate($date2, $delimiter)->getGregorian();
		return (int) $date2->diff($date1)->format($designator);
	}

	/**
	 * @param int    $maxDiff
	 * @param string $date1
	 * @param string $date2
	 * @param string $delimiter
	 * @param string $designator
	 * @return bool
	 */
	public static function checkMaxDiff($maxDiff, $date1, $date2, $delimiter = '/', $designator = '%a')
	{
		return static::diff($date1, $date2, $delimiter, $designator) <= $maxDiff;
	}
}
