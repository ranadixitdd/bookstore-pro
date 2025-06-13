<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Log;

class ProductImportController extends Controller
{
    public function showImportForm()
    {
        return view('admin.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');

        if (($handle = fopen($file->getRealPath(), 'r')) !== false) {
            $header = fgetcsv($handle, 1000, ','); // Skip header row
            $imported = 0;

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                try {
                    Product::create([
                        'title'       => $row[0],
                        'name'        => $row[1],
                        'author'      => $row[2],
                        'price'       => (float) $row[3],
                        'category_id' => (int) $row[4], // Using category_id directly
                        'description' => $row[5],
                        'category'    => $row[6], // Keeping category for reference
                        'image'       => $row[7],
                        'stock'       => (int) $row[8],
                        'best_seller' => (bool) $row[9],
                    ]);

                    $imported++;
                } catch (\Exception $e) {
                    Log::error("Import error on row {$imported}: " . $e->getMessage());
                }
            }

            fclose($handle);
            return redirect()->back()->with('success', "Imported {$imported} products successfully.");
        }

        return redirect()->back()->with('error', 'Could not open the file.');
    }
}
