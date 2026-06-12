<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SendNewsletterRequest;
use App\Mail\NewsletterCampaign;
use App\Models\Booking;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $query = NewsletterSubscriber::query();

        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->input('search') . '%');
        }

        $subscribers = $query->latest()->paginate(20)->withQueryString();

        $subscribersCount = NewsletterSubscriber::where('is_active', '=', true)->count();
        $bookersCount     = Booking::distinct()->count('email');
        $allCount         = NewsletterSubscriber::where('is_active', '=', true)
                                ->pluck('email')
                                ->merge(Booking::distinct()->pluck('email'))
                                ->unique()
                                ->count();

        return view('admin.subscribers.index', compact(
            'subscribers', 'subscribersCount', 'bookersCount', 'allCount'
        ));
    }

    public function sendNewsletter(SendNewsletterRequest $request)
    {
        $validated = $request->validated();
        $emails    = collect();

        if (in_array($validated['recipients'], ['subscribers', 'all'])) {
            $emails = $emails->merge(
                NewsletterSubscriber::where('is_active', '=', true)->pluck('email')
            );
        }

        if (in_array($validated['recipients'], ['bookers', 'all'])) {
            $emails = $emails->merge(
                Booking::distinct()->pluck('email')
            );
        }

        $emails = $emails->unique()->filter()->values();

        foreach ($emails as $email) {
            Mail::to($email)->queue(
                new NewsletterCampaign($validated['subject'], $validated['body'])
            );
        }

        return back()->with('success',
            __('admin.newsletter_sent', ['count' => $emails->count()])
        );
    }

    public function exportCsv()
    {
        return response()->streamDownload(function () {
            $handle = fopen('php://output', 'w');
            fprintf($handle, \chr(0xEF) . \chr(0xBB) . \chr(0xBF));
            fputcsv($handle, ['البريد الإلكتروني', 'تاريخ الاشتراك', 'الحالة']);

            NewsletterSubscriber::chunk(200, function ($rows) use ($handle) {
                foreach ($rows as $row) {
                    fputcsv($handle, [
                        $row->email,
                        $row->created_at->format('Y-m-d'),
                        $row->is_active ? 'نشط' : 'غير نشط',
                    ]);
                }
            });

            fclose($handle);
        }, 'subscribers_' . now()->format('Ymd') . '.csv', [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    public function destroy(NewsletterSubscriber $subscriber)
    {
        $subscriber->delete();
        return back()->with('success', 'تم حذف المشترك.');
    }
}
