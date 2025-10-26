<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    /**
     * FROM EMAIL CONFIGURATION
     * This is the email address that will appear as the sender
     * For production, use a real email address like noreply@yourdomain.com
     */
    public string $fromEmail  = 'noreply@yourdomain.com';
    
    /**
     * FROM NAME CONFIGURATION
     * This is the name that will appear as the sender
     */
    public string $fromName   = 'Your App Name';
    
    /**
     * RECIPIENTS (Optional)
     * Default recipients for testing purposes
     */
    public string $recipients = '';

    /**
     * USER AGENT
     * The "user agent" string sent with emails
     */
    public string $userAgent = 'CodeIgniter';

    /**
     * MAIL PROTOCOL
     * The mail sending protocol: mail, sendmail, smtp
     * For development, 'mail' works fine
     * For production, use 'smtp' for better reliability
     */
    public string $protocol = 'smtp';

    /**
     * The server path to Sendmail.
     */
    public string $mailPath = '/usr/sbin/sendmail';

    /**
     * SMTP SERVER CONFIGURATION
     * Configure these settings for your email provider
     * Common providers:
     * - Gmail: smtp.gmail.com
     * - Outlook: smtp-mail.outlook.com
     * - Yahoo: smtp.mail.yahoo.com
     */
    public string $SMTPHost = 'smtp.gmail.com';

    /**
     * SMTP USERNAME
     * Your email address for SMTP authentication
     */
    public string $SMTPUser = 'patelarjunphil@gmail.com';

    /**
     * SMTP PASSWORD
     * Your email password or app-specific password
     * For Gmail, use App Passwords (not your regular password)
     */
    public string $SMTPPass = 'vvfg tdho mdcx tlgm';

    /**
     * SMTP PORT
     * Common ports:
     * - 587 for TLS
     * - 465 for SSL
     * - 25 for non-encrypted (not recommended)
     */
    public int $SMTPPort = 587;

    /**
     * SMTP Timeout (in seconds)
     */
    public int $SMTPTimeout = 5;

    /**
     * Enable persistent SMTP connections
     */
    public bool $SMTPKeepAlive = false;

    /**
     * SMTP Encryption.
     *
     * @var string '', 'tls' or 'ssl'. 'tls' will issue a STARTTLS command
     *             to the server. 'ssl' means implicit SSL. Connection on port
     *             465 should set this to ''.
     */
    public string $SMTPCrypto = 'tls';

    /**
     * Enable word-wrap
     */
    public bool $wordWrap = true;

    /**
     * Character count to wrap at
     */
    public int $wrapChars = 76;

    /**
     * MAIL TYPE
     * Set to 'html' for rich email content with formatting
     * Set to 'text' for plain text emails
     */
    public string $mailType = 'html';

    /**
     * Character set (utf-8, iso-8859-1, etc.)
     */
    public string $charset = 'UTF-8';

    /**
     * Whether to validate the email address
     */
    public bool $validate = false;

    /**
     * Email Priority. 1 = highest. 5 = lowest. 3 = normal
     */
    public int $priority = 3;

    /**
     * Newline character. (Use “\r\n” to comply with RFC 822)
     */
    public string $CRLF = "\r\n";

    /**
     * Newline character. (Use “\r\n” to comply with RFC 822)
     */
    public string $newline = "\r\n";

    /**
     * Enable BCC Batch Mode.
     */
    public bool $BCCBatchMode = false;

    /**
     * Number of emails in each BCC batch
     */
    public int $BCCBatchSize = 200;

    /**
     * Enable notify message from server
     */
    public bool $DSN = false;
}
