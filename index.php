<?php
    include 'global/config.php';
    include 'global/conexion.php';
    include 'carrito.php';
    include 'templates/cabecera.php';
?>
        <br/>
        <?php if ($mensaje!=""): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $mensaje; ?>
            <a href="mostrarCarrito.php" class="badge badge-success">Ver carrito</a>
        </div>
        <?php endif; ?>
        <div class="row">
            <?php
                $sentencia = $pdo->prepare("SELECT * FROM `tblproductos`");
                $sentencia->execute();
                $listaProductos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
                //print_r($listaProductos);
            ?>

            <?php foreach($listaProductos as $producto): ?>

            <div class="col-3">
                <div class="card">
                    <img 
                        class="card-img-top" 
                        src="<?php echo $producto['Imagen']; ?>" 
                        alt="<?php echo $producto['Nombre'] ?>" 
                        title="<?php echo $producto['Nombre'] ?>" 
                        data-toggle="popover"
                        data-trigger="hover"
                        data-content="<?php echo $producto['Descripcion']?>"
                        height="317px"
                        >
                    <div class="card-body">
                        <span><?php echo $producto['Nombre'] ?></span>
                        <h5 class="card-title"><?php echo $producto['Precio'] ?></h5>
                        <p class="card-text">Descripción</p>
                        <form action="" method="post">
                            <input type="hidden" name="id" id="id" value="<?php echo openssl_encrypt($producto['ID'], COD, KEY); ?>">
                            <input type="hidden" name="nombre" id="nombre" value="<?php echo openssl_encrypt($producto['Nombre'], COD, KEY); ?>">
                            <input type="hidden" name="precio" id="precio" value="<?php echo openssl_encrypt($producto['Precio'], COD, KEY); ?>">
                            <input type="hidden" name="cantidad" id="cantidad" value="<?php echo openssl_encrypt(1, COD, KEY); ?>">
                            <button class="btn btn-primary" type="submit" name="btnAccion" value="Agregar">Agregar al carrito</button>
                        </form>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>
            
            

        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>

    <script>
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
    </script>
<?php
    include 'templates/pie.php';
?>
