<?
$date = isset($_POST['date']) ? htmlspecialchars($_POST['date']) : null;
$heure = isset($_POST['heure']) ? htmlspecialchars($_POST['heure']) : null;
$categorie = isset($_POST['categorie']) ? intval($_POST['categorie']) : null;
$domicile = isset($_POST['domicile']) ? intval($_POST['domicile']) : null;
$visiteur = isset($_POST['visiteur']) ? intval($_POST['visiteur']) : null;
$nul = isset($_POST['nul']) ? 1 : 0 ;
$competition = isset($_POST['competition']) ? htmlspecialchars($_POST['competition']) : null;
$end = 0;

if ($date && $heure && $domicile && $visiteur) {
    $date =  $date.' '.$heure.':00';

    $sql = 'INSERT INTO easybet_games 
        (id, date, id_categorie, id_domicile, id_visiteur, nul, competition, end) 
        VALUES 
        ("", ?, ?, ?, ?, ?, ?, ?) 
    ';
    $Retour = $sql;
    $insert = $db->prepare($sql);
    $insert->execute([$date, $categorie, $domicile, $visiteur, $nul, $competition, $end]);
    
    Redirection ($Url.'/admin');
}

?>
<div class="game">
    <?=$Retour;?>
    <form method="post">
        <input type="date" name="date" placeholder="date" />
        <input type="checkbox" name="nul" checked="checked" />
        <input type="text" name="heure" placeholder="heure" />
        <select name="categorie">
            <option value="">Catégorie</option>
            <?
                $Teams = $db->query('SELECT * FROM easybet_categorie');
                while ($Team = $Teams->fetch()) {
                    if ($Team['categorie']=='Football') echo '<option value="'.$Team['id'].'" selected="selected">'.$Team['categorie'].'</option>';
                    else echo '<option value="'.$Team['id'].'">'.$Team['categorie'].'</option>';
                }
            ?>
        </select>
        <select name="domicile">
            <option value="">Domicile</option>
            <?
                $Teams = $db->query('SELECT * FROM easybet_teams ORDER BY team');
                while ($Team = $Teams->fetch()) {
                    echo '<option value="'.$Team['id'].'">'.$Team['team'].'</option>';
                }
            ?>
        </select>
        <select name="visiteur">
            <option value="">Visiteur</option>
            <?
                $Teams = $db->query('SELECT * FROM easybet_teams ORDER BY team');
                while ($Team = $Teams->fetch()) {
                    echo '<option value="'.$Team['id'].'">'.$Team['team'].'</option>';
                }
            ?>
        </select>
        <input type="text" name="competition" placeholder="Compétition" />
        <input type="submit" value="ok" />
    </form>
</div>