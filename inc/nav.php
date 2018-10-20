			<div class="menu-wrap">
				<div id="mobnav-btn">Menu <i class="fa fa-bars"></i></div>
				<ul class="sf-menu">
					<li>
						<a href="../index.php">Home</a>
					</li>
					<li>
						<a href="#">Menus</a>
						<div class="mobnav-subarrow"><i class="fa fa-plus"></i></div>
						<ul>
                            
						<?php
							$catsql = "SELECT * FROM category";
							$catres = mysqli_query($connection, $catsql);
							
                            while($catr = mysqli_fetch_assoc($catres)) {
						 ?>
				                <li><a href="menu.php?id=<?php echo $catr['id']; ?>"><?php echo $catr['name']; ?></a></li>
						<?php } ?>
						</ul>
					</li>
					<li>
						<a href="../contact.php">Contact</a>
					</li>
                    <li>
						<a href="#">My Account</a>
						<div class="mobnav-subarrow"><i class="fa fa-plus"></i></div>
						<ul>
							<li><a href="../my-account.php">My Orders</a></li>
							<li><a href="../edit-address.php">Account Info</a></li>
                            <li><a href="../login.php"> Login</a></li>
							<li><a href="../logout.php">Logout</a></li>
                            
						</ul>
					</li>
				</ul>
                
				<div class="header-xtra">
				
                    <?php $cart = $_SESSION['cart']; ?>
					
                    <div class="s-cart">
						
                        <div class="sc-ico"><i class="fa fa-shopping-cart"></i><em><?php
								echo count($cart); ?></em>
                        </div>

						<div class="cart-info">
							<small>You have <em class="highlight"><?php
								echo count($cart); ?> item(s)</em> in your shopping cart
                            </small>
							
                            <br>
							<br>
							
                            <?php
				
								$total = 0;
				
                                foreach ($cart as $key => $value) {
									
                                    $navcartsql = "SELECT * 
                                                   FROM products 
                                                   WHERE id=$key";
                                    
									$navcartres = mysqli_query($connection, $navcartsql);
									$navcartr = mysqli_fetch_assoc($navcartres);
                            ?>

                                    <div class="ci-item">

                                        <img src="admin/<?php echo $navcartr['thumb']; ?>" width="70" alt=""/>

                                        <div class="ci-item-info">

                                            <h5><a href="single.php?id=<?php echo $navcartr['id']; ?>"><?php echo substr($navcartr['name'], 0 , 20); ?></a></h5>
                                            <p><?php echo $value['quantity']; ?> x $ <?php echo $navcartr['price']; ?></p>

                                            <div class="ci-edit">
                                                <a href="delcart.php?id=<?php echo $key; ?>" class="edit fa fa-trash"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php $total = $total + ($navcartr['price']*$value['quantity']);
                                } ?>
							
                            <div class="ci-total">Subtotal: $ <?php echo $total; ?></div>
							
                            <div class="cart-btn">
								<a href="cart.php">View Cart</a> <a href="checkout.php">Checkout</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</header>
