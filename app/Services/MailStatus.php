<?php

namespace App\Services;

/**
 * Diagnóstico da configuração de e-mail (lida do .env do servidor).
 *
 * Com MAIL_MAILER=log ou array o Laravel não dá erro ao "enviar" — só grava
 * no log —, então checamos a configuração em vez de confiar na ausência de exceção.
 */
class MailStatus
{
    /** Mailers que não entregam e-mail de verdade. */
    protected const NON_DELIVERING = ['log', 'array'];

    public static function mailer(): string
    {
        return (string) config('mail.default');
    }

    public static function configured(): bool
    {
        return ! in_array(self::mailer(), self::NON_DELIVERING, true);
    }

    /**
     * @return array{mailer: string, host: ?string, port: ?string, from: ?string}
     */
    public static function summary(): array
    {
        $mailer = self::mailer();

        return [
            'mailer' => $mailer,
            'host' => config("mail.mailers.{$mailer}.host"),
            'port' => (string) config("mail.mailers.{$mailer}.port"),
            'from' => config('mail.from.address'),
        ];
    }
}
