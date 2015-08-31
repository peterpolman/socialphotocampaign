<?php
class chunkReadFilter  implements PHPExcel_Reader_IReadFilter
{
	private $worksheets;			//Placeholder
	private $rows;
	private $columns;
	
    private $_startRow = 0;
    private $_endRow = 0;

    public function setRows($startRow, $chunkSize) { 
        $this->_startRow    = $startRow; 
        $this->_endRow      = $startRow + $chunkSize;
    } 
	
    public function readCell($column, $row, $worksheetName = '') {
    	if (is_array($this->worksheets)) {
			if (!in_array($worksheetName, $this->worksheets)) {
				return false;
			}
		}
		
		if($row < $this->_startRow && $row > $this->_endRow) {
			return false;
		}
    	
		if (is_array($this->rows)) {
			if (!in_array($row, $this->rows)) {
				return false;
			}
		}
		
    	if (is_array($this->columns)) {
			if (!in_array($column, $this->columns)) {
				return false;
			}
		}
		
		return true;
    }
    
    public function __construct($worksheets,$rows,$columns) {
    	$this->worksheets = $worksheets;
    	$this->rows = $rows;
    	$this->columns = $columns;
    }
}
?>