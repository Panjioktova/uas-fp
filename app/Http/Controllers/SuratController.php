<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Surat;
use Codedge\Fpdf\Fpdf\Fpdf;
// use PDF;

class suratController extends Controller
{
    public function home()
    {
        $hasil = Surat::all();
        return view('home', ['data' => $hasil]);
    }
    public function tambah(Request $req)
    {
        $image = $req->file('file');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);
        $data = new Surat();
        $data->plat = $req->plat;
        $data->merk = $req->merk;
        $data->tipe = $req->tipe;
        $data->profileimage = $imageName;
        $data->save();
        return $this->home();
    }

    public function hapus($req)
    {
        $data = Surat::find($req);
        unlink(public_path('images') . '/' . $data->profileimage);
        $data->delete();

        return $this->home();
    }

    public function formUbah($req)
    {
        $hasil = Surat::find($req);
        return view('form-ubah-surat', ['data' => $hasil]);
    }
    public function ubah(Request $req)
    {
        $image = $req->file('file');
        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        $data =  Surat::find($req->id);
        $data->plat = $req->plat;
        $data->merk = $req->merk;
        $data->tipe = $req->tipe;
        $data->profileimage = $imageName;
        $data->save();
        return $this->home();
    }


    public function downloadPDF(Fpdf $pdf)
    {

        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 18);
        $pdf->MultiCell(0, 10, 'Report Data surat', 0, 'C');
        $pdf->Ln();
        // header
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(20, 10, 'No', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Nomor Surat', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Tanggal Surat', 1, 0, 'C');
        $pdf->Cell(50, 10, 'Judul Surat', 1, 0, 'C');
        $pdf->Ln();
        // data
        $data = Surat::all();

        $i = 1;
        foreach ($data as $d) {

            $pdf->Cell(20, 10, $i++, 1, 0, 'C');
            $pdf->Cell(50, 10, $d['plat'], 1, 0, 'C');
            $pdf->Cell(50, 10, $d['merk'], 1, 0, 'C');
            $pdf->Cell(50, 10, $d['tipe'], 1, 0, 'C');
            $pdf->Ln();
        }
        $pdf->Output();
        exit;
    }

    // public function downloadPDF(Request $req){
    //     $hasil = surat::all();
    //     $pdf = PDF::loadView('home', ['data' => $hasil]);
    //     return $pdf->download('report_laporan.pdf');
    // }
}
