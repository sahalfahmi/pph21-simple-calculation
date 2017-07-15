<?php 


function calc_stages($dinamic_value = 0){
	

	//stages & percentage config
	//indicate total of calculation cycle
	$stages = [50000000,250000000,500000000,500000000];
	$percentage = [5,15,25,30];


	//initialize identification variable
	$result = 0;
	$total_balance = 0;


	//Loop the calculation from user input
	//get result regarding the stages & percentage config
	foreach ($stages as $key => $value) {
		
		//check early value to avoid repeat calculation
		//Total balance saving the total value on active state of looping
		//It will stoping calculation from looping stages
		if($dinamic_value >= $total_balance){
			
			//compare user input with current stage
			if($dinamic_value >= $value){

				//works when begining of looping process
				//because we want set value to 50,000,000 
				if($key == 0){
					$percentage_calc = $value * ($percentage[$key]/100);
					$total_balance = $total_balance + $value;
				}

				//set last value to "500,000,000" at the end of looping
				elseif($key == (count($stages)-1)){
					$left = $dinamic_value - $value;
					$percentage_calc = $left * ($percentage[$key]/100);
					$total_balance = $total_balance + $value;	
				}

				else{
					$percentage_calc = ($value-$stages[$key-1]) * ($percentage[$key]/100);
					$total_balance = $total_balance + ($value-$stages[$key-1]);
				}
			}
			else{

				if($key == 0){
					$percentage_calc = 0; //below taxable income
					$total_balance = $dinamic_value;
				}
				else{ 

					//When user input in condition of middle stages configuaration
					
					$left = $dinamic_value - $total_balance;

					$percentage_calc = $left * ($percentage[$key]/100);

					$total_balance = $total_balance + $left;
				}
			}

			
			//adding result for every calculation stages
			$result = $result + $percentage_calc;
			
		}

		

	}	

	//return value for this function 
	return $result;
}




//this value comes from annual taxable income
//get this value from user input ($_GET or $_POST) to make a simple calculation with different value
$dinamic_value = 75000000;

echo "Your Annual Tax Income is = <b>".number_format(calc_stages($dinamic_value))."</b><br>";
echo "Tax per-Month is <b>".number_format(calc_stages($dinamic_value)/12)."<b>";

?>