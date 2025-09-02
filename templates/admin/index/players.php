<?php

  ini_set('display_errors', 1);
  ini_set('display_startup_errors', 1);
  error_reporting(E_ALL);

  $Players = $db->query('SELECT id, pseudo, points FROM easybet_users WHERE points > 0 ORDER BY points DESC');
  $Players = $Players->fetchAll(PDO::FETCH_ASSOC);

  $Inscrits = $db->query('SELECT id, pseudo, points FROM easybet_users ORDER BY pseudo ASC');
  $Inscrits = $Inscrits->fetchAll(PDO::FETCH_ASSOC);

  $Events = $db->query('SELECT * FROM easybet_events ORDER BY id DESC LIMIT 1');
  $Events = $Events->fetch(PDO::FETCH_ASSOC);

  $Gamers = $db->query('SELECT eu.id, eu.pseudo, eg.event_points FROM easybet_gamers AS eg, easybet_users AS eu WHERE eu.id = eg.id_user ORDER BY event_points DESC');
  $Gamers = $Gamers->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="players">
  <p>
      <a href="#" id="btnInscrit">Inscrits</a>
      - <a href="#" id="btnOrdinaire">Ordinaire</a>
      - <a href="#" id="btnEvenement">Evénements</a>
      - <a href="<?=$Url;?>/admin/publications">Publications</a>
  </p>

  <ol id="classement"></ol>

</div>

<script>

  const user = <?php echo json_encode($Players); ?>;
  const inscrit = <?php echo json_encode($Inscrits); ?>;
  const gamer = <?php echo json_encode($Gamers); ?>;
  const event = <?php echo json_encode($Events); ?>;
  const Url = "<?= $Url ?>";
  const page = "<?= $page ?>";

  document.getElementById('btnInscrit').addEventListener('click', function (e) {
      e.preventDefault();
      inscrits()
  });

  document.getElementById('btnOrdinaire').addEventListener('click', function (e) {
      e.preventDefault();
      ordinaire();
  });

  document.getElementById('btnEvenement').addEventListener('click', function (e) {
      e.preventDefault();
      evenement();
  });
  
  const classement = document.getElementById('classement');

  function ordinaire() {

    classement.innerHTML = '<p>Classement ordinaire</p><br />';
    user.forEach(Player => {
        classement.innerHTML += `
            <li>
              <a href="${Url}/${page}/player/${Player.id}"><span>${Player.pseudo}</span><strong>${Player.points}</strong></a>
            </li>
        `;
    });
    classement.innerHTML += `<p>Non validés: <strong>${user.length}</p>`;
  }

  function evenement() {
    if(event && gamer) {

      classement.innerHTML = '<p>Classement événement</p><br />';
      gamer.forEach(Player => {
          classement.innerHTML += `
              <li>
                <a href="${Url}/${page}/player/${Player.id}"><span>${Player.pseudo}</span><strong>${Player.event_points}</strong></a>
              </li>
          `;
      });
    }
    else if (event && !gamer) {
      classement.innerHTML = "<p>Pas de participants</p>";
    }
    else {
      classement.innerHTML = "<p>Pas d'événements en cours</p>";
    }
  }

  function inscrits() {
    classement.innerHTML = '<p>Classement des inscrits</p><br />';
    inscrit.forEach(Player => {
      classement.innerHTML += `
        <li>
          <a href="${Url}/${page}/player/${Player.id}"><span>${Player.pseudo}</span><!--<strong>${Player.points}</strong>--></a>
        </li>
      `;
    });
  }

  ordinaire(); // Load default
</script>
