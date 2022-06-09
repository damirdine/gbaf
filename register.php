<?php
include 'sql.php';

if(isset($_POST['name'],$_POST['firstname'],$_POST['username'],$_POST['secret_question_id'],$_POST['secret_answer']) && $_POST['password']===$_POST['confirm_password']){
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

        $addUserSqlREquest = "INSERT INTO users (name,firstname,username,password,secret_question_id,secret_answer) VALUES (:name, :firstname,:username,:password,:secretQuestionID,:secret_answer); ";
        $addUser = $db -> prepare($addUserSqlREquest);
        $addUser->execute(
        [
            'name'=> htmlspecialchars($_POST['name']),
            'firstname'=> htmlspecialchars($_POST['firstname']),
            'username'=> htmlspecialchars($_POST['username']), 
            'password'=> password_hash($_POST['password'],PASSWORD_BCRYPT),
            'secretQuestionID'=> htmlspecialchars($_POST['secret_question_id']),
            'secret_answer'=> password_hash($_POST['password'],PASSWORD_BCRYPT), 
        ]
        )or die(print_r($db->errorInfo()));

        $checkUserSqlREquest = "SELECT * FROM users WHERE username = :username;";
        $checkUser = $db -> prepare($checkUserSqlREquest);
        $checkUser->execute(
        [
            'username'=>$_POST['username'],
        ]
        )or die(print_r($db->errorInfo()));
        $user = $checkUser->fetch();

        $userSigned=$user['firstname'].' '.$user['name'];

        $_SESSION['logged_user_name'] = $userSigned;
        $_SESSION['logged_user'] = htmlspecialchars($user['username']);
        header("Refresh:0;");
    }

}
if($_POST['password']!==$_POST['confirm_password']){
    $errorSign = 'error form sign';
};
$getQuestionRequest = "SELECT * FROM secret_questions";
$getQuestions = $db -> prepare($getQuestionRequest);
$getQuestions->execute()or die(print_r($db->errorInfo()));
$secretQuestions = $getQuestions->fetchAll();


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
            <input type="text" class="form-control" id="name" name="name" aria-describedby="username-help" placeholder="John Doe" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Prenom</label>
            <input type="text" class="form-control" id="prenom" name="firstname" aria-describedby="username-help" placeholder="John Doe" required>
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" aria-describedby="username-help" placeholder="jhondoe" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type='password' class="form-control mb-3" placeholder="Votre mot de passe" id="password" name="password" required>
            <input type='password' class="form-control" placeholder="confirmer mot de passe" id="password" name="confirm_password" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Question secrète</label>
            <select class="form-select" name="secret_question_id" aria-label="Default select example">
                <option selected>Choisissez une question secrète </option>
                <?php foreach($secretQuestions as $secretQuestion):?>
                <option value="<?=$secretQuestion['id']?>"><?=$secretQuestion['question']?></option>
                <?php endforeach;?>
            </select>
            <input type='text' class="form-control" placeholder="Reponse à la question secret" id="password" name="secret_answer" required>
        </div>
        <button type="submit" class="btn btn-primary">S'inscrire</button>
    </form>
    <?php else:?>
        <p class="alert alert-success mt-4">Bienvenue <?= htmlspecialchars(($_SESSION['logged_user_name']))?>.</p> 
<?php endif; ?>

<?php include_once 'footer.php'?>