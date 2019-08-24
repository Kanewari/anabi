<?php
    session_start();
    require('bdd.php');
    if(!empty($_POST['edition']))
    {
        header('Location: edition_profil.php');
    }
    $requete_amis = $bdd -> prepare('SELECT * FROM demande_amis WHERE accept = ? AND pseudo1 = ? OR accept = ? AND pseudo2 = ?');
    $requete_amis -> execute(array(1 ,$_SESSION['pseudo'], 1, $_SESSION['pseudo']));
    $nb_amis = $requete_amis -> rowCount();

    $requete_lvl = $bdd -> prepare('SELECT * FROM membres WHERE pseudo = ?');
    $requete_lvl -> execute(array($_SESSION['pseudo']));
    $lvl = $requete_lvl -> fetch();

    $requete_avatar = $bdd -> prepare('SELECT * FROM membres WHERE id = ?');
    $requete_avatar -> execute(array($_SESSION['id']));
    $avatar = $requete_avatar -> fetch();

    if($nb_amis == 1)
    {
        $_amis = ' ami';
    }
    else
    {
        $_amis = ' amis';
    }

    if(isset($_SESSION['id']) && $_GET['id'] == $_SESSION['id'])
    {
?>
<!DOCTYPE html>
<html>
<head>
    <?php include('head.php');?>
    <link rel="stylesheet" href="css.css" />
    <title><?php echo $_SESSION['pseudo']; ?></title>
</head>
<body>
        <?php include('menuPHP.php'); ?>
        <?php 
            $requete_miniature = $bdd -> prepare('SELECT * FROM membres WHERE id = ?');
            $requete_miniature -> execute(array($_SESSION['id']));
            $miniature = $requete_miniature -> fetch();
        ?>
        <div class="div1profil">
            <div class="div2profil"></div>
                            <div class="div3profil">
                            
                                <img src="<?php echo $_avatar; ?>" class="img1profil">
                            </form>
                                <span class="span1profil">
                               <table>
                                    <tr>
                                        <td class="td1profil">
                                            <?php echo $_SESSION['pseudo'];?>
                                            </span>
                                        </td>
                                        <td>
                                        <form method="POST">
                                    <input name="edition" type="submit" class="input1profil" value="Modifier le profil">
                                </form>
                                </td>
                                    </tr>
                                    <tr>
                                        <td><br>
                                        <span class="span2profil">
                                            <?php echo 'Niveau <span class="gras">'.$lvl['lvl'].'</span>'; ?>
                                            </span>
                                        <span class="span3profil">
                                                <?php echo '<span class="gras"><a href="amis.php?id='.$_SESSION['id'].'&pseudo='.$_SESSION['pseudo'].'"></span><span class="white"><b>'.$nb_amis.'</b>'.$_amis.'</span></a>'; ?>
                                            </span>
                                        </td>
                                        </tr>
                                    <tr>
                                        <td>
                                            <?php 
                                                $requete_bio = $bdd -> prepare('SELECT * FROM membres WHERE id = ?');
                                                $requete_bio -> execute(array($_SESSION['id']));
                                                $bio = $requete_bio -> fetch();
                                                echo '<p class="p1profil">'.$bio['bio'].'</p>';
                                            ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                <?php
                }
                else
                {
                    echo '<h1 style="color: red;"> Erreur dans l\'url !</h1>';
                }
                ?>
            </div>
        </div>
            
</body>
</html>
