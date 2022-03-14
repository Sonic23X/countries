<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Country;
use App\Models\Idiom;
use App\Models\Token;
use File;

class CountryController extends Controller
{
    public function auth(Request $request)
    {
        // Validate fields
        $request->validate([
            'code' => 'required|string',
            'token' => 'required|string'
        ]);

        // Check if exists previous login
        $country = Token::where('countryCode', $request->code)->first();

        // No exists
        if ($country == null) {
            $token = Str::random(20);
            Token::create([
                'countryCode' => $request->code,
                'token' => $token
            ]);

            return response()->json(['access' => true, 'token' => $token], 200);
        }

        if ($country->token == $request->token)
            return response()->json(['access' => true, 'token' => $country->token], 200);
        else
            return response()->json(['access' => false, 'message' => 'Token no valid'], 401);

        return response()->json(['access' => false, 'message' => 'Token no valid'], 401);
    }

    public function new(Request $request)
    {
        if (isset($request->token)) {
            $actCountry = Token::where('token', $request->token)->first();
            if ($actCountry == null)
                return response()->json(['message' => 'Token no valid'], 401);

            // Validate fields
            $request->validate([
                'code' => 'required|string|max:3|unique:countries',
                'name' => 'required|string|unique:countries',
                'continent' => 'string',
                'population' => 'string'
            ]);

            // Make a row
            $country = Country::create([
                'code' => $request->code,
                'name' => $request->name,
                'continent' => $request->continent,
                'population' => $request->popilation
            ]);

            // Refresh token
            $token = Str::random(20);
            $actCountry->update([
                'token' => $token
            ]);

            return response()->json(['country' => $country, 'token' => $token], 201);
        } else
            return response()->json(['message' => 'Token not found'], 401);
    }

    public function update(Request $request, $code)
    {
        if (isset($request->token)) {
            $actCountry = Token::where('token', $request->token)->first();
            if ($actCountry == null)
                return response()->json(['message' => 'Token no valid'], 401);

            // Validate fields
            $request->validate([
                'name' => 'required|string|unique:countries',
                'continent' => 'string',
                'population' => 'string'
            ]);

            // Update a row
            $country = Country::where('code', $code)->update([
                'name' => $request->name,
                'continent' => $request->continent,
                'population' => $request->popilation
            ]);

            // Refresh token
            $token = Str::random(20);
            $actCountry->update([
                'token' => $token
            ]);

            return response()->json(['country' => $country, 'token' => $token], 200);
        } else
            return response()->json(['message' => 'Token not found'], 401);
    }

    public function destroy(Request $request, $code)
    {
        if (isset($request->token)) {
            $actCountry = Token::where('token', $request->token)->first();
            if ($actCountry == null)
                return response()->json(['message' => 'Token no valid'], 401);

            // Delete the row
            Country::where('code', $code)->delete();

            return response()->json(['message' => 'Country deleted',], 200);
        } else
            return response()->json(['message' => 'Token not found'], 401);
    }

    public function csv()
    {
        $headers = [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Content-Disposition' => 'attachment; filename=country.csv',
            'Expires' => '0',
            'Pragma' => 'public',
        ];


        //I am storing the csv file in public >> files folder. So that why I am creating files folder
        if (!File::exists(public_path() . "/files")) {
            File::makeDirectory(public_path() . "/files");
        }

        //creating the download file
        $filename =  public_path("files/country.csv");
        $handle = fopen($filename, 'w');

        //adding the first row
        fputcsv($handle, [
            'code',
            'name',
            'best oficial idiom',
            'percentage',
            'best not oficial idiom',
            'percentage'
        ]);

        foreach (Country::all() as $country) {
            $oficialIdiom = Idiom::where('countryCode', $country->code)
                ->where('isOfficial', 1)
                ->orderBy('percentage', 'desc')
                ->first();

            $notOficialIdiom = Idiom::where('countryCode', $country->code)
                ->where('isOfficial', 0)
                ->orderBy('percentage', 'desc')
                ->first();

            fputcsv($handle, [
                $country->code,
                $country->name,
                $oficialIdiom != null ? $oficialIdiom->language : 'N/A',
                $oficialIdiom != null ? $oficialIdiom->percentage : 'N/A',
                $notOficialIdiom != null ? $notOficialIdiom->language : 'N/A',
                $notOficialIdiom != null ? $notOficialIdiom->percentage : 'N/A'
            ]);
        }
        fclose($handle);

        //download command
        return response()->download($filename, "country.csv", $headers);
    }
}
