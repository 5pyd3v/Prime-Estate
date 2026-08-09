<?php
declare(strict_types=1);

final class Mailer
{
    public static function send(string $to, string $subject, string $body): bool
    {
        $fromEmail = (string) Settings::get('notify_email', env('SMTP_FROM_EMAIL', 'no-reply@example.com'));
        $fromName = (string) Settings::get('notify_from_name', env('SMTP_FROM_NAME', 'Website'));
        $host = (string) env('SMTP_HOST', '');

        try {
            if ($host !== '') {
                return self::sendSmtp($host, $to, $subject, $body, $fromEmail, $fromName);
            }
            $headers = "From: {$fromName} <{$fromEmail}>\r\nContent-Type: text/html; charset=UTF-8\r\n";
            return @mail($to, $subject, $body, $headers);
        } catch (Throwable $e) {
            error_log('Mailer error: ' . $e->getMessage());
            return false;
        }
    }

    private static function sendSmtp(string $host, string $to, string $subject, string $body, string $fromEmail, string $fromName): bool
    {
        $port = (int) env('SMTP_PORT', 587);
        $user = (string) env('SMTP_USER', '');
        $pass = (string) env('SMTP_PASS', '');

        $socket = @fsockopen($host, $port, $errno, $errstr, 10);
        if (!$socket) {
            error_log("SMTP connect failed: {$errstr}");
            return false;
        }

        $read = fn () => fgets($socket, 512);
        $write = function (string $cmd) use ($socket) {
            fwrite($socket, $cmd . "\r\n");
        };

        $read();
        $write('EHLO ' . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
        $read();

        if ((string) env('SMTP_ENCRYPTION', 'tls') === 'tls') {
            $write('STARTTLS');
            $read();
            stream_socket_enable_crypto($socket, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
            $write('EHLO ' . ($_SERVER['SERVER_NAME'] ?? 'localhost'));
            $read();
        }

        if ($user !== '') {
            $write('AUTH LOGIN');
            $read();
            $write(base64_encode($user));
            $read();
            $write(base64_encode($pass));
            $read();
        }

        $write("MAIL FROM:<{$fromEmail}>");
        $read();
        $write("RCPT TO:<{$to}>");
        $read();
        $write('DATA');
        $read();

        $headers = "From: {$fromName} <{$fromEmail}>\r\nTo: <{$to}>\r\nSubject: {$subject}\r\nContent-Type: text/html; charset=UTF-8\r\n";
        $write($headers . "\r\n" . $body . "\r\n.");
        $read();
        $write('QUIT');
        fclose($socket);

        return true;
    }
}
