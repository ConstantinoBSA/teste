<?php

namespace Controllers;

use Core\Controller;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class AuthController extends Controller
{
    public function forgotPassword()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioModel = $this->model('Usuario');

            $email = $_POST['email'];
            // Verifique se o e-mail existe no banco de dados
            $user = $usuarioModel->findUserByEmail($email);
        
            if ($user) {
                // Gere um token único e seguro
                $token = bin2hex(random_bytes(50));
        
                // Armazene o token e o timestamp no banco de dados
                $usuarioModel->storeResetToken($email, $token);
        
                // Envie o e-mail com o link de redefinição de senha
                $resetLink = BASE_URL . "/reset-password?token=" . $token;

                // Configuração do transporte SMTP
                $transport = (new Swift_SmtpTransport('smtp.mailtrap.io', 2525))
                    ->setUsername('99c5f8322af3ec') // Substitua pelo seu usuário do Mailtrap
                    ->setPassword('ea30379349c54e'); // Substitua pela sua senha do Mailtrap

                // Criação do Mailer usando o transporte configurado
                $mailer = new Swift_Mailer($transport);

                $emailTemplate = file_get_contents('../resources/views/emails/redefinicao_senha.php');
                $emailContent = str_replace([
                        '{nome_usuario}',
                        '{reset_link}',
                    ], [
                        $user['name'],
                        $resetLink,
                    ], $emailTemplate);

                // Criação da mensagem
                $message = (new Swift_Message('Redefinição de Senha'))
                    ->setFrom(['no-reply@seusite.com' => 'Seu Site'])
                    ->setTo([$email => 'Usuário'])
                    ->setBody($emailContent, 'text/html');

                // Envio da mensagem
                $result = $mailer->send($message);

                // if ($result) {
                //     echo "Um link de redefinição de senha foi enviado para o seu e-mail.";
                // } else {
                //     echo "Houve um problema ao enviar o e-mail.";
                // }
        
                $_SESSION['flash_message'] = "Um link de redefinição de senha foi enviado para o seu e-mail.";
            } else {
                $_SESSION['flash_message'] = "E-mail não encontrado.";
            }

            header("Location: /forgot-password");
            // exit();
        } else {
            $this->view('auth/forgot-password');
        }
    }

    public function resetPassword()
    {
        session_start();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'];
            $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
        
            $usuarioModel = $this->model('Usuario');
        
            // Verifique se o token é válido e busque o e-mail associado
            $email = $usuarioModel->findEmailByToken($token);
        
            if ($email) {
                // Atualize a senha no banco de dados
                $usuarioModel->updatePassword($email, $newPassword);
        
                // Invalide o token
                $usuarioModel->invalidateToken($token);
        
                // Armazene uma mensagem de sucesso na sessão
                $_SESSION['message'] = "Sua senha foi redefinida com sucesso!";
                $_SESSION['message_type'] = "success";
            } else {
                // Armazene uma mensagem de erro na sessão
                $_SESSION['message'] = "Token inválido ou expirado!";
                $_SESSION['message_type'] = "error";
            }
        
            // Redirecione para a página de login ou outra página apropriada
            header("Location: /login");
            exit();
        } else {
            // Capture o token da URL
            $token = $_GET['token'] ?? null;

            $this->view('auth/reset-password', ['token' => $token]);
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioModel = $this->model('Usuario');
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $usuarioModel->getByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                header('Location: /');
                exit();
            } else {
                session_start();
                $_SESSION['error_message'] = "Usuário ou senha inválidos.";
                header('Location: /login');
                exit();
            }
        } else {
            $this->view('auth/login');
        }
    }

    public function logout()
    {
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
        exit();
    }
}
