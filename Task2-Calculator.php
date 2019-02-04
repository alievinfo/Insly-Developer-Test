<?php
/**
 * Task2 Calculator
 * Date: 12.01.2019
 * Time: 17:41
 * End Time: 18:40
 */

class Calculator
{
    public $base_percentage;
    public $comission_percentage = 17;

    /**
     * $tax_percentage - Tax percentage (0 - 100%)
     */
    public $tax_percentage;

    /**
     * $car_value - Estimated value of the car (100 - 100 000 EUR)
     */
    public $car_value;

    public function __construct()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $this->car_value = $this->userPostInt('car_value');
            $this->tax_percentage = $this->userPostInt('tax_percentage');
            $instalments = $this->userPostInt('instalments');
            if (($this->car_value >= 100) && ($this->car_value <= 100000) && ($this->tax_percentage >= 0) && ($this->tax_percentage <= 100) && ($instalments >= 1) && ($instalments <= 12)) {
                $this->buildCalculator($instalments);
            } else {
                header("Location: Task2-Calculator.html");
            }
        } else {
            header("Location: Task2-Calculator.html");
        }
    }


    /**
     * UserPostInt Method
     * POST request
     * Return numeric result or zero.
     *
     * @param $name
     */
    private function userPostInt($name = '')
    {
        return (array_key_exists($name, $GLOBALS['_POST'])) ? $this->filterInt($GLOBALS['_POST'][$name]) : 0;
    }

    /**
     * filterInt Method
     * Filter field to numeric format.
     *
     * @param $name - Field name
     */
    private function filterInt($name)
    {
        if (!is_array($name)) {
            $fld = (int)$name;
            $fld = $fld * 1;
            $fld = intval($fld);
        } else {
            $fld = 0;
        }
        return round($fld, 0);
    }
	
    /**
     * Format Display numbers
     *
     * @param $number
     */
    private function displayFormat($number)
    {
        return number_format($number, 2, '.', '');
    }

    /**
     * Build calculator
     *
     * @param $instalments - Number of instalments (count of payments in which client wants to pay for the policy (1 – 12))
     */
    private function buildCalculator($instalments)
    {
        $priceInfo = array();
        /**
         * Base price of policy is 11% from entered car value, except every Friday 15-20 o’clock (user time) when it is 13%
         */
        $this->base_percentage = ((date('w') == 5) && ((date('H') >= 15) && (date('H') <= 20))) ? 13 : 11;
        $priceInfo['base_price'] = $this->car_value * ($this->base_percentage / 100);

        /**
         * Commission is added to base price (17%)
         */
        $priceInfo['comission'] = $priceInfo['base_price'] * ($this->comission_percentage / 100);

        /**
         * Tax is added to base price (user entered)
         */
        $priceInfo['tax'] = $priceInfo['base_price'] * ($this->tax_percentage / 100);

        /**
         * Total cost
         */
        $priceInfo['total_cost'] = $priceInfo['base_price'] + $priceInfo['comission'] + $priceInfo['tax'];

        /**
         * Calculate different payments separately (if number of payments are larger than 1)
         * Installment sums must match total policy sum- pay attention to cases where sum does not divide equally
         * Output is rounded to two decimal places
         */
        $installmentsArr = array(
            'base_price' => round($priceInfo['base_price'] / $instalments, 2),
            'comission' => round($priceInfo['comission'] / $instalments, 2),
            'tax' => round($priceInfo['tax'] / $instalments, 2),
            'total_cost' => round($priceInfo['total_cost'] / $instalments, 2),
        );

        $this->priceMatrix($priceInfo, $installmentsArr, $instalments);

    }

	/** 
	 * Final output (price matrix)
	 */
    private function priceMatrix($priceInfo = array(), $installmentsArr = array(), $instalments)
    {
        ?>
        <table border="1">
            <tr>
                <th></th>
                <th>Policy</th>
                <?php
                if ($instalments>1) {
                    for($i=1; $i<=$instalments; $i++){
                        echo '<th>'.$i.' Instalment</th>';
                    }
                }
                ?>
            </tr>
            <tr>
                <td>Value</td>
                <td><?php echo $this->displayFormat($this->car_value); ?></td>
                <?php
                if ($instalments>1) {
                    for($i=1; $i<=$instalments; $i++){
                        echo '<td></td>';
                    }
                }
                ?>
            </tr>
            <tr>
                <td>Base premium(<?php echo $this->base_percentage; ?>%)</td>
                <td><?php echo $this->displayFormat($priceInfo['base_price']); ?></td>
                <?php
                if ($instalments>1) {
                    for($i=1; $i<=$instalments; $i++){
                        echo '<td>'.$this->displayFormat($installmentsArr['base_price']).'</td>';
                    }
                }
                ?>
            </tr>
            <tr>
                <td>Comission(<?php echo $this->comission_percentage; ?>%)</td>
                <td><?php echo $this->displayFormat($priceInfo['comission']); ?></td>
                <?php
                if ($instalments>1) {
                    for($i=1; $i<=$instalments; $i++){
                        echo '<td>'.$this->displayFormat($installmentsArr['comission']).'</td>';
                    }
                }
                ?>
            </tr>
            <tr>
                <td>Tax(<?php echo $this->tax_percentage; ?>%)</td>
                <td><?php echo $this->displayFormat($priceInfo['tax']); ?></td>
                <?php
                if ($instalments>1) {
                    for($i=1; $i<=$instalments; $i++){
                        echo '<td>'.$this->displayFormat($installmentsArr['tax']).'</td>';
                    }
                }
                ?>
            </tr>
            <tr>
                <td><strong>Total cost</strong></td>
                <td><strong><?php echo $this->displayFormat($priceInfo['total_cost']); ?></strong></td>
                <?php
                if ($instalments>1) {
                    for($i=1; $i<=$instalments; $i++){
                        echo '<td>'.$this->displayFormat($installmentsArr['total_cost']).'</td>';
                    }
                }
                ?>
            </tr>
        </table>
        <?php
    }

}

$calculator = new Calculator();