<?php
	/* Paramètre de la Base de Données */
	$host = 'localhost';
	$user = 'root';
	$pass = 'root';
	$db = 'infotools';
	$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

//#region GRAPHIQUE 1
	$data1 = '';
	$data2 = '';

	//query to get data from the table
	$sql = "SELECT COUNT(produit.IdProd) as NbProd, COUNT(categorie.NumCat) as NbCat, LibCat FROM categorie INNER JOIN produit ON categorie.NumCat = produit.NumCat GROUP BY LibCat";
    $result = mysqli_query($mysqli, $sql);

	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {
        // $Stat = $row['NbCat'] / $row['NbProd'] *100;
		$data1 = $data1 . '"'. $row['LibCat'].'",';
        $data2 = $data2 . '"'. $row['NbProd'].'",';
	}

	$data1 = trim($data1,",");
// #endregion

//#region GRAPHIQUE 2
    $role = '';
	$utilisateur = '';

	//query to get data from the table
	$sql = "SELECT COUNT(IdUti) as NbUti, role.LibRole FROM utilisateur INNER JOIN role ON utilisateur.NumRole = role.NumRole GROUP BY role.LibRole";
    $result = mysqli_query($mysqli, $sql);

	//loop through the returned data
	while ($row = mysqli_fetch_array($result)) {
        // $Stat = $row['NbCat'] / $row['NbProd'] *100;
		$role = $role . '"'. $row['LibRole'].'",';
        $utilisateur = $utilisateur . '"'. $row['NbUti'].'",';
	}
#endregion
	$data1 = trim($data1,",");
	if (!$result) {
		printf("Error: %s\n", mysqli_error($mysqli));
		exit();
	}
?>

<!DOCTYPE html>
<html>
	<head>
    	<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.min.js"></script>
		<title>Graphique de InfoTools</title>

		<style type="text/css">			
			body{
				font-family: Arial;
			    margin: 80px 100px 10px 100px;
			    padding: 0;
			    color: white;
			    text-align: center;
			    background: #555652;
			}

			.container {
				color: #E8E9EB;
				background: #222;
				border: #555652 1px solid;
				padding: 10px;
			}
		</style>

	</head>

	<body>	   
	    <div class="container">	
	    <h1>Graphiques InfoTools</h1>       
			<canvas id="graph1" style="width: 100%; height: 65vh; background: #222; border: 1px solid #555652; margin-top: 10px; margin-bottom: 20px;"></canvas>
            <canvas id="graph2" style="width: 100%; height: 65vh; background: #222; border: 1px solid #555652; margin-top: 10px;"></canvas>

			<script>
// #region GRAPHIQUE 1
				var ctx = document.getElementById("graph1").getContext('2d');
    			var myChart = new Chart(ctx, {
        		type: 'pie',
		        data: {
		            labels: [<?php echo $data1; ?>],
		            datasets: 
		            [{
		                data: [<?php echo $data2; ?>],
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
		            tooltips:{mode: 'index'},
		            legend:{display: true, position: 'top', labels: {display: true, fontColor: 'rgb(255,255,255)', fontSize: 16}},
                    title:{display: true, text:"Nombre de produits par catégories", fontColor :'rgb(255,255,255)', fontSize: 30}
		        }
		    });
// #endregion

// #region GRAPHIQUE 2
                var ctx = document.getElementById("graph2").getContext('2d');
    			var myChart = new Chart(ctx, {
        		type: 'doughnut',
		        data: {
		            labels: [<?php echo $role; ?>],
		            datasets: 
		            [{
		                data: [<?php echo $utilisateur; ?>],
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
		            scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
		            tooltips:{mode: 'index'},
		            legend:{display: true, position: 'top', labels: {display: true, fontColor: 'rgb(255,255,255)', fontSize: 16}},
                    title:{display: true, text:"Nombre d'utilisateurs par Role", fontColor :'rgb(255,255,255)', fontSize: 30}
		        }
		    });
// #endregion
// #region GRAPHIQUE 3
var ctx = document.getElementById("graph2").getContext('2d');
    			var myChart = new Chart(ctx, {
        		type: 'doughnut',
		        data: {
		            labels: [<?php echo $role; ?>],
		            datasets: 
		            [{
		                data: [<?php echo $utilisateur; ?>],
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
		            scales: {scales:{yAxes: [{beginAtZero: false}], xAxes: [{autoskip: true, maxTicketsLimit: 20}]}},
		            tooltips:{mode: 'index'},
		            legend:{display: true, position: 'top', labels: {display: true, fontColor: 'rgb(255,255,255)', fontSize: 16}},
                    title:{display: true, text:"Nombre d'utilisateurs par Role", fontColor :'rgb(255,255,255)', fontSize: 30}
		        }
		    });
// #endregion

			</script>
	    </div>
	    
	</body>
</html>