<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProcessImport;
use App\Jobs\ImportExcel;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Import;
use Exception;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * * process the imported file.
     *
     * @author Amr Gamal <amr.gamal878@email.com>
     * @param ProcessImport $request
     * @see https://phpspreadsheet.readthedocs.io/en/latest/topics/reading-and-writing-to-file/#reading-and-writing-to-file
     * @return Response
     */
    public function import(ProcessImport $request)
    {

        // * read file from request.
        $file = $request->file('sheet');


        // * calculate file extension for IOFactory to use.
        $extension = ucfirst($file->extension()); //* has to be either Xls or Xlsx.

        try {
            // * start file reading
            $reader = IOFactory::createReader($extension);

            $spreadsheet = $reader->load($file->getRealPath());

            // * get sheet rows
            $sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);


            // * validate sheet columns
            $invalidColumns = array_diff(['book title', 'description', 'author title'], array_values($sheetData[1]));

            if (!empty($invalidColumns)) {
                return redirect()->back()->with('danger', __('please make sure you uploaded excel file with these columns: book title, description, author title'));
            }

            $santizedData = [];

            for ($i =1; $i < count($sheetData); $i++) {
                if ($i == 1) {
                    continue;
                } // * skip columns row
                $item = [];
                $item['title'] = $sheetData[$i]['A'];
                $item['description'] = $sheetData[$i]['B'];
                $item['author'] = $sheetData[$i]['C'];
                // * prevent import rows with empty cells
                $emptyCell = array_search('', array_map('trim', array_values($item)), true);

                if ($emptyCell) {
                    continue; // * skip cell with empty value(s)
                }
                $santizedData[] = $item;
            }

            $importFile = Import::create([
                    'title'      => $file->getClientOriginalName(),
                    'rows'       => count($santizedData) ,
                    'startedAt'  => Carbon::now()
            ]);

            ImportExcel::dispatch($santizedData, $importFile);
  
            return redirect()->back()->with('success', __('file import is on progress!'));
        } catch (Exception $e) {
            return redirect()->back()->with('danger', __('error reading file!'));
        }
    }
}
