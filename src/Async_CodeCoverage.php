<?php 


class Async_CodeCoverage extends \PHP_CodeCoverage
{
    protected $coverageData;

	/**
     * Stop collection of code coverage information.
     *
     * @param  bool                       $append
     * @param  mixed                      $linesToBeCovered
     * @param  array                      $linesToBeUsed
     * @return array
     * @throws PHP_CodeCoverage_Exception
     */
    public function stop($coverageDriver, $append = true, $linesToBeCovered = array(), array $linesToBeUsed = array())
    {
        if (!is_bool($append)) {
            throw PHP_CodeCoverage_Util_InvalidArgumentHelper::factory(
                1,
                'boolean'
            );
        }

        if (!is_array($linesToBeCovered) && $linesToBeCovered !== false) {
            throw PHP_CodeCoverage_Util_InvalidArgumentHelper::factory(
                2,
                'array or false'
            );
        }

        $this->coverageData = $coverageDriver->stop();
        // $this->append($this->coverageData, null, $append, $linesToBeCovered, $linesToBeUsed);

        $this->currentId = null;

        return $this->coverageData;
    }


    public function reProcessData() {
    	$this->append($this->coverageData, null, true, array(), array());
    }
}