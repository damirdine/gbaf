<?php
include 'sql.php';
echo('<pre>');
var_dump($_POST);
echo('</pre>');
if(isset($_POST['name']) && isset($_POST['username']) && $_POST['password']===$_POST['confirm_password']){
    $checkUserSqlREquest = "SELECT * FROM users WHERE username = :username;";
    $checkUser = $db -> prepare($checkUserSqlREquest);
    $checkUser->execute(
        [
            'username'=>$_POST['username'],
        ]
    )or die(print_r($db->errorInfo()));
    $user = $checkUser->fetch();

    if($_POST['username']===$user['username']){
        $alreadySign = "Vous etes deja inscrit avec cet username (". $_POST['username'].")";
    }else{
        $addUserSqlREquest = "INSERT INTO users (name,username,password) VALUES (:name, :username, :password); ";
        $addUser = $db -> prepare($addUserSqlREquest);
        $addUser->execute(
        [
            'name'=> $_POST['name'],
            'username'=>$_POST['username'],
            'password'=> password_hash($_POST['password'],PASSWORD_BCRYPT),
        ]
        )or die(print_r($db->errorInfo()));

        $userSigned=$_POST['name'];
        $_SESSION['logged_user_name'] = $userSigned;
        $_SESSION['logged_user'] = $_POST['username'];
    }

}
if($_POST['password']!==$_POST['confirm_password']){
    $errorSign = 'error form sign';
};
?>
 <?php if(isset($alreadySign)):?>
        <p class="alert alert-warning mt-4"><?php echo(htmlspecialchars($alreadySign))?>.</p>
<?php endif; ?>
<?php if(isset($errorSign)):?>
        <p class="alert alert-warning mt-4"><?php echo(htmlspecialchars($errorSign))?>.</p>
<?php endif; ?>       
<?php if(!isset($_SESSION['logged_user_name'])):?>
     
    <form class="mt-4" action='./index.php' method="POST">
        <h1>Inscription</h1>
        <div class="mb-3">
            <label for="username" class="form-label">Nom</label>
            <input type="text" class="form-control" id="username" name="name" aria-describedby="username-help" placeholder="John Doe" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Prenom</label>
            <input type="text" class="form-control" id="username" name="first_name" aria-describedby="username-help" placeholder="John Doe" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" aria-describedby="username-help" placeholder="john.d@exemple.com" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type='password' class="form-control mb-3" placeholder="Votre mot de passe" id="password" name="password" required>
            <input type='password' class="form-control" placeholder="confirmer mot de passe" id="password" name="confirm_password" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Question secrète</label>
            <select class="form-select" name="secret_question" aria-label="Default select example">
                <option selected>Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
                </select>
            <input type='text' class="form-control" placeholder="Reponse à la question secret" id="password" name="sq_answer" required>
        </div>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
    <?php else:?>
        <p class="alert alert-success mt-4">Bienvenue <?php echo(htmlspecialchars(($_SESSION['logged_user_name'])))?>.</p> 
<?php endif; ?>

<?php include_once 'footer.php'?>