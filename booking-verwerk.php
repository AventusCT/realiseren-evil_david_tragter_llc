<?php
    //om boodstrap in te laden voor de sysMsg (boven aan pagina)
    function htmlLoad(){
        echo '
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        ';
    }

    //functie voor het tonen van error messages
    function sysMsg($bgColor, $message, $subMessage, $link, $linkMsg){
        echo '
            <section class="vh-100 bg-dark d-flex align-items-center">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 col-md-12">
                            <div class="card bg-'. $bgColor .'">
                                <div class="card-body text-center text-light">
                                    <h1 class="mb-5">'. $message .'</h1>
                                    <p class="mb-5">'. $subMessage. '</p>
                                    <a href="'. $link .'" class="btn btn-outline-light mb-4">'. $linkMsg .'</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>           
        ';
    }
    
    htmlLoad();

    //afspraken naar de db sturen
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        //voor database connectie
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "project-2-afspraken"; 

        try {
            $conn = new mysqli($servername, $username, $password, $database);
        }
        catch (Exception $error){
            $errorTekst = htmlspecialchars($error->getMessage());
            sysMsg("danger", "Error :(", "$errorTekst wilt u terug naar login/registratie?", "#", "terug!");
            exit();
        }

        $date = $_POST['datum'];
        $time = $_POST['tijd'];
        $voornaam = $_POST['voornaam'];
        $achternaam = $_POST['achternaam'];
        
        $check_sql = "SELECT afspraakID FROM afspraken WHERE afspraakDatum = ? AND afspraakTijd = ?";
        
        $stmt = $conn -> prepare($check_sql);
        $stmt->bind_param("ss", $date, $time);
        $stmt->execute();
        $stmt->store_result();

        if($stmt -> num_rows > 0){
            sysMsg("danger", "deze datum is al bezet", "wilt u terug gaan naar boeken?", "booking-page.html", "Terug!");
            exit();
        }
        else{
            $sql = "INSERT INTO afspraken (voornaam, achternaam, afspraakDatum, afspraakTijd) VALUES (?, ?, ?, ?)";
            $stmt = $conn -> prepare($sql);
            $stmt->bind_param("ssss", $voornaam, $achternaam, $date, $time);

            if($stmt->execute()){
                sysMsg("success", "jouw afspraak is verwerkt :D", "wilt u terug naar de home page?", "#", "Terug!");
            }

        }
    $conn -> close();
    }
    else{
        sysMsg("danger", "geen input gegeven", "wilt u terug gaan naar boeken?", "booking-page.html", "Terug!");
    }
?>