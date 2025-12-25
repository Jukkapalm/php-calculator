<!DOCTYPE html>
<html lang="fi">
    <head>
        <title>php calculator</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                background-color: #2C2C2C;
            }
            form {
                display: flex;
                flex-direction: column;
                gap: 10px;
                border: 1px solid #F4F4F4;
                box-shadow: 0 0 6px #F4F4F4, 0 0 12px #F4F4F4;
                border-radius: 10px;
                padding: 30px;
                background-color: #F4F4F4;
            }
            form, h2 {
                color: #2C2C2C;
            }
            input, select {
                padding: 12px;
                border-radius: 8px;
                border: 1px solid #ccc;
                font-size: 14px;
                background-color: #F4F4F4;
            }
            input::placeholder {
                color: #888888;
            }
            button {
                padding: 12px;
                border: none;
                border-radius: 8px;
                background-color: #888888;
                font-weight: bold;
                cursor: pointer;
            }
            p {
                text-align: center;
            }

        </style>
    </head>
    <body>

        <!-- PHP_self käsittelee tiedot tällä samalla sivulla ja htmlspecialchars puhdistaa tulosteen -->
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">

            <h2>Yksinkertainen laskin</h2>
            <!-- Ensimmäisen numeron syöte -->
            <input type="number" name="numero1" placeholder="Syötä ensimmäinen numero" step="any">

            <!-- Pudotusvalikko operaattoria varten -->
            <select name="operaattorit">
                <option value="plus">+</option>
                <option value="miinus">-</option>
                <option value="jako">/</option>
                <option value="kerto">*</option>
            </select>

            <!-- Toisen numeron syöte -->
            <input type="number" name="numero2" placeholder="Syötä toinen numero" step="any">

            <button>Laske</button>
        

            <?php

            // Tarkistetaan että lähetys metodi on POST
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                // Haetaan data käyttäjän syötteistä ja samalla suodatetaan syötteistä erikoismerkit, vain numerot ja desimaalierotin sallittuja
                $numero1 = filter_input(INPUT_POST, "numero1", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $numero2 = filter_input(INPUT_POST, "numero2", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $operaattori = htmlspecialchars($_POST["operaattorit"]);

                // Virheen tarkistukset
                $errors = false;

                // Voidaan käyttää myös esim empty($numero1), mutta tämä tulkitsee numeron 0 tyhjäksi
                if ($numero1 == "" || $numero2 == "" || empty($operaattori)) {
                    echo "<p>Täytä kaikki kentät!</p>";
                    $errors = true;
                }

                if (!is_numeric($numero1) || !is_numeric($numero2)) {
                    echo "<p>Vain numerot sallittuja!</p>";
                    $errors = true;
                }

                // Suoritetaan laskutoimitus jos ei virheitä tullut
                if (!$errors) {
                    $tulos = 0;
                    switch ($operaattori) {
                        case "plus":
                            $tulos = $numero1 + $numero2;
                            break;
                        case "miinus":
                            $tulos = $numero1 - $numero2;
                            break;
                        case "jako":
                            $tulos = $numero1 / $numero2;
                            break;
                        case "kerto":
                            $tulos = $numero1 * $numero2;
                            break;
                        default:
                            echo "<p>Tapahtui virhe!</p>";
                    }

                    echo "<p>Tulos on = " . $tulos . "</p>";
                }


            }
            ?>
        </form>

    </body>
</html>