<?php

namespace App\Console\Commands;

use App\Models\Notification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\GenericNotification;
use Carbon\Carbon;

class ProcessNotifications extends Command
{
    protected $signature = 'notifications:process {--debug}';
    protected $description = 'Process pending notifications and send them via appropriate channels';

    public function handle()
    {
        $this->info('Starting notification processing...');
        Log::channel('notifications')->info('Notification processor started');

        $now = Carbon::now();
        $debug = $this->option('debug');

        // Get pending notifications
        $notifications = Notification::where('status', 'pending')
            ->where(function($query) use ($now) {
                $query->whereNull('scheduled_at')
                      ->orWhere('scheduled_at', '<=', $now);
            })
            ->whereNull('sent_at')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'asc')
            ->limit(100)
            ->get();

        $this->info("Found {$notifications->count()} pending notifications");
        Log::channel('notifications')->info("Processing {$notifications->count()} notifications");

        if ($notifications->isEmpty()) {
            $this->info('No notifications to process');
            Log::channel('notifications')->info('No pending notifications found');
            return Command::SUCCESS;
        }

        $successCount = 0;
        $failedCount = 0;

        foreach ($notifications as $notification) {
            try {
                if ($debug) {
                    $this->info("Processing notification ID: {$notification->id} [Type: {$notification->type}]");
                }

                Log::channel('notifications')->info("Processing notification", [
                    'id' => $notification->id,
                    'type' => $notification->type,
                    'channel' => $notification->delivery_channel
                ]);

                $this->processNotification($notification);
                $successCount++;

                if ($debug) {
                    $this->info("Successfully processed notification ID: {$notification->id}");
                }
            } catch (\Exception $e) {
                $errorMessage = "Failed to process notification {$notification->id}: " . $e->getMessage();
                
                $notification->update([
                    'status' => 'failed',
                    'response_data' => ['error' => $e->getMessage()],
                    'retry_count' => $notification->retry_count + 1
                ]);

                $this->error($errorMessage);
                Log::channel('notifications')->error($errorMessage, [
                    'notification_id' => $notification->id,
                    'exception' => $e
                ]);
                $failedCount++;
            }
        }

        $summary = "Processed {$successCount} notifications successfully, {$failedCount} failed";
        $this->info($summary);
        Log::channel('notifications')->info($summary);

        return Command::SUCCESS;
    }

    protected function processNotification(Notification $notification)
    {
        $startTime = microtime(true);
        
        try {
            switch ($notification->delivery_channel) {
                case 'email':
                    $this->sendEmailNotification($notification);
                    break;
                    
                case 'sms':
                    $this->sendSmsNotification($notification);
                    break;
                    
                case 'whatsapp':
                    $this->sendWhatsappNotification($notification);
                    break;
                    
                case 'push':
                    $this->sendPushNotification($notification);
                    break;
                    
                case 'in_app':
                    $this->sendInAppNotification($notification);
                    break;
                    
                default:
                    throw new \Exception("Unsupported delivery channel: {$notification->delivery_channel}");
            }
            
            $notification->update([
                'status' => 'sent',
                'sent_at' => now(),
                'response_data' => array_merge(
                    (array) $notification->response_data,
                    ['sent_at' => now()->toDateTimeString()]
                )
            ]);

            Log::channel('notifications')->info("Notification processed successfully", [
                'id' => $notification->id,
                'channel' => $notification->delivery_channel,
                'processing_time' => round(microtime(true) - $startTime, 2) . 's'
            ]);

        } catch (\Exception $e) {
            Log::channel('notifications')->error("Notification processing failed", [
                'id' => $notification->id,
                'channel' => $notification->delivery_channel,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    protected function sendEmailNotification(Notification $notification)
    {
        $recipients = [
            'to' => $notification->to_emails,
            'cc' => $notification->cc_emails ?? [],
            'bcc' => $notification->bcc_emails ?? []
        ];

        Log::channel('notifications')->debug("Preparing email notification", [
            'id' => $notification->id,
            'recipients' => $recipients,
            'subject' => $notification->subject
        ]);

        $mail = new GenericNotification(
            $notification->subject,
            $notification->body_html,
            $notification->body_text
        );
        
        Mail::to($notification->to_emails)
            ->cc($notification->cc_emails ?? [])
            ->bcc($notification->bcc_emails ?? [])
            ->send($mail);

        Log::channel('notifications')->info("Email sent successfully", [
            'id' => $notification->id,
            'recipients' => $recipients
        ]);
    }

    protected function sendSmsNotification(Notification $notification)
    {
        Log::channel('notifications')->debug("Preparing SMS notification", [
            'id' => $notification->id,
            'recipients' => $notification->to_numbers,
            'body' => $notification->body_text
        ]);

        $twilio = new \Twilio\Rest\Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        
        foreach ($notification->to_numbers as $number) {
            $message = $twilio->messages->create(
                $number,
                [
                    'from' => config('services.twilio.from'),
                    'body' => $notification->body_text
                ]
            );

            Log::channel('notifications')->info("SMS sent successfully", [
                'id' => $notification->id,
                'to' => $number,
                'message_sid' => $message->sid
            ]);
        }
    }

    protected function sendWhatsappNotification(Notification $notification)
    {
        Log::channel('notifications')->debug("Preparing WhatsApp notification", [
            'id' => $notification->id,
            'recipients' => $notification->to_numbers,
            'body' => $notification->body_text,
            'media_urls' => $notification->media_urls ?? []
        ]);

        $twilio = new \Twilio\Rest\Client(
            config('services.twilio.sid'),
            config('services.twilio.token')
        );
        
        foreach ($notification->to_numbers as $number) {
            $message = $twilio->messages->create(
                "whatsapp:$number",
                [
                    'from' => 'whatsapp:' . config('services.twilio.whatsapp_from'),
                    'body' => $notification->body_text,
                    'mediaUrl' => $notification->media_urls ?? []
                ]
            );

            Log::channel('notifications')->info("WhatsApp message sent successfully", [
                'id' => $notification->id,
                'to' => $number,
                'message_sid' => $message->sid
            ]);
        }
    }

    protected function sendPushNotification(Notification $notification)
    {
        Log::channel('notifications')->debug("Dispatching push notification", [
            'id' => $notification->id,
            'notifiable_id' => $notification->notifiable_id,
            'subject' => $notification->subject
        ]);

        event(new \App\Events\PushNotificationEvent(
            $notification->notifiable_id,
            $notification->subject,
            $notification->body_text,
            $notification->data
        ));

        Log::channel('notifications')->info("Push notification dispatched", [
            'id' => $notification->id
        ]);
    }

    protected function sendInAppNotification(Notification $notification)
    {
        Log::channel('notifications')->debug("Processing in-app notification", [
            'id' => $notification->id
        ]);

        $notification->update(['read_at' => now()]);

        Log::channel('notifications')->info("In-app notification marked as read", [
            'id' => $notification->id
        ]);
    }
}