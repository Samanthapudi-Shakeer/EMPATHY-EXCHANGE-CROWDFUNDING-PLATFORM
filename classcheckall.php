<?php
function factorial($n) {
    if ($n === 0) {
        return 1;
    } elseif ($n < 0) {
        return "No Factorial for negative numbers.";
    } else {
        return $n * factorial($n - 1);
    }
}
$number='';
// Take user input
if(isset($_POST['number'])) {
    $number = intval($_POST['number']);
    echo "The factorial of $number is " . factorial($number);
}
?>
<style>
    input
    {
        color: red;
        border: 7px ridge red;
        box-sizing: border-box;
        align-items: center;
        text-align: center;
    }
</style>
<form method="post" action="classcheckall.php">
    Enter a Positive Integer
    <input type="text" name="number" value="<?php echo $number ?>">
    <input type="submit" value="Calculate Factorial">
</form>

