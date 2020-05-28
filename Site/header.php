<!-- Le header contient le logo (qui permet de retourner a l'index) et un menu de navigation -->
	<header>
	    <div class='logo'>
	        <a href='index.php'><img src='data/img/iconne_site.png' alt='iconne_site' height='100' class= 'logo_img'></a>
	    </div>
	    <nav>
	        <ul>
				<li><a href='boutique_client.php'>Boutique</a></li>
	        <?php
	        if(!isset($_SESSION["pseudo"])) {
	            echo "<br>Vous n'êtes pas connecté(e)<br>";
	            echo "<li><a href='inscription.php'>S'inscrire</a></li>";
	            echo "<li><a href='connexion.php'>Se connecter</a></li>";
	        } else {
	            echo "<li><a href='creator.php'>Créer son T-shirt personnalisé</a></li>";
	            if($_SESSION["statut"] == 1){
	                echo "<li><a href='affichage_admin.php'>Affichage boutique (admin)</a></li>";
	                echo "<li><a href='ajout_boutique.php'>Ajout boutique (admin)</a></li>";
	            }
	            echo "<li><a href='logout.php'>Se deconnecter</a></li>";
	        }
	        ?>
	        </ul>
	    </nav>
	</header>