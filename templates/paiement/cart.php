<?
class PaypalPayment {
	public function ui (Cart $cart): string {
		$clientId = PAYPAL_ID;
		$total = $cart->getTotal() / 100;
		
		return <<<HTML
			<script src="https://www.paypal.com/sdk/js?client-id={$clientId}&currency=EUR"></script>

			<div id="paypal-button-container"></div>

			<script>
			  paypal.Buttons({
				createOrder() {
				  return fetch("/my-server/create-paypal-order", {
					method: "POST",
					headers: {
					  "Content-Type": "application/json",
					},

					body: JSON.stringify({
					  cart: [
						{
						  quantity: 1,
						  value: <?=$amount;?>,
						},
					  ],
					}),
				  })
				  .then((response) => response.json())
				  .then((order) => order.id);
				},

				onApprove(data) {
				  return fetch("/my-server/capture-paypal-order", {
					method: "POST",
					headers: {
					  "Content-Type": "application/json",
					},
					body: JSON.stringify({
					  orderID: data.orderID
					})
				  })
				  .then((response) => response.json())
				  .then((orderData) => {
					console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
					const transaction = orderData.purchase_units[0].payments.captures[0];
					alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
				  });
				}
			  }).render('#paypal-button-container');
			</script>	
	}
}
?>