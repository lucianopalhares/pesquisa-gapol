<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Lang;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class MyResetPassword extends ResetPasswordNotification
{
      use Queueable;
      public $token;
      /**
      * Create a new notification instance.
      *
      * @return void
      */
      public function __construct($token)
      {
        $this->token = $token;
      }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
     public function toMail($notifiable)
     {
         if (static::$toMailCallback) {
             return call_user_func(static::$toMailCallback, $notifiable, $this->token);
         }

         return (new MailMessage)
             ->subject(Lang::get('Recuperação de Senha'))
             ->line(Lang::get('Você esta recebendo este email porque recebemos uma solicitação de recuperação de senha para sua conta.'))
             ->action(Lang::get('Resetar Senha'), url(config('app.url').route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
             ->line(Lang::get('Este link de recuperação irá expirar em :count minutos.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
             ->line(Lang::get('Se não foi você que soliticou, ignore este email.'));

     }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
