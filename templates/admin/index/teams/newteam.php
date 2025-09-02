<?
$team = isset($_POST['team']) ? htmlspecialchars($_POST['team']) : null;

if ($team) {
    $Teams = $db->prepare('SELECT * FROM easybet_teams WHERE team = ?');
    $Teams->execute([$team]);
    $nbTeams = $Teams->rowCount();

    if ($nbTeams==0) {
        if (is_uploaded_file(($_FILES['logo']['tmp_name']))) {
            $file = $_FILES['logo']['name'];
            move_uploaded_file($_FILES['logo']['tmp_name'], './images/teams/'.$file);
        }
        $insert = $db->prepare('INSERT INTO easybet_teams (id, team, logo) VALUES ("", ?, ?)');
        $insert->execute([$team, $file]);
    }
    else $Retour = '<p>Cette équipe existe déjà !</p>';
}
?>

<div class="team">
    <?=$Retour;?>
    <form method="post" enctype="multipart/form-data">
        <input type="text" name="team" placeholder="Ajouter une équipe" />
        <label for="logo">Logo</label>
        <input type="file" name="logo" id="logo" placeholder="Logo" style="display: none;" />
        <input type="submit" value="OK" />
    </form>
</div>