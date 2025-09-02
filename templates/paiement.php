<?
$amount = isset($_POST['amount']) ? intval($_POST['amount']) : null;
$amount = number_format($amount, 2, '.', ' ');
$credits = array_search($amount, $Formules);

// $amount = '0.01';

//Title ('Paiement - '.$Site['nom']);
?>
<!DOCTYPE html>
<html Lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<title>Document</title>
</head>
<body>
<div id="paiement">
    <div class="recap">
        <p>Vous avez sélectionné la formule:</p>
        <?
            
            if ($credits>1) $cr = 'crédits'; else $cr = 'crédit';
            echo '<p class="main"><strong>'.$credits.'&nbsp;'.$cr.'</strong> pour <strong>'.number_format($amount,2,',',' ').'&nbsp;&euro;</strong></p>';
        ?>
        <p><a href="<?=$Url;?>/credits">Changer de formule</a></p>
    </div>

    <div id="paypal-payment-button"></div>
</div>
<script src="https://www.paypal.com/sdk/js?client-id=ASAe-iAiA5wt67w8nha52EEM2_qyTeIpI-e3hhHAnj-upR6w1hOiggO_8r-NPvCnvjjTpC6SmAqKTxhy&currency=EUR"></script>
<script>
paypal.Buttons({
    style : {
        color: 'blue'
    },
    createOrder: function(data, actions) {
        return actions.order.create({
            purchase_units:[{
              amount: {
                  value:'<?=$amount;?>'
              }
            }]
        })
    },
    onApprove: function(data, actions) {
        // This function captures the funds from the transaction.
        return actions.order.capture().then(function(details) {
            console.log(details)
          window.location.replace("<?=$Url.'/success/'.$credits?>")
        })
    }
}).render('#paypal-payment-button');
</script>
<body>
</html>