<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Penduduk;
use App\Models\Provinsi;
use Illuminate\Http\Request;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class LaporanController extends Controller
{

    public function index()
    {
        $provinsi = Provinsi::all();
        $kabupaten = Provinsi::all();

        $data = [
            'title' => 'Laporan Penduduk',
            'provinsi' => $provinsi,
            'kabupaten' => $kabupaten,
        ];
        return view('laporan.index', $data);
    }

    public function printProvinsi()
    {
        $penduduk_perprov = Provinsi::withCount('penduduk as total_penduduk_provinsi')->get();
        $pdf = FacadePdf::loadview('laporan/print_provinsi', ['penduduk_perprov' => $penduduk_perprov]);
        return $pdf->download('laporan-pegawai-pdf');
    }

    public function exportKabupaten($id)
    {
        if ($id == 0) {
            $penduduk_perkab = Kabupaten::withCount('penduduk as total_penduduk_kabupaten')->with('provinsi:id,nama')->get();
            $pdf = FacadePdf::loadview('laporan/print_kabupaten', ['penduduk_perkab' => $penduduk_perkab]);
            return $pdf->download('laporan-pegawai-pdf');
        } else {
            $penduduk_perkab = Kabupaten::withCount('penduduk as total_penduduk_kabupaten')->with('provinsi:id,nama')->where('provinsi_id', $id)->get();
            $pdf = FacadePdf::loadview('laporan/print_kabupaten', ['penduduk_perkab' => $penduduk_perkab]);
            return $pdf->download('laporan-pegawai-pdf');
        }
    }

    public function exportExcel()
    {
        // Buat objek spreadsheet
        $spreadsheet = new Spreadsheet();

        // STYLESHEET GLOBAL
        $StylesheetBorder = [
            'font' => [
                'size'  =>  10,
                'name'  =>  'Arial'
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ],

        ];

        ## BAGIAN TITLE ##
        $sheetTitle = $spreadsheet->getActiveSheet();
        $styleTitle = [
            'font' => [
                'bold'  =>  true,
                'size'  =>  15,
                'name'  =>  'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
        ];

        $sheetTitle->getStyle('A1:N1')->applyFromArray($styleTitle);
        $title = 'DATA PENDUDUK';
        $sheetTitle->setCellValue('A1', $title)->mergeCells('A1:N2');

        ## BAGIAN HEADER ##
        $sheetHeader = $spreadsheet->getActiveSheet();
        $styleHeader = [
            'font' => [
                'bold'  =>  true,
                'size'  =>  11,
                'name'  =>  'Arial'
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000']
                ]
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('rgb' => 'BFBFBF')
            ]
        ];

        $sheetHeader->getColumnDimension('A')->setWidth(9);
        $sheetHeader->getColumnDimension('B')->setWidth(34);
        $sheetHeader->getColumnDimension('C')->setWidth(24);
        $sheetHeader->getColumnDimension('D')->setWidth(22);
        $sheetHeader->getColumnDimension('E')->setWidth(22);
        $sheetHeader->getColumnDimension('F')->setWidth(48);
        $sheetHeader->getColumnDimension('G')->setWidth(22);
        $sheetHeader->getColumnDimension('H')->setWidth(22);
        $sheetHeader->getStyle('A3:H3')->applyFromArray($styleHeader);
        $sheetHeader->setAutoFilter('A3:H3');

        $sheetHeader->setCellValue('A3', 'No');
        $sheetHeader->setCellValue('B3', 'NAMA');
        $sheetHeader->setCellValue('C3', 'NIK');
        $sheetHeader->setCellValue('D3', 'TANGGAL LAHIR');
        $sheetHeader->setCellValue('E3', 'JENIS KELAMIN');
        $sheetHeader->setCellValue('F3', 'ALAMAT');
        $sheetHeader->setCellValue('G3', 'PROVINSI');

        $sheetHeader->setCellValue('H3', 'KABUPATEN');
        $sheetHeader->freezePane('A4');

        ## BAGIAN BODY ##
        $sheetBody = $spreadsheet->getActiveSheet();

        $penduduk = Penduduk::with('provinsi', 'kabupaten')->get();
        $no_row = 4;
        $no_urut = 1;

        foreach ($penduduk as $item) {
            $sheetBody->setCellValue('A' . $no_row, $no_urut)->getStyle('A' . $no_row)->applyFromArray($StylesheetBorder);
            $sheetBody->setCellValue('B' . $no_row, $item->nama)->getStyle('B' . $no_row)->applyFromArray($StylesheetBorder);
            $sheetBody->setCellValue('C' . $no_row, $item->nik)->getStyle('C' . $no_row)->applyFromArray($StylesheetBorder);
            $sheetBody->setCellValue('D' . $no_row, $item->tgl_lahir)->getStyle('D' . $no_row)->applyFromArray($StylesheetBorder);
            $sheetBody->setCellValue('E' . $no_row, $item->jns_kelamin)->getStyle('E' . $no_row)->applyFromArray($StylesheetBorder);
            $sheetBody->setCellValue('F' . $no_row, $item->alamat)->getStyle('F' . $no_row)->applyFromArray($StylesheetBorder);
            $sheetBody->setCellValue('G' . $no_row, $item->provinsi->nama)->getStyle('G' . $no_row)->applyFromArray($StylesheetBorder);
            $sheetBody->setCellValue('H' . $no_row, $item->kabupaten->nama)->getStyle('H' . $no_row)->applyFromArray($StylesheetBorder);
            $no_row++;

            $no_urut++;
        }

        // Konfigurasi header untuk file Excel
        $fileName = 'example.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $fileName . '"');
        header('Cache-Control: max-age=0');

        // Simpan file Excel
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');

        // Jangan lupa untuk mengakhiri eksekusi script setelah menyimpan file
        exit();
    }
}
