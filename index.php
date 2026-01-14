<?php

$categorieSelectionnee = isset($_GET['categorie']) ? $_GET['categorie'] : null;

// ÉTAPE 1: Créer un tableau d'articles
$articles = array(
  // Article 1
  array(
    "id" => 1,
    "titre" => "Mon premier article sur le PHP",
    "contenu" => "Le PHP est un langage puissant pour le web. Aujourd'hui, je
vais vous montrer comment afficher des données dynamiquement.",
    "auteur" => "Alice",
    "date" => "2025-01-05",
    "categorie" => "Tutoriels"
  ),
  // Article 2
  array(
    "id" => 2,
    "titre" => "Boucles et Fonctions",
    "contenu" => "Les boucles permettent de traiter plusieurs données sans
répéter le code. Les fonctions organisent notre code.",
    "auteur" => "Bob",
    "date" => "2025-01-08",
    "categorie" => "ressources"

  ),

  // Article 3
  array(
    "id" => 3,
    "titre" => "HTML et Bootstrap",
    "contenu" => "Bootstrap rend le design facile et responsif. Pas besoin de
CSS complexe pour créer un site professionnel.",
    "auteur" => "Charlie",
    "date" => "2025-01-10",
    "categorie" => "Actualites"
  ),

  // Article 4
  array(
    "id" => 4,
    "titre" => "Fonction avec Return",
    "contenu" => "Une fonction peut retourner une valeur pour l'utiliser
ailleurs dans le code. Très utile pour les calculs.",
    "auteur" => "Alice",
    "date" => "2025-01-12",
    "categorie" => "Tutoriels"
  )
);



?>



<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mon Blog</title>

  <!-- Bootstrap CSS depuis CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="style.css">
</head>

<body>

  <!-- Navbar Bootstrap -->
  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
      <span class="navbar-brand">Mon Blog</span>
    </div>
  </nav>

  <!-- Contenu principal -->
  <div class="container mt-5">
    <h1>Mon Blog</h1>
    <p>Bienvenue sur mon blog. Découvrez mes articles.</p>

    <!-- Section: Articles -->
    <h2 class="mt-5">Mes Articles</h2>

    <!-- Grille d'articles -->
    <div class="row g-3 mt-3" id="conteneurArticles">




      <?php

      function afficherArticle($article)
      {
        echo '<div class="col-md-4">';
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<span style="font-size: small; color: gray;">' . htmlspecialchars($article["id"]) . '</span>';
        echo '<h5 class="card-title">' . htmlspecialchars($article["titre"]) . '</h5>';
        echo '<p class="card-text">' . htmlspecialchars($article["contenu"]) . '</p>';
        echo '<a href="#" class="btn btn-primary">Lire plus</a>';
        echo '</div>';
        echo '</div>';
        echo '</div>';
      }


      function obtenirArticlesParAuteur($articles, $auteur)
      {
        return array_filter($articles, function ($article) use ($auteur) {
          return $article['auteur'] === $auteur;
        });
      }



      // FONCTION : Compter le nombre d'articles
      function compterArticles($articles)
      {
        return count($articles);
      }
      // FONCTION : Obtenir un article par ID
      function obtenirArticleParId($articles, $id)
      {
        foreach ($articles as $article) {
          if ($article["id"] === $id) {
            return $article;
          }
        }
        return null;
      }

      // foreach ($articles as $article) {
      //   afficherArticle($article);
      // }
      

      //  FONCTION : Triez les Articles par Date Decroissante
      function sortByDate($articles)
      {
        usort($articles, function ($a, $b) {
          return strtotime($b['date']) - strtotime($a['date']);
        });

        return $articles;
      }

      // Trier les articles
      $trierArticles = sortByDate($articles);

      // Limiter à 5 articles
      $limitesArticles = array_slice($trierArticles, 0, 4);


      // Afficher les articles
      // foreach ($limitesArticles as $article) {
      //   echo "<h2>{$article['titre']}</h2>";
      //   echo "<p><strong>Auteur :</strong> {$article['auteur']}</p>";
      //   echo "<p><strong>Date :</strong> {$article['date']}</p>";
      //   echo "<p>{$article['contenu']}</p>";
      //   echo "<hr>";
      // }
      
      //       Partie 7 de L'exercice TP" 
      
      // //    Accedez a la categories
//       // echo " voici la premier Article";
//       // echo $articles[0]['categorie'];
      

      $categories = getCategoriesList($articles);
      ?>
      <div class="mb-4">
        <a href="index.php" class="btn btn-secondary me-2">Tous</a>

        <?php foreach ($categories as $cat): ?>
          <a href="?categorie=<?= urlencode($cat) ?>" class="btn btn-outline-primary me-2">
            <?= htmlspecialchars($cat) ?>
          </a>
        <?php endforeach; ?>
      </div>



      <?php
      $articlesFiltres = filterByCategory($articles, $categorieSelectionnee);

      echo "<p><strong>" . count($articlesFiltres) . "</strong> article(s) trouvé(s)</p>";

      foreach ($articlesFiltres as $article) {
        afficherArticle($article);
      }
      ?>




      // <!-- Partie 8 , 1.Creer une fonction Pour lister les categories Uniques -->
      <?php
      function getCategoriesList($articles)
      {
        $categories = [];

        foreach ($articles as $article) {
          if (!in_array($article['categorie'], $categories)) {
            $categories[] = $article['categorie'];
          }
        }

        return $categories;
      }

      // 2. Test du fonction en utilisant le print_r pour le formatage d'affichage
      echo "test du tableau categorie";
      echo "
      <pre>";
      print_r(getCategoriesList($articles));
      echo "</pre>";

      function filterByCategory($articles, $categorie)
      {
        if ($categorie === null) {
          return $articles;
        }

        $resultat = [];

        foreach ($articles as $article) {
          if ($article['categorie'] === $categorie) {
            $resultat[] = $article;
          }
        }

        return $resultat;
      }


      ?>






      <!-- Articles cachés (montrés au clic du bouton) -->
      <div class="articles-cachés" id="articlesCachés">

        <!-- Article 4 -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">JavaScript Basics</h5>
              <p class="card-text">JavaScript rend votre site interactif. Écoutez les clics, changez le contenu.</p>
              <a href="#" class="btn btn-primary">Lire plus</a>
            </div>
          </div>
        </div>

        <!-- Article 5 -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Bootstrap Composants</h5>
              <p class="card-text">Bootstrap nous donne des cartes, navbars, boutons, et bien plus. Réutilisables.</p>
              <a href="#" class="btn btn-primary">Lire plus</a>
            </div>
          </div>
        </div>

        <!-- Article 6 -->
        <div class="col-md-4">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Responsive Design</h5>
              <p class="card-text">Votre blog doit s'adapter aux téléphones. CSS Media Queries le font automatiquement.
              </p>
              <a href="#" class="btn btn-primary">Lire plus</a>
            </div>
          </div>
        </div>

      </div>

    </div>

    <!-- Bouton pour charger plus d'articles -->
    <div class="mt-5 text-center">
      <button id="boutChargerPlus" class="btn btn-success btn-lg">Charger plus d'articles</button>
    </div>

  </div>

  <script src="script.js"></script>
</body>

</html>