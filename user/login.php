<?php include_once('header.php');
if(isset($_POST['password']) && isset($_POST['username'])){
    $checkUserSqlREquest = "SELECT * FROM users WHERE username = :username;";
    $checkUser = $db -> prepare($checkUserSqlREquest);
    $checkUser->execute(
        [
            'username'=>$_POST['username'],
        ]
    )or die(print_r($db->errorInfo()));
    $user = $checkUser->fetch();
    if($_POST['username']!==$user['username']){
        $userNotExist = 'Aucun compte lié a ce username. Veillez Créé un compte';
    }
    if(password_verify($_POST['password'],$user['password'])){
        $userLoggeded=$user['firstname'].' '.$user['name'];
        $_SESSION['logged_user_name'] = $userLogged;
        $_SESSION['logged_user'] = $user['username'];
        $_SESSION['logged_user_id'] = $user['id'];

    }else{
        $passworNotMatch = 'Mot de passe incorrect';
    };
}
?>

<?php if(!isset($_SESSION['logged_user_name'])):?>
    <?php if(isset($userNotExist)):?>
        <p class="alert alert-warning mt-4"><?php echo(htmlspecialchars($userNotExist))?>.</p>
    <?php elseif(isset($passworNotMatch)):?>
        <p class="alert alert-warning mt-4"><?php echo(htmlspecialchars($passworNotMatch))?>.</p>
    <?php endif;?>
    <form class="container m-5 d-grid gap-4" method='POST' action='../'>
        <h1>Connexion</h1>
        <div class="form-group">
            <label for="exampleInputEmail1">Mail</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="jhondoe@exemple.com">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Mot de passe</label>
            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Mot de passe">
        </div>
        <div class="form-group">       
            <button type="submit" class="btn btn-primary">Connexion</button>
        </div>
        <a class="mt-4" href="./user/register.php">S'inscrire</a>
    </form>
<?php else:?>
    <p class="alert alert-success mt-4"><?php echo('Bienvenue '.$_SESSION['logged_user_name'])?>.</p>
<?php endif;?>

<?php include_once('footer.php')?>