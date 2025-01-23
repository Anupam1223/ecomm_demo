<?php
    include 'config.php';
    session_start();


// COOKIE  CODE

// add products to cart
if(isset($_POST['addCart'])){

    $p_id = $_POST['addCart'];

    if(isset($_COOKIE['user_cart'])){

        $user_cart = json_decode($_COOKIE['user_cart']);
    }
    else{
        $user_cart = [];
    }

    if(!in_array($p_id,$user_cart)){
        array_push($user_cart,$p_id);
    }

    $cart_count = count($user_cart);
    $u_cart = json_encode($user_cart);

    if(setcookie('user_cart',$u_cart,time() + (1000),'/','','',TRUE)){
        setcookie('cart_count',$cart_count,time() + (1000),'/','','',TRUE);

        echo 'cookie set successfully';
        echo $_COOKIE['user_cart'];
        echo $_COOKIE['cart_count'];
    }else{
        echo 'false';
    }

}
// remove products from cart
if(isset($_POST['removeCartItem'])){
    $p_id = $_POST['removeCartItem'];
    
    if($_COOKIE['cart_count'] == '1'){
        setcookie('cart_count','',time() - (180),'/','','',TRUE);
        setcookie('user_cart','',time() - (180),'/','','',TRUE);
    }else{
        if(isset($_COOKIE['user_cart'])){
            $user_cart = json_decode($_COOKIE['user_cart']);
            if(is_object($user_cart)){
                $user_cart = get_object_vars($user_cart);
            }
            if (($key = array_search($p_id, $user_cart)) !== false) {
                unset($user_cart[$key]);
            }
        }
        $cart_count = count($user_cart);
        $u_cart = json_encode($user_cart);

        if(setcookie('user_cart',$u_cart,time() + (180),'/','','',TRUE)){
            setcookie('cart_count',$cart_count,time() + (180),'/','','',TRUE);
            echo 'cookie set successfully';
        }else{
            echo 'false';
        }
    }
}


//add to cart
if(isset($_POST['totalprice'])){

    $productprice = $_POST['price'];
    $productquantity = $_POST['quantity'];
    $productid = $_POST['product'];
    $totalprice = $_POST['totalprice'];
    $cusid = $_SESSION['id'];
    $token_for_cart = bin2hex(random_bytes(15));

    // To check whether user have already selected cart
    $sqlcart = "SELECT cart_id FROM CART WHERE customer_id = '$cusid' and token = '$token_for_cart'";
    $resultcart = oci_parse($conn, $sqlcart);
    oci_execute($resultcart);

    //checking whether it has cart value or not
    if($resultcart){
        $sqldelete = "DELETE FROM cart WHERE customer_id = '$cusid' and token = '$token_for_cart'";
        $resultdelete = oci_parse($conn, $sqldelete);
        oci_execute($resultdelete);
    }

    for($i=0; $i<=count($productid); $i++){

        if($i == count($productid)){
            echo json_encode(array('success'=>'added in cart')); exit;
        }

        $quantity = $productquantity[$i];
        $product = $productid[$i];
        $price = $productprice[$i];

        $sql = "INSERT INTO CART(quantity, customer_id, product_id, product_price, token) VALUES('$quantity','$cusid','$product','$price','$token_for_cart')";
        $result = oci_parse($conn, $sql);
        oci_execute($result);
        $_SESSION['tokenforcart'] = $token_for_cart;
    }
}
?>