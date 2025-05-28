<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::query();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_project', 'like', "%{$search}%")
                    ->orWhere('client', 'like', "%{$search}%");
            });
        }

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $projects = $query->latest()->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_project' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'nilai_project' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'deadline' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:baru,proses,selesai',
            'keterangan' => 'nullable|string'
        ]);

        Project::create($validated);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil ditambahkan');
    }

    public function show(Project $project)
    {
        $project->load('transaksi');
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'nama_project' => 'required|string|max:255',
            'client' => 'required|string|max:255',
            'nilai_project' => 'required|numeric|min:0',
            'tanggal_mulai' => 'required|date',
            'deadline' => 'required|date|after_or_equal:tanggal_mulai',
            'status' => 'required|in:baru,proses,selesai',
            'keterangan' => 'nullable|string'
        ]);

        $project->update($validated);

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil diperbarui');
    }

    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Project berhasil dihapus');
    }

    public function generateInvoice(Project $project)
    {
        $totalAmount = $project->nilai_project;

        // Get payment history
        $payments = $project->transaksi()
            ->where('jenis', 'pemasukan')
            ->orderBy('tanggal', 'asc')
            ->get();

        $existingPayments = $payments->sum('jumlah');
        $remainingAmount = $totalAmount - $existingPayments;

        // Format project description
        $description = $project->keterangan;
        $formattedDescription = [];

        if ($description) {
            // Split by numbered items
            preg_match_all('/(\d+\.\s*\*\*.*?\*\*.*?)(?=\d+\.\s*\*\*|$)/s', $description, $matches);

            if (!empty($matches[1])) {
                foreach ($matches[1] as $section) {
                    // Get section title
                    preg_match('/\*\*(.*?)\*\*/', $section, $titleMatch);
                    $title = $titleMatch[1] ?? '';

                    // Get section items
                    $items = [];
                    preg_match_all('/- (.*?)(?=- |$)/s', $section, $itemMatches);
                    if (!empty($itemMatches[1])) {
                        $items = array_map('trim', $itemMatches[1]);
                    }

                    if ($title) {
                        $formattedDescription[] = [
                            'title' => $title,
                            'items' => $items
                        ];
                    }
                }
            }
        }

        $invoiceNumber = 'INV/' . date('Ymd') . '/' . $project->id;

        return view('projects.invoice', compact(
            'project',
            'invoiceNumber',
            'remainingAmount',
            'formattedDescription',
            'totalAmount',
            'payments',
            'existingPayments'
        ));
    }

    public function generateTagihan(Project $project)
    {
        $totalAmount = $project->nilai_project;

        // Get payment history
        $payments = $project->transaksi()
            ->where('jenis', 'pemasukan')
            ->orderBy('tanggal', 'asc')
            ->get();

        $existingPayments = $payments->sum('jumlah');
        $remainingAmount = $totalAmount - $existingPayments;

        if ($remainingAmount <= 0) {
            return redirect()
                ->route('projects.show', $project)
                ->with('error', 'Project sudah lunas');
        }

        // Format project description seperti sebelumnya
        $description = $project->keterangan;
        $formattedDescription = [];
        // ... kode formatting description ...

        $tagihanNumber = 'TAG/' . date('Ymd') . '/' . $project->id;

        $pdf = PDF::loadView('projects.tagihan_pdf', [
            'project' => $project,
            'tagihanNumber' => $tagihanNumber,
            'remainingAmount' => $remainingAmount,
            'formattedDescription' => $formattedDescription,
            'totalAmount' => $totalAmount,
            'payments' => $payments,
            'existingPayments' => $existingPayments
        ]);

        return $pdf->download('tagihan-' . $project->nama_project . '-' . date('Ymd') . '.pdf');
    }

    public function generateNotaLunas(Project $project)
    {
        $totalAmount = $project->nilai_project;

        // Get payment history
        $payments = $project->transaksi()
            ->where('jenis', 'pemasukan')
            ->orderBy('tanggal', 'asc')
            ->get();

        $existingPayments = $payments->sum('jumlah');

        // Cek apakah sudah lunas
        if ($existingPayments < $totalAmount) {
            return redirect()
                ->route('projects.show', $project)
                ->with('error', 'Project belum lunas');
        }

        // Format project description seperti sebelumnya
        $description = $project->keterangan;
        $formattedDescription = [];
        // ... kode formatting description ...

        $notaNumber = 'NOTA/' . date('Ymd') . '/' . $project->id;
        $lastPayment = $payments->last();

        $pdf = PDF::loadView('projects.nota_lunas_pdf', [
            'project' => $project,
            'notaNumber' => $notaNumber,
            'formattedDescription' => $formattedDescription,
            'totalAmount' => $totalAmount,
            'payments' => $payments,
            'existingPayments' => $existingPayments,
            'lastPayment' => $lastPayment
        ]);

        return $pdf->download('nota-lunas-' . $project->nama_project . '-' . date('Ymd') . '.pdf');
    }

    public function generatePenawaran(Project $project)
    {
        $totalAmount = $project->nilai_project;

        // Format project description
        $description = $project->keterangan;
        $formattedDescription = [];

        if ($description) {
            // Split by numbered items
            preg_match_all('/(\d+\.\s*\*\*.*?\*\*.*?)(?=\d+\.\s*\*\*|$)/s', $description, $matches);

            if (!empty($matches[1])) {
                foreach ($matches[1] as $section) {
                    // Get section title
                    preg_match('/\*\*(.*?)\*\*/', $section, $titleMatch);
                    $title = $titleMatch[1] ?? '';

                    // Get section items
                    $items = [];
                    preg_match_all('/- (.*?)(?=- |$)/s', $section, $itemMatches);
                    if (!empty($itemMatches[1])) {
                        $items = array_map('trim', $itemMatches[1]);
                    }

                    if ($title) {
                        $formattedDescription[] = [
                            'title' => $title,
                            'items' => $items
                        ];
                    }
                }
            }
        }

        $penawaranNumber = 'PNW/' . date('Ymd') . '/' . $project->id;

        $pdf = PDF::loadView('projects.penawaran_pdf', [
            'project' => $project,
            'penawaranNumber' => $penawaranNumber,
            'formattedDescription' => $formattedDescription,
            'totalAmount' => $totalAmount
        ]);

        return $pdf->download('penawaran-' . $project->nama_project . '-' . date('Ymd') . '.pdf');
    }
}
