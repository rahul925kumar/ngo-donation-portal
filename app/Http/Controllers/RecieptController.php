<?php

namespace App\Http\Controllers;

use PDF;
use DB;
use ZipArchive;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecieptController extends Controller
{

    public function generateRecieptPdf(Request $request, $amount)
    {
        $user = auth()->user();
        $date = $request->query('date') ?? null;
        $data = [
            'user' => $user,
            'amount' => $amount,
            'amount_in_words' => $this->convertAmountToWords($amount),
            'date' => $date
        ];
        $pdf = PDF::loadView('donars.donation-reciept', $data);
        $filename = 'receipt-' . $user->id . '-' . Str::slug($user->name) . '.pdf';
        return $pdf->download($filename);
    }

    public function generateManualRecieptPdf($id)
    {
        $receipt = $receipt = DB::table('receipts')->join('users', 'receipts.phone_number', '=', 'users.phone_number')->where('receipts.id', $id)->first();
        if (!$receipt) {
            return response()->json(["error" => "Request Failed"]);
        }
        $data = [
            'user' => $receipt,
            'amount' => $receipt->amount,
            'amount_in_words' => $this->convertAmountToWords($receipt->amount),
            'date' => $receipt->created_at,
        ];
        $pdf = PDF::loadView('donars.donation-reciept', $data);
        $filename = 'receipt-' . $receipt->id . '-' . Str::slug($receipt->name) . '.pdf';
        return $pdf->download($filename);
    }

    public function sngleDownloadReciept(Request $request, $userId, $donarionId)
    {
        $tableName = $request->table_name ?? null;
        if ($tableName == 'donation') {
            $receipt = $receipt = DB::table('donation')->join('users', 'donation.phone_number', '=', 'users.phone_number')->where('users.id', $userId)->where('donation.id', $donarionId)->first();
        } else {
            $receipt = $receipt = DB::table('certificate_donation')->join('users', 'certificate_donation.number', '=', 'users.phone_number')->where('users.id', $userId)->where('certificate_donation.id', $donarionId)->first();
        }
        if (!$receipt) {
            return response()->json(["error" => "Request Failed"]);
        }
        $data = [
            'user' => $receipt,
            'amount' => $receipt->amount,
            'amount_in_words' => $this->convertAmountToWords($receipt->amount),
            'date' => $receipt->created_on,
        ];
        $pdf = PDF::loadView('donars.donation-reciept', $data);
        $filename = 'receipt-' . $receipt->id . '-' . Str::slug($receipt->name) . '.pdf';
        return $pdf->download($filename);
    }

    public function bulkDownloadReciept(Request $request)
    {
        $userId = $request->user_id;

        $receipt_one = $receipt = DB::table('donation')->join('users', 'donation.phone_number', '=', 'users.phone_number')->where('users.id', $userId)->get()->toArray();

        $receipt_two = $receipt = DB::table('certificate_donation')->join('users', 'certificate_donation.number', '=', 'users.phone_number')->where('users.id', $userId)->get()->toArray();

        $receipts = array_merge($receipt_one, $receipt_two);

        // return $receipts;

        if (empty($receipts)) {
            return response()->json(["error" => "No receipts found for the user."], 404);
        }

        $zipFileName = 'receipts_user_' . $userId . '.zip';
        $zipPath = storage_path('app/' . $zipFileName);

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($receipts as $key => $receipt) {
                $data = [
                    'user' => $receipt,
                    'amount' => $receipt->amount,
                    'date' => $receipt->created_on ?? $receipt->created_at,
                    'amount_in_words' => $this->convertAmountToWords($receipt->amount),
                ];

                $pdf = PDF::loadView('donars.donation-reciept', $data);
                $pdfName = 'receipt-' . $receipt->id . '-' . $key . '-' . Str::slug($receipt->name ?? 'user') . '.pdf';

                $tempPdfPath = storage_path("app/temp/{$pdfName}");
                Storage::put("temp/{$pdfName}", $pdf->output());

                $zip->addFile(storage_path("app/temp/{$pdfName}"), $pdfName);
            }

            $zip->close();
        } else {
            return response()->json(["error" => "Failed to create zip file."], 500);
        }

        // Clean up individual PDFs after zipping (optional)
        Storage::deleteDirectory('temp');

        // Download zip file
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function convertAmountToWords(float $amount): string
    {
        $number = floor($amount);
        $decimal = round(($amount - $number) * 100);

        $words = [
            0 => '',
            1 => 'One',
            2 => 'Two',
            3 => 'Three',
            4 => 'Four',
            5 => 'Five',
            6 => 'Six',
            7 => 'Seven',
            8 => 'Eight',
            9 => 'Nine',
            10 => 'Ten',
            11 => 'Eleven',
            12 => 'Twelve',
            13 => 'Thirteen',
            14 => 'Fourteen',
            15 => 'Fifteen',
            16 => 'Sixteen',
            17 => 'Seventeen',
            18 => 'Eighteen',
            19 => 'Nineteen',
            20 => 'Twenty',
            30 => 'Thirty',
            40 => 'Forty',
            50 => 'Fifty',
            60 => 'Sixty',
            70 => 'Seventy',
            80 => 'Eighty',
            90 => 'Ninety'
        ];

        $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];
        $str = [];
        $i = 0;

        while ($number > 0) {
            $divider = ($i == 1) ? 10 : 100;
            $currentNumber = $number % $divider;
            $number = (int)($number / $divider);

            if ($currentNumber) {
                $strPart = '';

                if ($currentNumber < 21) {
                    $strPart = $words[$currentNumber];
                } else {
                    $strPart = $words[(int)($currentNumber / 10) * 10] . ' ' . $words[$currentNumber % 10];
                }

                if ($strPart) {
                    $str[] = $strPart . ' ' . $digits[$i];
                }
            }
            $i++;
        }

        $rupees = trim(implode(' ', array_reverse(array_filter($str))));
        $rupees = $rupees ?: 'Zero';

        if ($decimal) {
            $paiseWords = '';
            if ($decimal < 21) {
                $paiseWords = $words[$decimal];
            } else {
                $paiseWords = $words[(int)($decimal / 10) * 10] . ' ' . $words[$decimal % 10];
            }
            return "$rupees Rupees and $paiseWords Paise Only";
        } else {
            return "$rupees Rupees Only";
        }
    }
}
