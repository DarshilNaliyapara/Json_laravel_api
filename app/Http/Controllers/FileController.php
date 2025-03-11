<?php
namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function index(File $file)
    {
        $files = File::all();
        return view('test.index', ['files' => $files]);
    }
    public function store(Request $request)
    {

        $request->validate([
            'file' => 'required|mimes:pdf,zip,jar,jpeg,jpg,gif,png|max:30000',
        ]);
        $file = $request->file('file');
        $name = $file->getClientOriginalName();
        $path = $request->file('file')->storeAs('files', $name, 'public');
        $url = Storage::url($path);
        logger(asset($url));
        File::create([
            'file_name' => $path,
        ]);
        return redirect(route('test.index'))->with('status', "File uploaded successfully");
    }
    public function destroy(string $id)
    {
        $file = File::find($id);
        if (!$file) {
            return redirect(route('test.index'))->with('error', "File not found.");
        }
        $path = "public/" . $file->file_name;
        if (Storage::exists($path)) {
            Storage::delete($path);

            $file->delete();
            return redirect(route('test.index'))->with('status', "File deleted successfully");
        } else {
            return redirect(route('test.index'))->with('error', "Failed to  delete File");
        }

    }
    public function fetchdata()
    {

        $docurl = "https://docs.google.com/spreadsheets/d/1y9MrdR_XAFGnbOJVNntOUei8pi1gmpEEeKocW6-7h5U/edit";
        preg_match('/\/d\/([^\/]+)/', $docurl, $matches);

        // Get the Sheet ID
        $sheetId = $matches[1] ?? '';
        $apiKey = "AIzaSyAZYO0WCI0OmZH_t3lPc5ruMGNAAY5b3oU";

        // Google Sheets API URL
        $url = "https://sheets.googleapis.com/v4/spreadsheets/$sheetId?fields=sheets.properties&key=$apiKey";

        // Make the request
        $response = Http::get($url)->json();
      
        foreach($response['sheets'] as $name){
            $sheetname[] = $name['properties']['title'];
        }
        dd($sheetname[0]);
        $url = "https://docs.google.com/spreadsheets/d/$sheetId/gviz/tq?tqx=out:json";


        $response = Http::get($url);
        //    dd($response);
        if ($response->getStatuscode() == 401) {
            return response()->json("unauthorize");
        }
        $body = $response->body();
        // dd($body);
        preg_match('/google.visualization.Query.setResponse\((.*)\);/', $body, $matches);

        $data = json_decode($matches[1] ?? '', true);

        $table = $data['table'] ?? null;
        dd($table['rows']);
        foreach ($table['rows'] as $row) {
            $formattedData[] = array_map(fn($cell) => $cell['v'] ?? '', $row['c']);
        }
        foreach ($formattedData as $data) {
            $userdata[] = $data;
        }
        dd($userdata);
        // print_r($userdata);
        foreach ($userdata as $data) {

            echo ("group_name=> " . $data[0]);
            echo ("<br>");
            echo ("group_url=> " . $data[1]);
            echo ("<br>");
            echo ("sheet_name=> " . $data[2]);
            echo ("<br>");
            echo ("frequency=> " . $data[3]);
            echo ("<br>");
            echo ("last_sent=> " . $data[4]);
            echo ("<br>");
            echo ("categories=> " . $data[5]);
            echo ("<br>");
            echo ("cta_caption=> " . $data[6]);
            echo ("<br>");
            echo ("cta_link=> " . $data[7]);
            echo ("<br>");
            echo ("sector_image=> " . $data[8]);
            echo ("<br>");
            echo ("sector_prompt=> " . $data[9]);
            echo ("<br>");
            echo ("<hr> ");

        }
    }
}