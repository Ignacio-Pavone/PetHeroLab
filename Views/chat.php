<?php
use Utils\Session;
use Utils\DateFormat as Format;
$user = Session::GetLoggedUser();
$type = $_SESSION['userType'];
require_once VIEWS_PATH . 'header.php';
require_once VIEWS_PATH . 'navbars/nav-simple-bar.php';
?>
<section style="height:100vh;" class="login-block">
    <main class="py-1">
        <div class="bg-light-alpha p-1 container" id="chat" >
            <br>
            <center>
                <h3 class="mb">Chat online</h3>
                <br>
            </center>

            <div class="bg-light-alpha p-1 container" style="overflow-y:scroll; height: 400px;">
                <?php foreach ($chats as $chat){ ?>

                    <?php if($chat->getSenderType()==$type) { ?>
                        <label for="" style="background-color:#7FFFD4; font-size:20px; padding:10px; margin-left:625px; border: 1px solid black; border-radius:10px"><?php echo $chat->getMessage(); ?></label>
                        <label for="" style="font-size:14px;"><?php echo $sender->getFullName(); ?></label>
                        <br/>
                    <?php } else { ?>
                        <label for="" style="background-color:#D3D3D3; font-size:20px; padding:10px; margin-left:325px; border: 1px solid black; border-radius:10px"><?php echo $chat->getMessage(); ?></label>
                        <label for="" style="font-size:14px;margin-top:15px"><?php echo $receiver->getFullName(); ?></label>
                        <br/>
                    <?php } ?>

                <?php } ?>
            </div>
            <br/>
            <div class="container" style="display:inline-block">
                <form action="<?php echo FRONT_ROOT.'Chat/Add' ?>" method="POST">
                    <textarea name="message" rows="2" cols="148" style=" margin-right:4px;margin-top:15px"></textarea>
                    <input type="hidden" name="idReceiver" value="<?php echo $id_receiver ?>">
                    <input type="hidden" name="idRequest" value="<?php echo $id_request ?>">
                    <input type="hidden" name="senderType" value="<?php echo $sender_type ?>">
                    <button type="submit" class="btn btn-login" style="width:100px;margin-left:10px; margin-bottom:5px">Enviar</button>
                </form>     
                <form action="<?php echo FRONT_ROOT.'Chat/refreshChat'?>" method="POST">
                    <input type="hidden" name="id_receiver" value="<?php echo $id_receiver ?>">
                    <input type="hidden" name="id_request" value="<?php echo $id_request ?>">
                    <input type="hidden" name="sender_type" value="<?php echo $sender_type ?>">      
                    <button type="submit" class="btn btn-login" style=" width:100px;margin-left:10px; margin-bottom:5px">Refrescar</button>
                </form>
            </div> 
        <br>
    </main>
                </section>
    <br>



