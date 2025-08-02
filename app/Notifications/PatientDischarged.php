<?php
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class PatientDischarged extends Notification
{
    public $discharge;

    public function __construct($discharge)
    {
        $this->discharge = $discharge;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
{
    $patient = $notifiable->patient ?? $notifiable;

    $pdf = Pdf::loadView('emails.discharge_summary', [
        'patient' => $patient,
        'discharge' => $this->discharge
    ]);

    $pdfPath = storage_path('app/public/discharge_summary.pdf');
    $pdf->save($pdfPath);

    // ✅ Register file delete after mail is sent
    register_shutdown_function(function () use ($pdfPath) {
        if (File::exists($pdfPath)) {
            File::delete($pdfPath);
        }
    });

    return (new MailMessage)
        ->subject('You have been discharged from the hospital')
        ->greeting('Hello ' . $notifiable->name)
        ->line('Please find your discharge summary attached as a PDF.')
        ->attach($pdfPath)
        ->salutation('Regards, Hospital Team');
}

}
