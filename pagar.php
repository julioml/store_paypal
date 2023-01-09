<?php
    include 'global/config.php';
    include 'global/conexion.php';
    include 'carrito.php';
    include 'templates/cabecera.php';

?>

<?php
    if($_POST){
        $total = 0;
        $SID = session_id();
        $Correo = $_POST['email'];
        foreach ($_SESSION['CARRITO'] as $indice => $producto) {
            $total=$total+($producto['PRECIO']*$producto['CANTIDAD']);
        }
        $sentencia = $pdo->prepare("INSERT INTO `tblventas` (`ID`, `ClaveTransaccion`, `PaypalDatos`, `Fecha`, `Correo`, `Total`, `status`) VALUES 
                                    (NULL, :ClaveTransaccion, '', NOW(), :Correo, :Total, 'pendiente');");
        $sentencia->bindParam(":ClaveTransaccion", $SID);
        $sentencia->bindParam(":Correo", $Correo);
        $sentencia->bindParam(":Total", $total);
        $sentencia->execute();
        $idVenta=$pdo->lastInsertId();
        foreach ($_SESSION['CARRITO'] as $indice => $producto) {
            $sentencia = $pdo->prepare("INSERT INTO `tbldetalleventa` (`ID`, `IDVENTA`, `IDPRODUCTO`, `PRECIOUNITARIO`, `CANTIDAD`, `DESCARGADO`) 
                    VALUES (NULL, :IDVENTA, :IDPRODUCTO, :PRECIOUNITARIO, :CANTIDAD, 0)");
            $sentencia->bindParam(":IDVENTA", $idVenta);
            $sentencia->bindParam(":IDPRODUCTO", $producto['ID']);
            $sentencia->bindParam(":PRECIOUNITARIO", $producto['PRECIO']);
            $sentencia->bindParam(":CANTIDAD", $producto['CANTIDAD']);
            $sentencia->execute();
        }
        echo "<h3>".$total."</h3>";
    }
?>

<div class="jumbotron text-center">
    <h1 class="display-4 text-center">¡Paso Final!</h1>
    <hr class="my-4">
    <p class="lead">Estas a punto de pagar con PayPal la cantidad de:
        <h4>$ <?php echo number_format($total, 2); ?></h4>
    </p>
    <div id="paypal-button-container"></div>
    <p>Los productos podrán ser descargados una vez que se procese el pago</p>
    <strong>(Si tuviera algunas dudas, contactarse al correo: atencion_clienteBOOK@gmail.com)</strong>
</div>


<script src="https://www.paypal.com/sdk/js?client-id=AenYNClyuRnl9GmeZlLhmDyypxqHxUSFw3iLluMBUve4Rl8wNYBmpUsYqDMLaPuZVSfKgibq0P-xCU-R&currency=USD"></script>
<script>
    paypal.Buttons({
        style: {
            layout: 'vertical',
            color:  'gold',
            shape:  'rect',
            label:  'pay',
        },  
      // Sets up the transaction when a payment button is clicked
      createOrder: (data, actions) => {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: '<?php echo $total;?>' // Can also reference a variable or function
            }
          }],
          items: [{
             name: "First Product Name", /* Shows within upper-right dropdown during payment approval */
             description: "Optional descriptive text..", /* Item details will also be in the completed paypal.com transaction view */
             unit_amount: {
               currency_code: "USD",
               value: "50"
             },
             quantity: "2"
           },
         ]
        });
      },
      // Finalize the transaction after payer approval
      onApprove: (data, actions) => {
        return actions.order.capture().then(function(orderData) {
          // Successful capture! For dev/demo purposes:
          console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
          const transaction = orderData.purchase_units[0].payments.captures[0];
          alert(`Transaction ${transaction.status}: ${transaction.id}\n\nSee console for all available details`);
          // When ready to go live, remove the alert and show a success message within this page. For example:
          // const element = document.getElementById('paypal-button-container');
          // element.innerHTML = '<h3>Thank you for your payment!</h3>';
          // Or go to another URL:  
          //console.log(transaction)
          //actions.redirect('verificador.php');
          const ventaid = orderData.id;
          const paymentid = orderData.purchase_units[0].payments.captures[0].id;
          const payerID = orderData.payer.payer_id;
          //console.log(payerID);
          window.location="verificador.php?id="+ventaid+"&paymentID="+paymentid+"&payerID="+payerID;
        });
      }
    }).render('#paypal-button-container');
  </script>


<?php
    include 'templates/pie.php';
?>