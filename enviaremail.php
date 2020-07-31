<?php
    $msg = "";
	use PHPMailer\PHPMailer\PHPMailer;
	include_once "PHPMailer/PHPMailer.php";
	include_once "PHPMailer/Exception.php";
	include_once "PHPMailer/SMTP.php";

	if (isset($_POST['submit'])) {
		$subject = $_POST['subject'];
		$email = $_POST['email'];
		$message = $_POST['message'];

		if (isset($_FILES['attachment']['name']) && $_FILES['attachment']['name'] != "") {
			$file = "upload/" . basename($_FILES['attachment']['name']);
			move_uploaded_file($_FILES['attachment']['tmp_name'], $file);
		} else
			$file = "";

		$mail = new PHPMailer();

	
		$mail->Host = "smtp.gmail.com";
		$mail->isSMTP();
		$mail->SMTPAuth = true;
		$mail->Username = "";
		// se seu pass tiver $ terá que separar em outra string e depois juntar
		//$dolarsign = '$';
		$mail->Password = "";
		$mail->SMTPSecure = "ssl"; //TLS
		$mail->Port = 465; //587

		$mail->addAddress('jukbala.lucas@gmail.com');
		$mail->setFrom($email);
		$mail->Subject = $subject;
		$mail->isHTML(true);
		$mail->Body = $message;
		$mail->addAttachment($file);

		if ($mail->send())
		    $msg = "Seu Email foi enviado com sucesso!";
		else
		    $msg = "Email não enviado, tente novamente!";

		unlink($file);
	}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulário de Contato SSD</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>
	<div class="container" style="margin-top: 100px">
		<div class="row justify-content-center">
			<div class="col-md-6 col-md-offset-3" align="center">
				<img src="imagens/logo.png"><br><br>

                <?php if ($msg != "") echo "$msg<br><br>"; ?>

				<form method="post" action="enviaremail.php" enctype="multipart/form-data">
					<input class="form-control" name="subject" placeholder="Assunto"><br>
					<input class="form-control" name="email" type="email" placeholder="Email"><br>
					<textarea placeholder="Mensagem" class="form-control" name="message"></textarea><br>
					<input class="form-control" type="file" name="attachment"><br>
					<input class="btn btn-primary" name="submit" type="submit" value="Enviar Email">
				</form>
			</div>
		</div>
	</div>
</body>
</html>