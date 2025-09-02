<?
// https://www.youtube.com/watch?v=uC3hbrp-nQ0

if ($_SESSION['login']!=1) {
	Redirection($Url);
	die;
}

$choice = isset($_POST['choice']) ? htmlspecialchars($_POST['choice']) : null;
$amount = isset($_POST['amount']) ? intval($_POST['amount']) : null;

if ($choice && $amount) {
    echo $choice.': '.$amount;
    die();
}

?>

<div class="credits">

    <div class="credit">
        <p class="head"><strong>CRÉDITS DISPONIBLES</strong></p>
        <p class="number"><?=intval($User['credits']);?></p>
    </div>

    <h2 class="title"><strong>RECHARGER</strong></h2>

    <?
            foreach ($Formules as $credits=>$price) {
                $gratis = intval($credits - $price);
				
				$icone = null;

                echo '<div class="credit charge" id="'.strtolower($name).'" data="'.$price.'">';
                    echo '<p class="head"><strong>'.$credits.' '.(($credits>1) ? 'CRÉDITS' : 'CRÉDIT').'</strong></p>';
                    echo '<p class="number">'.number_format($price, 2, ',', ' ').'&nbsp;&euro;</p>';
                    if ($gratis>0) echo '<p class="note">('.$gratis.' crédits offerts)</p>';
                echo '</div>';
            }
        ?>
        </div>

        <form method="POST" action="<?=$Url;?>/paiement">
            <input type="text" class="f" name="choice" hidden />
            <input type="number" class="a" name="amount" hidden />
        </form>
    </div>
</div>

<script>
    $('div.charge').click(function() {
        var f = $(this).attr('id');
        var a = $(this).attr('data');
        $('input.f').val(f);
        $('input.a').val(a);

        $('form').submit();
    });
</script>