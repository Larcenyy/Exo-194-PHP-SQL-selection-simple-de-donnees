<?php

class DbPDO
{
    private static string $server = 'localhost';
    private static string $username = 'root';
    private static string $password = '';
    private static string $database = 'test';
    private static ?PDO $db = null;

    public static function connect(): ?PDO {
        if (self::$db == null){
            try {
                self::$db = new PDO("mysql:host=".self::$server.";dbname=".self::$database, self::$username, self::$password);
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$db->beginTransaction();

                $server = self::$db->prepare("SELECT * from user ORDER BY id ASC");

                $test = $server->execute();


                if ($test){
                    echo '<div class="test">';
                    foreach ($server->fetchAll() as $user){
                        echo '<p style="margin: 0;">Utilisateur Id: ' . $user["id"]  .$user["nom"] . " " . $user['prenom'] . " " . $user['mail'] . "</p>";
                    }
//                    foreach ($server->fetchAll() as $user){
//                        echo '<p style="margin: 0;">Utilisateur: ' . $user["nom"] . " " . $user['prenom'] . "</p>";
//                    }
                    echo '</div>';
                }
                else{
                    echo "Une erreur s'est produite..";
                }
            }
            catch (PDOException $e) {
                echo "Erreur de la connexion à la dn : " . $e->getMessage();
                self::$db->rollBack(); // On restaure les anciens données en cas d'erreur
            }
        }
        return self::$db;
    }
}

?>


<div class="user-info">
    <?php if (isset($_GET["rules"]) && $_GET["rules"] == 1): ?>

    <?php else: ?>
    <?php endif; ?>
</div>
