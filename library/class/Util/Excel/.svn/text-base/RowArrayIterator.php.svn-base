<?PHP
/* vim: set expandtab tabstop=4 shiftwidth=4: */



// 辅助 Excel 行读取, 为了得到一行数组, 依赖 PHPExel >= 1.7
/**
 * 用法：
 * 
 * $objReader = PHPExcel_IOFactory::createReader('Excel2007');
 * $objWorksheet = $objPHPExcel->getActiveSheet();
 * 
 * foreach(new Util_Excel_RowArrayIterator($objWorksheet) as $row) {
 *		print_r($row);
 * }
 * 
 */

/**
 * Excel_RowArrayIterator
 * 
 * @author      Liut
 * @package     Core
 * @version     $Id$
 * @lastupdate  $Date$
 * 
 * 	
 */
class Util_Excel_RowArrayIterator implements Iterator, Countable
{
	/**
	 * PHPExcel_Worksheet to iterate
	 *
	 * @var PHPExcel_Worksheet
	 */
	private $_subject;
	
	/**
	 * Current iterator position
	 *
	 * @var int
	 */
	private $_position = 1;
	
	/**
	 * Create a new row iterator
	 *
	 * @param PHPExcel_Worksheet 		$subject
	 */
	public function __construct(PHPExcel_Worksheet $subject = null) {
		// Set subject
		$this->_subject = $subject;
	}
	
	/**
	 * Destructor
	 */
	public function __destruct() {
		unset($this->_subject);
	}
	
	/**
	 * Rewind iterator
	 */
	public function rewind() {
		$this->_position = 1;
	}
	
	/**
	 * Current PHPExcel_Worksheet_Row
	 *
	 * @return PHPExcel_Worksheet_Row
	 */
	public function current() {
		$row = new PHPExcel_Worksheet_Row($this->_subject, $this->_position);
		$cellIterator = $row->getCellIterator();
		$cellIterator->setIterateOnlyExistingCells(false);
		$arr = array();
		foreach ($cellIterator as $cell) {
			$arr[] = $cell->getValue();
		}
		return $arr;

	}
	
    /**
     * Current key
     *
     * @return int
     */
	function key() {
		return $this->_position - 1; // 修正索引值，以0开始
	}
	
    /**
     * Next value
     */
    public function next() {
        ++$this->_position;
    }
	
    /**
     * More PHPExcel_Worksheet_Row instances available?
     *
     * @return boolean
     */
    public function valid() {
        return $this->_position <= $this->_subject->getHighestRow();
    }
	
	public function count()
	{
		return $this->_subject->getHighestRow();
	} 
}


