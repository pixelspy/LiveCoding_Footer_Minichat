<?php

/*
1) faire un require_once de vendor/phpmailer/phpmailer/PHPMailerAutoload.php
2) faire un contrôle de saisie (est-ce que le formulaire est soumis. Si oui est-ce qu'il est rempli)
3) s'il est validé et correctement rempli (expression régulière pour le format du mail), créer une nouvelle instance de classe (new PHPMailer)
4) préciser l'encodage du mail
5) le destinataire
6) l'expéditeur
7) pouvoir répondre à l'utilisateur
8) l'objet du mail
9) le corps du message
10) le message de confirmation en cas d'échec => <div class="alert alert-danger alert-dismissable"> <button type="button" class="close" data-dismiss="alert">&times;</button><strong></strong>Votre mail n\'a pas pu être envoyé ! Veuillez réessayer s\'il vous plaît !</div>
11) et de réussite de l'envoi du mail => <div class="alert alert-success alert-dismissable"> <button type="button" class="close" data-dismiss="alert">&times;</button><strong></strong>Votre mail a bien été envoyé !</div>
12) si le formulaire est mal rempli ou incomplet => <div class="alert alert-danger alert-dismissable"> <button type="button" class="close" data-dismiss="alert">&times;</button><strong></strong>Tous les champs sont obligatoires !</div>
*/

require_once 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

if (isset($_POST['submit'])) {
    if (isset($_POST['name'], $_POST['mail'], $_POST['message'])) {
        $name = htmlspecialchars($_POST['name']);
        $mail = htmlspecialchars($_POST['mail']);
        $message = htmlspecialchars($_POST['message']);

        if (!empty($name) && !empty($mail) && !empty($message) && preg_match('#^[\w.-]+@[\w.-]+\.[a-z]{2,6}$#i', $mail)) {
            $mail_send_success = new PHPMailer();
            $mail_send_success->CharSet = 'UTF-8';
            $mail_send_success->addAddress('mahana.delacour@gmail.com');
            $mail_send_success->setFrom($mail, 'formulaire@watchblog.com');
            $mail_send_success->Subject = 'Message venant de' .$name;
            $mail_send_success->Body = $message;
            $mail_send_success->AltBody = $message;

            if (!$mail_send_success->send()){
                echo '<div class="alert alert-danger alert-dismissable"> 
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong></strong>Votre mail n\'a pas pu être envoyé ! Veuillez réessayer s\'il vous plaît !
                </div>';
                echo 'Mailer error:' . $mail_send_success->ErrorInfo; // en cas d'échec d'envoi
            } else {
                echo '<div class="alert alert-success alert-dismissable"> 
                        <button type="button" class="close" data-dismiss="alert">&times;</button><strong></strong>Votre mail a bien été envoyé !
                      </div>';
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissable"> 
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <strong></strong>
                    Tous les champs sont obligatoires !
                  </div>';
        }
    }
}
