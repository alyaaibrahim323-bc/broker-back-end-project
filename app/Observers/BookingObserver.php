<?php

namespace App\Observers;

use App\Models\Booking;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;


class BookingObserver
{
    /**
     * Handle the Booking "created" event.
     */
    public function created(Booking $booking)
{
        \Log::info('Observer created() fired for booking ID: ' . $booking->id);

    // خذ رقم التليفون من الحجز مباشرةً
    $phone = $booking->phone_number ?? $booking->phone ?? null;

    if (!$phone) {
        \Log::warning('رقم التليفون غير موجود في بيانات الحجز رقم: ' . $booking->id);
        return;
    }

    // بيانات Twilio
    $sid    = env('TWILIO_SID');
    $token  = env('TWILIO_AUTH_TOKEN');
    $from   = env('TWILIO_FROM');

    $client = new Client($sid, $token);

    // تجهيز الرسالة
    $message = "تم تأكيد حجزك يوم: " . $booking->booking_date;

    try {
        $client->messages->create($phone, [
            'from' => $from,
            'body' => $message,
        ]);
        \Log::info('تم إرسال رسالة تأكيد الحجز إلى الرقم: ' . $phone);
    } catch (\Exception $e) {
        \Log::error('فشل إرسال الرسالة: ' . $e->getMessage());
    }
}


    /**
     * Handle the Booking "updated" event.
     */
    public function updated(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "deleted" event.
     */
    public function deleted(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "restored" event.
     */
    public function restored(Booking $booking): void
    {
        //
    }

    /**
     * Handle the Booking "force deleted" event.
     */
    public function forceDeleted(Booking $booking): void
    {
        //
    }
}
