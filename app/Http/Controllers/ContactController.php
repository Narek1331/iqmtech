<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormMail;

class ContactController extends Controller
{
    public function sendEmail(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string|max:100',
        ]);

        $data = [
            'phone_number' => $request->input('phone_number'),
        ];

        try {
            Mail::to('iq-maxima@yandex.ru')->send(new ContactFormMail($data));

            return response()->json(['success' => 'Сообщение успешно отправлено']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Не удалось отправить сообщение. Попробуйте позже.'], 500);
        }
    }
}
