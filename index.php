<?php
    /* Paramètre de la Base de Données */
    $host = 'localhost';
    $user = 'root';
    $pass = 'root';
    $db = 'infotools';
    $MySqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

    /* --- --- --- --- Graphique N°1 --- --- --- --- */

    /* Valeur de la Requête */
    $LibCat = '';
    $NbProd = '';

    /* Requête */
    $Sql = "SELECT COUNT(produit.IdProd) as NbProd, COUNT(categorie.NumCat) as NbCat, LibCat FROM categorie INNER JOIN produit ON categorie.NumCat = produit.NumCat GROUP BY LibCat";
    $Result = mysqli_query($MySqli, $Sql);

    /* Récupération de toute les données */
    while ($Row = mysqli_fetch_array($Result)) {
        // $Stat = $row['NbCat'] / $row['NbProd'] *100;
		$LibCat = $LibCat . '"'. $Row['LibCat'].'",';
        $NbProd = $NbProd . '"'. $Row['NbProd'].'",';
	}

    $LibCat = trim($LibCat,",");

    /* --- --- --- --- Graphique N°2 --- --- --- --- */

    /* Valeur de la Requête */
    $LibRole = '';
    $NbUti = '';

    /* Requête */
    $Sql = "SELECT COUNT(IdUti) as NbUti, role.LibRole FROM utilisateur INNER JOIN role ON utilisateur.NumRole = role.NumRole GROUP BY role.LibRole";
    $Result = mysqli_query($MySqli, $Sql);

    /* Récupération de toute les données */
    while ($Row = mysqli_fetch_array($Result)) {
        // $Stat = $row['NbCat'] / $row['NbProd'] *100;
		$LibRole = $LibRole . '"'. $Row['LibRole'].'",';
        $NbUti = $NbUti . '"'. $Row['NbUti'].'",';
	}

    /* --- --- --- --- Graphique N°3 --- --- --- --- */

    /* Valeur de la Requête */
    $LibRole = '';
    $NbUti = '';

    /* Requête */
    $Sql = "SELECT COUNT(IdFact) AS NbFacture FROM facturation WHERE IdUti = (SELECT COUNT(IdUti) FROM Utilisateur)";
    $Result = mysqli_query($MySqli, $Sql);

    /* Récupération de toute les données */
    while ($Row = mysqli_fetch_array($Result)) {
        // $Stat = $row['NbCat'] / $row['NbProd'] *100;
		$LibRole = $LibRole . '"'. $Row['LibRole'].'",';
        $NbUti = $NbUti . '"'. $Row['NbUti'].'",';
	}

    /* --- --- --- --- Erreur --- --- --- --- */

    /* Si rien n'est retourné dans la variable <Result> */
    if (!$Result) {
		printf("Error: %s\n", mysqli_error($MySqli));
		exit();
	}

?>

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.4/jspdf.min.js"></script>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
        <title>InfoTools | Graphiques</title>
    </head>
    <body>
        <h1 class="title">Graphiques d'InfoTools</h1>
        <div class="container">
            
            <div class="graph">
                <canvas class="graphique" id="MaterielPieGraph"></canvas>
            </div>
            <button type="button" id="download-pdf" >
            Download PDF
            </button>
            <hr>
            <div class="graph">
                <canvas class="graphique" id="UserDoughnutGraph"></canvas>
            </div>
<<<<<<< HEAD
            <button type="button" id="download1-pdf" >
            Download PDF
            </button>
=======
            <hr>
            <div class="graph">
                <canvas class="graphique" id="PolarAreaGraph"></canvas>
            </div>
            <hr>
>>>>>>> ae6fd4447ccdf3c46bb02b3a57d89071ff349280

            <script>

                /* Graphique N°1 */

                var Graph = document.getElementById("MaterielPieGraph").getContext('2d');
                var myChart = new Chart(Graph, {
                    type: 'pie',
                    data: {
                        labels: [<?php echo $LibCat; ?>],
                        datasets: 
                        [{
                            data: [<?php echo $NbProd; ?>],
                            backgroundColor: [
                            'rgb(255, 99, 132)',
                            'rgb(54, 162, 235)',
                            'rgb(255, 205, 86)'
                            ],
                            borderColor:'#111',
                            borderWidth: 3,
                        }]
                    },
                
                    options: {
                        scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
                        tooltips: {
                            mode: 'index'
                            },
                        legend: {
                            display: true,
                            position: 'right',
                            labels: { 
                                display: true,
                                fontColor: 'rgb(255,255,255)',
                                fontSize: 16 }
                                },
                        title: {
                            display: true,
                            position: 'left',
                            text: "Produits par Catégories",
                            fontColor :'rgb(255,255,255)',
                            fontSize: 30 }
                    }
                });

                /* Graphique N°2 */

                    var Graph = document.getElementById("UserDoughnutGraph").getContext('2d');
                    var myChart = new Chart(Graph, {
                    type: 'doughnut',
                    data: {
                        labels: [<?php echo $LibRole; ?>],
                        datasets: 
                        [{
                            data: [<?php echo $NbUti; ?>],
                            backgroundColor: [
                            'rgb(46, 204, 113)',
                            'rgb(142, 68, 173)',
                            'rgb(236, 112, 99 )'
                            ],
                            borderColor:'#111',
                            borderWidth: 3,
                        }]
                    },
                
                    options: {
                        scales: {
                            scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
                        tooltips:{ 
                            mode: 'index'
                            },
                        legend: {
                            display: true,
                            position: 'right',
                            labels: {
                                display: true,
                                fontColor: 'rgb(255,255,255)',
                                fontSize: 16 }
                                },
                        title: {
                            display: true,
                            position: 'left',
                            text: "Roles des Utilisateurs",
                            fontColor :'rgb(255,255,255)', 
                            fontSize: 30 }
                    }
                });
                
                //add event listener to button
                document.getElementById('download-pdf').addEventListener("click", downloadPDF);

                //donwload pdf from original canvas
                function downloadPDF() {
                var canvas = document.querySelector('#MaterielPieGraph');
                    //creates image
                    var canvasImg = canvas.toDataURL("image/jpeg", 1.0);
                
                    //creates PDF from img
                    var doc = new jsPDF('landscape');
                    doc.setFontSize(20);
                    doc.text(15, 15, "Cool Chart");
                    doc.addImage(canvasImg, 'JPEG', 10, 10, 280, 150 );
                    doc.save('graphique.pdf');
                }

                //add event listener to button
                document.getElementById('download1-pdf').addEventListener("click", downloadPDF);

                //donwload pdf from original canvas
                function downloadPDF() {
                var canvas = document.querySelector('#UserDoughnutGraph');
                    //creates image
                    var canvasImg = canvas.toDataURL("image/jpeg", 1.0);
                
                    //creates PDF from img
                    var doc = new jsPDF('landscape');
                    doc.setFontSize(20);
                    doc.text(15, 15, "Cool Chart");
                    doc.addImage(canvasImg, 'JPEG', 10, 10, 280, 150 );
                    doc.save('graphique-test.pdf');
                }
            </script>
        </div>
    </body>
</html>


