<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendCareerEmail(array $data): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('career@einzigtech.com', 'Career | EinzigTech Website'))
            ->to(new Address('hr@einzigtech.com', 'HR | EinzigTech'))
            ->priority(Email::PRIORITY_HIGH)
            ->subject('Application from career page!')
            ->htmlTemplate('emails/job-application.html.twig')
            ->context($data)
        ;

        if ($data['cv']) {
            $email->attachFromPath($this->organizeUploadedFile($data['cv']));
        }

        $this->mailer->send($email);
    }

    public function sendContactEmail(array $data)
    {
        $email = (new TemplatedEmail())
            ->from(new Address('webcontact@einzigtech.com', 'Contact | EinzigTech Website'))
            ->to(new Address('contact@einzigtech.com', 'Contact | EinzigTech'))
            ->priority(Email::PRIORITY_HIGH)
            ->subject('New message from Website\'s contact page')
            ->htmlTemplate('emails/contact.html.twig')
            ->context($data)
        ;

        $this->mailer->send($email);
    }

    private function organizeUploadedFile(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME).'.'.$file->guessExtension();
        $uploadPath = __DIR__.'/../../var/upload';
        $file->move($uploadPath, $originalFilename);

        return $uploadPath.'/'.$originalFilename;
    }
}
