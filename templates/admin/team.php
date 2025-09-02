<?php
$team = isset($_POST['team']) ? htmlspecialchars($_POST['team']) : null;
$logo = isset($_POST['logo']) ? htmlspecialchars($_POST['logo']) : null;

if ($team && $logo) {
    $update = $db->prepare('UPDATE easybet_teams SET team = ?, logo = ? WHERE id = ?');
    $update->execute([$team, $logo, $niv3]);
    
    Redirection($Url.'/admin');
}

// $Teams = $db->prepare('SELECT * FROM easybet_teams WHERE id = ?');
$Teams = $db->query('SELECT * FROM easybet_teams WHERE id = '.$niv3);
//$Teams->execute([$niv3]);
$Team = $Teams->fetch();
?>

<div class="team-form">
    <form method="POST">
        <input type="text" name="team" value="<?=$Team['team'];?>" />
        <input type="text" name="logo" value="<?=$Team['logo'];?>" />
        <input type="submit" value="OK" />
    </form>
</div>