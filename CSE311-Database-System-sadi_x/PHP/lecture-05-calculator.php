<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>

    <form action=" <?php
    echo htmlspecialchars($_SERVER["PHP_SELF"]);
    ?> " method="POST">

        <label for="num1">First Number:</label> <br>
        <input type="number" id="num1" name="num_1" placeholder="Number-01">  <br> <br>

        <label for="operator">Operator:</label> <br>
        <select name="operator" id="operator">

            <option value="addition">+</option>
            <option value="subtract">-</option>
            <option value="multiplication">*</option>
            <option value="division">/</option>


        </select> <br> <br>

        <label for="num2">Second Number:</label> <br>
        <input type="number" id="num2" name="num_2" placeholder="Number-02"> <br>


        <button>Calculate</button>

    </form>


    <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            // Grab Input


//            $num1 = $_POST['num_1']; --> this will take the value without any change
            $num1 = filter_input(INPUT_POST, "num_1", FILTER_SANITIZE_NUMBER_INT); // -> more safe code, prevent the user from entering any of malicious code

            $num2 = filter_input(INPUT_POST, "num_2", FILTER_SANITIZE_NUMBER_INT);

            $operator = htmlspecialchars($_POST["operator"]); // --> String is something that cannot be sanitized like int

            // Error Handlers
            $errors = false;

            if (empty($num1) or  empty($num2) or empty($operator)) {
                echo "All fields are required";
                $errors = true;
            }

            $result = -1;

            if  (!$errors) {
                switch ($operator) {
                    case "addition":
                        $result = $num1 + $num2;
                        break;
                    case "subtract":
                        $result = $num1 - $num2;
                        break;
                    case "multiplication":
                        $result = $num1 * $num2;
                        break;
                    case "division":
                        $result = $num1 / $num2;
                        break;
                    default:
                        echo "Invalid operator.";
                        $errors = true;
                }

                if (!$errors) {
                    echo "<p class='result'>Result = " . $result . "</p>";
                }
            }



        }

    ?>


</body>
</html>